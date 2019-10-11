<?php

namespace app\controllers;

use \store\Db;
use \app\models\ProductModel;

class WishlistController extends MainController
{
    public function addProductAction()
    {
        if(!$_POST || !$_POST['id'])
            die('error');

        $db = Db::getInstance();

        $wishlist = $db->query("SELECT * FROM wishlists WHERE user_id={$_SESSION['user']['id']} AND type_def=1");

        if($wishlist){
            $db->exec("INSERT INTO wishlist_product (list_id, product_id) VALUES ({$wishlist[0]['id']}, {$_POST['id']})");
            die(json_encode(['type' => 'success']));
        }else{
            $db->exec("INSERT INTO wishlists (user_id, name, type_def) VALUES ({$_SESSION['user']['id']}, 'Мой список желаний', 1)");

            $wishlist_id = $db->conn->lastInsertId();

            $db->exec("INSERT INTO wishlist_product (list_id, product_id) VALUES ($wishlist_id, {$_POST['id']})");
            die(json_encode(['type' => 'success']));
        }
        die('error');
    }

    public static function getCount()
    {
        $db = Db::getInstance();

        $count = $db->query("SELECT COUNT(*) FROM wishlist_product WHERE list_id IN (SELECT id FROM wishlists WHERE user_id={$_SESSION['user']['id']})");
        return !empty($count) ? $count[0]['COUNT(*)'] : 0;
    }

    public static function check($product_id)
    {
        $db = Db::getInstance();

        if($db->query("SELECT * FROM `wishlist_product` WHERE list_id IN (SELECT id FROM wishlists WHERE user_id={$_SESSION['user']['id']}) AND product_id=$product_id"))
            return true;
        return false;
    }

    public function addListAction()
    {
        if(!isAjax()) redirect();

        $data = filterData($_POST);

        if($this->issetList($_SESSION['user']['id'])){
            $sql = "INSERT INTO wishlists (user_id, name, type_def) VALUES ({$_SESSION['user']['id']}, '{$data['name']}', '0')";
            $default = false;
        }else{
            $sql = "INSERT INTO wishlists (user_id, name, type_def) VALUES ({$_SESSION['user']['id']}, '{$data['name']}', '1')";
            $default = true;
        }

        if($this->db->exec($sql)){
            $id = $this->db->conn->lastInsertId();
            die(json_encode(['type' => 'success', 'name' => $data['name'], 'default' => $default, 'id' => $id]));
        }

        die('error');
        
    }

    public function issetList($user_id)
    {
        $db = Db::getInstance();

        if(!empty($db->query("SELECT * FROM wishlists WHERE user_id=$user_id")))
            return true;
        return false;
    }

    public function removeAction()
    {
        if(!isAjax()) redirect();

        $lists = $this->db->query("SELECT COUNT(*) FROM wishlists WHERE user_id={$_SESSION['user']['id']}");

        if($this->db->exec("DELETE FROM wishlists WHERE id={$_POST['id']}")){
            if($lists[0]['COUNT(*)'] > 1){
                if($this->db->exec("UPDATE wishlists SET type_def='1' WHERE user_id={$_SESSION['user']['id']} LIMIT 1"))
                    die(json_encode(['type' => 'success']));
            }
            die(json_encode(['type' => 'success']));
        }
        die('error');
    }

    public function newDefaultAction()
    {
        if(!isAjax()) redirect();

        $this->db->conn->beginTransaction();
        $this->db->exec("UPDATE wishlists SET type_def=0 WHERE user_id={$_SESSION['user']['id']} AND type_def=1");
        $this->db->exec("UPDATE wishlists SET type_def=1 WHERE id={$_POST['id']}");
        if($this->db->conn->commit()){
            die(json_encode(['type' => 'success']));
        }
        die('error');
    }

    public function changeNameAction()
    {
        if(!isAjax()) redirect();

        $data = filterData($_POST);

        if($this->db->exec("UPDATE wishlists SET name='{$data['name']}' WHERE id={$data['id']}"))
            die(json_encode(['type' => 'success', 'name' => $data['name']]));

        die('error');
    }

    public function delItemAction()
    {
        if($this->db->exec("DELETE FROM wishlist_product WHERE list_id={$_POST['list_id']} AND product_id={$_POST['product_id']}")){

            $dataProduct = $this->db->query("SELECT SUM(price), COUNT(price) FROM product WHERE id IN(SELECT product_id FROM wishlist_product WHERE list_id={$_POST['list_id']})");

            $summ = 0;
            $count = 0;
            if($dataProduct[0]['COUNT(price)'] > 0){
                $model = new ProductModel();
                $summ = $model->recalcPrice($dataProduct[0]['SUM(price)']);
                $count = $dataProduct[0]['COUNT(price)'];
            }
            die(json_encode(['type' => 'success', 'summ' => $summ, 'count' => $count]));
        }

        die('error');
    }    

    public function delProductsAction()
    {
        if($this->db->exec("DELETE FROM wishlist_product WHERE list_id={$_POST['list_id']} AND product_id IN ({$_POST['product_ids']})")){
            die(json_encode(['type' => 'success']));
        }
        die('error');
    }
}