<?php

namespace app\controllers;

use \store\Db;
use \app\models\ProductModel;
use \widgets\pagination\Pagination;
use \widgets\sort\Sort;
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
        $search = !empty($_GET['text']) ? trim($_GET['text']) : redirect();
        $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;
        $countProductOnePage = Register::get('config')['countProductSearchPage'];
        $startProduct = ($currentPage - 1) * $countProductOnePage;
        $countProduct = 0;
        $keySort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $sort = Sort::getTerm($keySort);

        if(empty($search)) redirect(HOST);

        $db = Db::getInstance();

        $products = $db->execute("SELECT * FROM product JOIN product_info ON product.id=product_info.id_product WHERE title LIKE (?) ORDER BY $sort LIMIT {$startProduct}, $countProductOnePage", ['%'.$search.'%']);

        if(!empty($products)){
            $countProduct = $db->execute('SELECT COUNT(*) FROM product WHERE title LIKE (?)', ['%'.$search.'%'])[0]['COUNT(*)'];
            $model = new ProductModel;
            $products = $model->createDataProduct($products);
        }

        $pagination = new Pagination($countProduct, $currentPage, $countProductOnePage);

        $this->setParams(['search' => $search, 'products' => $products, 'pagination' => $pagination, 'keySort' => $keySort]);

        if(isAjax()){
            $this->loadView();
        }
    }
}