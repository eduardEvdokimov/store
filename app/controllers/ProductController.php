<?php

namespace app\controllers;

use \app\models\ProductModel;
use \store\Register;

class ProductController extends MainController
{
    public function indexAction()
    {   
        $alias = isset($this->route['alias']) ? $this->route['alias'] : '';

        if(empty($alias)) throw new \Exception('Страница не найдена', 404);

        $model = new ProductModel;

        $product = $model->getData($alias);
        
        $breadcrumbs = new \app\models\Breadcrumbs($product['category_id'], $product['title']);
        
        $viewedProducts = isset($_COOKIE['viewedProducts']) ? $_COOKIE['viewedProducts'] : '';

        if(!empty($viewedProducts)){
            $viewedProductsData = $model->db->query("SELECT * FROM product WHERE id IN ($viewedProducts)");

            if(strpos($viewedProducts, ',') !== false)
                $arrViewedProducts = explode(',', $viewedProducts);
            else
                $arrViewedProducts = [$viewedProducts];

            foreach ($viewedProductsData as $key => $value) {
                $viewedProductsData[$value['id']] = $value;
            }

            $count = 0;
            
            foreach ($viewedProductsData as $key => $value) {
                if(isset($arrViewedProducts[$count]))
                    $sortViewedProducts[] = $viewedProductsData[$arrViewedProducts[$count]];
                $count++;
                if($count == 8) break;
            }

            $viewedProducts = $model->createDataProduct($sortViewedProducts);
        }


        $this->addViewed($product['id']);
        $this->setParams(['product' => $product, 'breadcrumbs' => $breadcrumbs, 'viewedProducts' => $viewedProducts]);
        $this->setMeta($product['title'], $product['meta_description'], $product['meta_keywords']);
    }


    private function addViewed($productId)
    {
        $cookie = isset($_COOKIE['viewedProducts']) ? $_COOKIE['viewedProducts'] : '';
        $newCookie = $productId;

        if(!empty($cookie)){

            if(strpos($cookie, ',')){
                $arrViewed = explode(',', $cookie);
            }else{
                $arrViewed = [$cookie]; 
            }

            if(array_search($productId, $arrViewed) !== false) return;

            if(count($arrViewed) > 7){
                unset($arrViewed[6]);
            }

            $arrViewed[] = $productId;

            $newCookie = implode(',', array_reverse($arrViewed));
        }

        setcookie('viewedProducts', $newCookie, time() + 60 * 60 * 24 * 7, '/');
    }

    public function addToCartAction()
    {
        echo '+';
        exit;
    }
}