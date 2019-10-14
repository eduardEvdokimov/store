<?php

namespace app\controllers;

use \app\models\ProductModel;
use \store\Register;
use \store\Db;

class ProductController extends MainController
{
    public function indexAction()
    {   
        $alias = isset($this->route['alias']) ? $this->route['alias'] : '';

        if(empty($alias)) throw new \Exception('Страница не найдена', 404);

        $model = new ProductModel;

        $product = $model->getData($alias);

        if(!$product) redirect(HOST);

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

        $product['rating'] = round($product['rating']);


        if(isset($_SESSION['user']) && $_SESSION['user']['auth']){
            $product['wishlist'] = WishlistController::check($product['id']);
        }else{
             $product['wishlist'] = false;
        }

        $commentsData = $this->getComments($alias);
        $countComments = $commentsData['countComments'];
        $comments = $commentsData['comments'];

        $issetComparison = ComparisonController::checkProduct($product['id']);

        $this->addViewed($product['id']);
        $this->setParams(['product' => $product, 'breadcrumbs' => $breadcrumbs, 'viewedProducts' => $viewedProducts, 'comments' => $comments, 'countComments' => $countComments, 'issetComparison' => $issetComparison]);
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

            $arrViewed[] = $productId;

            $newCookie = implode(',', array_reverse($arrViewed));
        }

        setcookie('viewedProducts', $newCookie, time() + 60 * 60 * 24 * 7, '/');
    }

    public function getComments($alias, $limit = 3, $term = '')
    {
        $db = Db::getInstance();
        if(empty($_SESSION['user']) || !$_SESSION['user']['auth']){
            $select= "SELECT CASE WHEN ( SELECT id FROM likes_comments WHERE comment_id = comments.id LIMIT 1) IS NOT NULL THEN 'like' ELSE 'like' END AS check_press_like, CASE WHEN ( SELECT id FROM dislikes_comments WHERE comment_id = comments.id LIMIT 1) IS NOT NULL THEN 'dislike' ELSE 'dislike' END AS check_press_dislike, comments.id, type, count_response, comment, good_comment, bad_comment, plus_likes, minus_likes, rating, date, comments.name FROM comments JOIN users ON comments.user_id = users.id WHERE comments.product_id =( SELECT id FROM product WHERE alias = ?) $term ORDER BY comments.date DESC LIMIT $limit";

        }else{
            $select = "SELECT CASE WHEN ( SELECT DISTINCT user_id FROM likes_comments WHERE comment_id = comments.id AND user_id={$_SESSION['user']['id']}) IS NOT NULL THEN 'press' ELSE 'like' END AS check_press_like, CASE WHEN ( SELECT DISTINCT user_id FROM dislikes_comments WHERE comment_id = comments.id AND user_id={$_SESSION['user']['id']}) IS NOT NULL THEN 'press' ELSE 'dislike' END AS check_press_dislike,  count_response, comments.id, type, comment, good_comment, bad_comment, plus_likes, minus_likes, rating, date, comments.name FROM comments JOIN users ON comments.user_id = users.id WHERE comments.product_id =( SELECT id FROM product WHERE alias = ?) $term ORDER BY comments.date DESC LIMIT $limit";
        }

        $comments = $db->execute($select, [$alias]);
        
        $countComments = $db->execute('SELECT COUNT(*) FROM comments JOIN users ON comments.user_id=users.id WHERE comments.product_id=(SELECT id FROM product WHERE alias=?)', [$alias])[0]['COUNT(*)'];

        $countComments = ($countComments > 0) ? $countComments : '';

        if(!empty($comments)){
            foreach ($comments as $key => $value) {
                $value['date'] = newFormatDate($value['date']);
                $stars = [];
                for($x = 0; $x < 5; $x++) {
                    if($x < $value['rating'])
                        $stars[] = '';
                    else
                        $stars[] = '-o';
                }
                $value['stars'] = $stars;

                $comments[$key] = $value;
            }
            
            return ['comments' => $comments, 'countComments' => $countComments];
        }
        return false;
    }

    public function commentsAction()
    {
        $db = Db::getInstance();

        $alias = isset($this->route['alias']) ? $this->route['alias'] : '';

        if(empty($alias)) throw new \Exception('Страница не найдена', 404);

        $model = new ProductModel;

        $product = $model->getData($alias);

        if(!$product) redirect(HOST);
        $term = '';
        if(isset($_GET['id']) && !empty($_GET['id']))
            $term = "AND comments.id={$_GET['id']}";

        $commentsData = $this->getComments($alias, 20, $term);
        $comments = $commentsData['comments'];
        $countComments = $db->execute('SELECT COUNT(*) FROM comments JOIN users ON comments.user_id=users.id WHERE comments.product_id=(SELECT id FROM product WHERE alias=?) ORDER BY date DESC', [$alias])[0]['COUNT(*)'];

        $this->setParams(['comments' => $comments, 'product' => $product, 'countComments' => $countComments]);
    }
}