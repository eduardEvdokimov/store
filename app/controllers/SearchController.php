<?php

namespace app\controllers;

use \store\Db;
use \app\models\ProductModel;
use \widgets\pagination\Pagination;
use \store\Register;

class SearchController extends MainController
{
    public function getAction()
    {
        if(isAjax()){
            
            $db = Db::getInstance();

            $suggestions = $db->execute("SELECT title AS value, alias AS data FROM product WHERE TITLE LIKE (?) LIMIT 7", ['%'.$_GET['s'].'%']);
            
            $result = ['suggestions' => $suggestions];
            echo json_encode($result);

        }else{
            throw new \Exception('Страница не найдена');
        }
        die;
    }

    public function indexAction()
    {
        $search = trim($_GET['text']);
        $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;
        $countProductOnePage = Register::get('config')['countProductSearchPage'];
        $startProduct = ($currentPage - 1) * $countProductOnePage;
        $countProduct = 0;

        if(empty($search)) redirect(HOST);

        $db = Db::getInstance();

        $products = $db->execute("SELECT * FROM product WHERE title LIKE (?) ORDER BY id LIMIT {$startProduct}, 12", ['%'.$search.'%']);

        if(!empty($products)){
            $countProduct = $db->execute('SELECT COUNT(*) FROM product WHERE title LIKE (?)', ['%'.$search.'%'])[0]['COUNT(*)'];
            $model = new ProductModel;
            $products = $model->createDataProduct($products);
        }

        $pagination = new Pagination($countProduct, 12);

        $this->setParams(['search' => $search, 'products' => $products, 'pagination' => $pagination]);
        
    }
}