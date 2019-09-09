<?php

namespace app\controllers;

use \widgets\category\Category;
use \app\models\Breadcrumbs;
use \store\Db;
use \app\models\ProductModel;
use \widgets\pagination\Pagination;
use \store\Register;

class CategoryController extends MainController
{
    public function indexAction()
    {
        $alias = $this->route['alias'];
        
        $categories = Category::get();



        $currentCategory = 'all';

        if($alias != 'all')
        foreach ($categories as $key => $cat) {
            if($cat['alias'] == $alias){
                $currentCategory = $categories[$key];
                $currentCategory['id'] = $key;
                break;
            }
        }

        if($currentCategory == null)
            throw new \Exception('Ошибка сервера', 500);

        $tree = $this->getTree($categories);

        if($currentCategory == 'all'){
            $this->setParams(['categoryTree' => $tree]);
            return;
        }

        if(($currentCategory['parent_id'] == 0) || ($categories[$currentCategory['parent_id']]['parent_id'] == 0)){
            //Главная категория
            if(!isset($tree[$currentCategory['id']])){
                foreach ($tree as $key => $value) {
                    if(isset($value['child'][$currentCategory['id']])){
                        $categoryTree[] = $value;
                        foreach ($categoryTree[0]['child'] as $key => $value) {
                            
                            if($currentCategory['id'] != $key)
                                unset($categoryTree[0]['child'][$key]);                  
                        }                   
                        break;
                    }
                }
            }else{
                $categoryTree[] = $tree[$currentCategory['id']];
            }
            
            $this->setParams(['categoryTree' => $categoryTree]);
        }else{
            //Котегория показывающая список товаров
            $this->view = 'products';
            $breadcrumbs = new Breadcrumbs($currentCategory['id'], $currentCategory['title']);

            $db = Db::getInstance();
            $model = new ProductModel;

            $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;

            $countProductOnePage = Register::get('config')['countProductOnePage'];
            $startProduct = ($currentPage - 1) * $countProductOnePage;
            
            $sql = "SELECT * FROM product WHERE category_id=? ORDER BY id LIMIT {$startProduct},9";
            $sqlCountProduct = "SELECT COUNT(*) FROM product WHERE category_id=?";    
            $products = $db->execute($sql, [$currentCategory['id']]);

            $countProduct = $db->execute($sqlCountProduct, [$currentCategory['id']])[0]['COUNT(*)'];
            
            $pagination = new Pagination($countProduct);
            

            if(!empty($products)){
                $products = $model->createDataProduct($products);
                
            }else{
                $products = [];
            }

            $this->setParams(['breadcrumbs' => $breadcrumbs, 'products' => $products, 'pagination' => $pagination]);
        }
       

    }

    private function getTree($categoies)
    {
        $tree = [];

        foreach ($categoies as $key => &$value) {
            if($value['parent_id'] == 0){
                $tree[$key] = &$value;  
            }else{
                $categoies[$value['parent_id']]['child'][$key] = &$value;
            }
        }

        return $tree;
    }
}