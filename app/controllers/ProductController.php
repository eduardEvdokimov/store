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
        
        
        $this->setParams(['product' => $product, 'breadcrumbs' => $breadcrumbs]);
        $this->setMeta($product['title'], $product['meta_description'], $product['meta_keywords']);
    }
}