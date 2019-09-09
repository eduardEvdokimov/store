<?php

namespace app\controllers;

use \store\Db;
use \store\Register;

class CartController extends MainController
{
    public function addAction()
    {
        $db = Db::getInstance();
        $cart = !empty($_SESSION['cart']) ? json_decode($_SESSION['cart'], 1) : [];
        $cartSumm = !empty($_SESSION['cart.summ']) ? $_SESSION['cart.summ'] : 0;
        $cartCount = !empty($_SESSION['cart.count']) ? $_SESSION['cart.count'] : 0;
        $currencies = Register::get('currencies');
        $currentCurrency = Register::get('currentCurrency');
        $product = '';
        $id = $_POST['id'];

        

        foreach ($cart as $key => $item)
            if($item['id'] == $id){
                $product = $item;
                $keyIssetProduct = $key;
                break;
            }
        
        if(!$product){
            $product = $db->execute('SELECT * FROM product WHERE id=?', [$id])[0];
            $product['count'] = 1;


            foreach ($currencies as $key => $currency) {
                if($currency['name'] == $currentCurrency){
                    $currentCurrency = $currency;
                }
            }
            
            $product['price'] = round($product['price'], 2);

            if(!$currentCurrency['base']){
                $product['price'] = round($currentCurrency['value'] * $product['price'], 2);
            }
            $product['summ'] = $product['price'];
            $cart[] = $product;

        }else{
            $product['count']++;
            $product['summ'] = round($product['summ'] + $product['price'], 2);
            $cart[$keyIssetProduct] = $product;
        }
        
        $cartSumm = round($product['price'] + $cartSumm, 2);
        $cartCount++;
        $_SESSION['cart.count'] = $cartCount;
        $_SESSION['cart.summ'] = $cartSumm;
        
        $_SESSION['cart'] = json_encode($cart);
        $result['cart.count'] = $cartCount;
        $result['cart.summ'] = $cartSumm;
        $result['products'] = $cart;

        echo json_encode($result); 
        die;
    }

    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.summ']);
        unset($_SESSION['cart.count']);
    }

    public static function getAll()
    {
        $result['cart'] = !empty($_SESSION['cart']) ? json_decode($_SESSION['cart'], 1) : '';
        $result['cart.summ'] = !empty($_SESSION['cart.summ']) ? $_SESSION['cart.summ'] : '';
        $result['cart.count'] = !empty($_SESSION['cart.count']) ? $_SESSION['cart.count'] : '';
        return $result;
    }

    public function delItemAction()
    {
        $idProduct = $_POST['id'];
        
        $cart = json_decode($_SESSION['cart'], 1);
        $summCart = $_SESSION['cart.summ'];
        $countCart = $_SESSION['cart.count'];
        
        foreach ($cart as $key => $item) {
            if($item['id'] == $idProduct){
                unset($cart[$key]);
                $summCart = round($summCart - $item['summ'], 2);
                $countCart -= $item['count'];
                break;
            }
        }

        if(empty($cart)){
            $this->clearAction();
        }else{
            $_SESSION['cart.count'] = $countCart;
            $_SESSION['cart'] = json_encode($cart);
            $_SESSION['cart.summ'] = $summCart;
        }

        $result['summCart'] = $summCart;
        $result['countCart'] = $countCart;
        echo json_encode($result);
    }

    public function delCountProductAction()
    {
        $idProduct = $_POST['id'];

        $cart = json_decode($_SESSION['cart'], 1);
        $summCart = $_SESSION['cart.summ'];
        $countCart = $_SESSION['cart.count'];

        foreach ($cart as $key => $value) {
            if($value['id'] == $idProduct){
                $value['count']--;
                $value['summ'] = round($value['summ'] - $value['price'], 2);
                $cart[$key] = $value;
                $summCart = round($summCart - $value['price'], 2);
                $countCart--;
                $_SESSION['cart'] = json_encode($cart);
                $_SESSION['cart.summ'] = $summCart;
                $_SESSION['cart.count'] = $countCart;
                $result['cartSumm'] = $summCart;
                $result['cartCount'] = $countCart;
                $result['product'] = $value;
                echo json_encode($result);
                exit;
            }
        }

        echo '';
        die;
    }

    public function addCountProductAction()
    {
        $idProduct = $_POST['id'];

        $cart = json_decode($_SESSION['cart'], 1);
        $summCart = $_SESSION['cart.summ'];
        $countCart = $_SESSION['cart.count'];

        foreach ($cart as $key => $value) {
            if($value['id'] == $idProduct){
                $value['count']++;
                $value['summ'] = round($value['summ'] + $value['price'], 2);
                $cart[$key] = $value;
                $summCart = round($summCart + $value['price'], 2);
                $countCart++;
                $_SESSION['cart'] = json_encode($cart);
                $_SESSION['cart.summ'] = $summCart;
                $_SESSION['cart.count'] = $countCart;
                $result['cartSumm'] = $summCart;
                $result['cartCount'] = $countCart;
                $result['product'] = $value;
                echo json_encode($result);
                exit;
            }
        }

        echo '';
        die;


    }

    public static function recalc($cart, $newCurrency)
    {
        $oldCurrency = $_COOKIE['currency'];
        $currencies = Register::get('currencies');

        foreach ($currencies as $value) {
            if($newCurrency == $value['name']){
                $newCurrency = $value;
            }

            if($oldCurrency == $value['name']){
                $oldCurrency = $value;
            }
        }
        
        $cartSumm = !empty($_SESSION['cart.summ']) ? $_SESSION['cart.summ'] : 0;

        if($oldCurrency['base']){
            //перевод из базовой в не базовую
            
            foreach($cart as $product){
                $product['price'] = round($product['price'] * $newCurrency['value'], 2);
                $product['summ'] = round($product['summ'] * $newCurrency['value'], 2);
                $finalCart[] = $product;
            }

            $cartSumm = round($cartSumm * $newCurrency['value'], 2);
        }else{
            //перевод из не базовой в базовую или из не базовой в небазовую
            
            foreach($cart as $product){
                $product['price'] = round(($product['price'] / $oldCurrency['value']) * $newCurrency['value'], 2);
                $product['summ'] = round(($product['summ'] / $oldCurrency['value']) * $newCurrency['value'], 2);
                $finalCart[] = $product;
            }
            $cartSumm = round(($cartSumm / $oldCurrency['value']) * $newCurrency['value'], 2);
        }

        $_SESSION['cart'] = json_encode($finalCart);
        $_SESSION['cart.summ'] = $cartSumm;
       
    }
}