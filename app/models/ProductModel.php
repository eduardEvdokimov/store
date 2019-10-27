<?php

namespace app\models;

use \store\Register;


class ProductModel extends MainModel
{
    public function createChangedButton()
    {
        $visibleCategory = Register::get('config')['category_index_page_slider'];
        foreach ($visibleCategory as $key => $value) 
            $visibleCategory[$key] = "'$value'";

        $visibleCategorySql = implode(',', $visibleCategory);
        $category = $this->db->query("SELECT id, title FROM category WHERE alias IN ($visibleCategorySql)");
        return $category;
    }

    public function getProductSlider($selectedCategory)
    {
       
        foreach ($selectedCategory as $key => $value) {
            $checkParent = $this->db->query("SELECT id FROM category WHERE parent_id={$value['id']}");

            if(!empty($checkParent)){
                $products = $this->db->query("SELECT * FROM product WHERE category_id IN (SELECT id FROM category WHERE parent_id = '{$value['id']}') AND (hit=1 OR new=1 OR old_price > 0) LIMIT 8");
            }else{
                $products = $this->db->query("SELECT * FROM product WHERE category_id={$value['id']} AND (hit=1 OR new=1 OR old_price > 0) LIMIT 8");
            }

            $result[$value['title']] = $this->createDataProduct($products);
        }
        return $result;
    }

    public function createDataProduct($products)
    {
        foreach ($products as $key => $product){
            if(strlen($product['title']) > 30){
                $product['small_title'] = mb_substr($product['title'], 0, 30) . '...';
            }else{
                $product['small_title'] = $product['title'];
            }

            $product['price'] = $this->recalcPrice($product['price']);
            $product['old_price'] = $this->recalcPrice($product['old_price']);
                

            if($product['old_price'] > 0){
                $discout = round((($product['old_price'] - $product['price']) * 100) / $product['old_price']);
                $product['sticker'] = "<div class='new-tag'><h6>{$discout}%</h6></div>";
            }elseif($product['hit'] > 0){
                $product['sticker'] = "<div class='new-tag'><h6>Топ</h6></div>";
            }elseif($product['new'] > 0){
                $product['sticker'] = "<div class='new-tag'><h6>Новый</h6></div>";
            }else{
                $product['sticker'] = '';
            }

            $product['old_price'] = ($product['old_price'] != 0) ? $product['old_price'] : ''; 

            $result[] = $product;
        }
        return $result;
    }

    public function recalcPrice($price)
    {
        if($price > 0){
            foreach (Register::get('currencies') as  $currency) {
                if($currency['name'] == Register::get('currentCurrency')){
                    $currentCurrency = $currency;
                    break;
                }
            }
            $price *= $currentCurrency['value'];
            
            return round($price, 2);
        }
        return 0;
        
    }

    public function getData($alias)
    {
        $data = $this->db->execute('SELECT * FROM product JOIN product_info ON id=id_product WHERE alias=?', [$alias]);
        
        if(empty($data)) return false;

        $data = $data[0];
        $data['price'] = $this->recalcPrice($data['price']);
        $data['old_price'] = $this->recalcPrice($data['old_price']);
        if($data['old_price'] > 0){
            $data['discount'] = round((($data['old_price'] - $data['price']) * 100) / $data['old_price']);
        }

        $data['hrefs_img'] = explode(',', $data['hrefs_img']);
        return $data;
    }

}