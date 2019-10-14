<?php

namespace app\controllers;

use \app\models\ProductModel;
require LIBS . '/simple_html_dom.php';

class ComparisonController extends MainController
{

    public function indexAction()
    {
        $comparison = self::get();

        if($comparison){
            $model = new ProductModel;
            foreach ($comparison as $category_id => $idsProduct) {
                $ids = implode(',', $idsProduct);
                $sql = "category_id=({$category_id})";
                if($category_id == 6){
                    $sql = "category_id IN (SELECT id FROM category WHERE parent_id ={$category_id})";
                }

                $comparisonProducts[$category_id] = $model->createDataProduct($this->db->query("SELECT product.* FROM product JOIN category ON category.id=product.category_id WHERE {$sql} AND product.id IN ($ids)"));

                $title = 'Ноутбуки';
                if($category_id != 6){
                    $title = $this->db->query("SELECT title FROM category WHERE id=$category_id")[0]['title'];   
                }

                $comparisonProducts[$category_id]['title'] = $title;
            }
        }else{
            $comparisonProducts = null;
        }

        $this->setParams(['comparison' => $comparisonProducts]);
    }

    public function addAction()
    {
        $id = $_POST['id'];

        $productData = $this->db->query("SELECT category_id, parent_id FROM product JOIN category ON category.id=product.category_id WHERE product.id={$id} LIMIT 1");

        if(!$productData) die('error');

        $category_id = $productData[0]['category_id'];

        if($productData[0]['parent_id'] == 6){
            $category_id = $productData[0]['parent_id'];
        }

        $cookie = !empty($_COOKIE['comparison']) ? json_decode($_COOKIE['comparison'], 1) : [];
            
        if(count($cookie[$category_id]) == 5)
            die(json_encode(['type' => 'max_lenght']));

        $cookie[$category_id][] = $id;

        if(setcookie('comparison', json_encode($cookie), time() + 60 * 60 * 24 * 7, '/'))
            die(json_encode(['type' => 'success']));
        die('error');
    }

    public static function checkProduct($product_id)
    {
        $comparison = !empty($_COOKIE['comparison']) ? json_decode($_COOKIE['comparison'], 1) : null;
        if($comparison){
            foreach ($comparison as $arrId) {
                if(in_array($product_id, $arrId)){
                    return true;
                }
            }
        }
        return false;
    }

    public static function getCount()
    {
        $comparison = !empty($_COOKIE['comparison']) ? json_decode($_COOKIE['comparison'], 1) : null;
        $count = 0;
        if($comparison){
            foreach ($comparison as $arrId) {
                $count += count($arrId);
            }
        }
        return $count;
    }

    public static function get()
    {
        return !empty($_COOKIE['comparison']) ? json_decode($_COOKIE['comparison'], 1) : null;
    }

    public function comparisonAction()
    {
        $key = $this->route['key'];
        $cookie = self::get();

        if(empty($cookie[$key]) || count($cookie[$key]) < 2) redirect();

        $ids = implode(',', $cookie[$key]);
        $products = $this->db->query("SELECT product.*, product_info.big_specifications FROM product JOIN product_info ON product.id=product_info.id_product WHERE product.id IN ($ids) ORDER BY product.id");
        
        if(!$products)
            redirect();

        $model = new ProductModel;
        $products = $model->createDataProduct($products);     

        $nameComparison = 'Ноутбуки';
        if($key != 6)
            $nameComparison = $this->db->query("SELECT title FROM category WHERE id=$key")[0]['title'];
        $nameComparison = mb_strtolower($nameComparison);

        $arrAllSpec = [];
        $arrSkipSpec = ['Краткие характеристики'];
        
        foreach ($products as $value) {

            $html = str_get_html($value['big_specifications']);

            foreach($html->find('p') as $p){
                $b = $p->find('b', 0);
                $spec = trim(trim($b->innertext), '&nbsp;');
                $val = trim(trim(preg_replace('#<b>.*</b>#', '', $p->innertext), '&nbsp;'));
                
                if(!in_array($spec, $arrAllSpec) && !in_array($spec, $arrSkipSpec))
                    $arrAllSpec[] = $spec; 
            }
            unset($html);
        }

        foreach ($products as $value){
            $html = str_get_html($value['big_specifications']);

            foreach($html->find('p') as $p){
                $b = $p->find('b', 0);
                $spec = trim(trim($b->innertext), '&nbsp;');
                $val = trim(trim(preg_replace('#<b>.*</b>#', '', $p->innertext), '&nbsp;'));
                
                if(in_array($spec, $arrAllSpec)){
                    $allSpec[$spec][$value['id']] = $val;
                }
            }
            unset($html);
        }
        
        foreach ($products as  $value) {
            foreach ($allSpec as $nameSpecif => &$valSpec) {
                if(!array_key_exists($value['id'], $valSpec)){
                    $valSpec[$value['id']] = '&mdash;';
                    $allSpec[$nameSpecif] = $valSpec;
                }
                ksort($valSpec);
            }
        }

        $this->setParams(['products' => $products, 'specs' => $allSpec, 'nameComparison' => $nameComparison]);
    }

    public function delItemAction()
    {
        if(!isAjax()) redirect();

        $comparison = self::get();

        unset($comparison[$_POST['key']][array_search($_POST['product_id'], $comparison[$_POST['key']])]);

        $checkOne = false;
        if(count($comparison[$_POST['key']]) == 1)
            $checkOne = true;


        $removeList = false;
        if(count($comparison[$_POST['key']]) < 1){
            $removeList = true;
            unset($comparison[$_POST['key']]);
        }

        if(setcookie('comparison', json_encode($comparison), time() + 60 * 60 * 24 * 7, '/'))
            die(json_encode(['type' => 'success', 'removeList' => $removeList, 'checkOne' => $checkOne]));

        die('error');

    }
}