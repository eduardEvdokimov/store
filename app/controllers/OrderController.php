<?php

namespace app\controllers;

use \app\models\{ProductModel, SignupModel, Authorization, Mail};

class OrderController extends MainController
{
    public function indexAction()
    {
        if(empty($_SESSION['cart'])) redirect();

        $model = new ProductModel;
        $data['count'] = $_SESSION['cart.count'];
        $data['summ'] = $model->recalcPrice($_SESSION['cart.summ']);
        $this->setParams(['order' => $data]);
    }

    public function checkoutAction()
    {
        $data = filterData($_POST);
        $data['notice'] = isset($data['notice']) ? $data['notice'] : null;

        if((isset($_SESSION['user']) && !$_SESSION['user']['auth']) || !isset($_SESSION['user'])){

            $user = $this->db->execute('SELECT * FROM users WHERE id=(SELECT user_id FROM emails WHERE email=?)', [$data['email']]);

            if(!empty($user)){
                //Если аккаунт существует
                $response['type'] = 'user_exist';
                die(json_encode($response));
            }

            $data['password'] = password_hash(md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL), PASSWORD_DEFAULT);
            $data['confirm'] = 0;
            $data['code_confirmed'] = md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL);

            $signup = new SignupModel;
            if(!($user_id = $signup->newUser($data, 'user'))){
                $response['type'] = 'error';
                die(json_encode($response));
            }

            $mail = new Mail($data['email']);
            $mail->sendConfirmEmail($data['code_confirmed'], true);

            $data['id'] = $user_id;
            $data['remember'] = false;
            $data['auth'] = true;
            $data['fast'] = true;
            Authorization::setSession($data);
        }

        $user_id = isset($user_id) ? $user_id : $_SESSION['user']['id'];
        $to = isset($data['email']) ? $data['email'] : $_SESSION['user']['email'];

        if(($order_id = $this->addOrder($user_id, $data['addr'], $data['notice'], $_SESSION['cart.summ'], $_SESSION['cart.count'])) !== false){
            $this->addProductsOrder($order_id, json_decode($_SESSION['cart'], 1));

            $mail = new Mail($to);
            $mail->sendCheckoutOrder(json_decode($_SESSION['cart'], 1));

            unset($_SESSION['cart']);
            unset($_SESSION['cart.count']);
            unset($_SESSION['cart.summ']);
            die(json_encode(['type' => 'success']));
        }

        die('error');

    }

    public function addOrder($user_id, $addr, $notice, $summ, $count)
    {
        $model = new ProductModel;
        $currCurrency = \store\Register::get('currentCurrency');

        $summ = $model->recalcPrice($summ);

        if($this->db->exec("INSERT INTO orders (user_id, currency, addr, notice, summ, count_product) VALUES ($user_id, '$currCurrency', '$addr', '$notice', $summ, $count)")){
            return $this->db->conn->lastInsertId();
        }
        return false;
    }

    public function addProductsOrder($order_id, $products)
    {
        $model = new ProductModel;

        foreach($products as $product){
            $price = $model->recalcPrice($product['price']);

            $this->db->exec("INSERT INTO order_product (order_id, product_id, qty, title, price, summ) VALUES ($order_id, {$product['id']}, {$product['count']}, '{$product['title']}', $price, {$product['summ']})");
        }
    }

    public function myAction()
    {
        if(isset($_SESSION['user']) && $_SESSION['user']['auth']){
            $orders = $this->db->query("SELECT orders.id, orders.number, orders.currency, orders.summ, orders.count_product, orders.date, orders.update_date FROM orders WHERE user_id={$_SESSION['user']['id']}");
            d($orders);

            if($orders){
                foreach ($orders as $key => $order) {
                    $products = $this->db->query("SELECT qty, title, price, summ FROM order_product WHERE id={$order['id']}");

                    $order['products'] = $products;
                    $orders[$key] = $order;
                }
                $this->setParams(['orders' => $orders]);
            }
            
            
        }else{
            redirect();
        }

        
        
        
    }
}