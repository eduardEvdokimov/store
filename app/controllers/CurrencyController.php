<?php

namespace app\controllers;

class CurrencyController extends MainController
{

    public function changeAction()
    {
        $currency = $_GET['currency'];

        if(!empty($_SESSION['cart'])){
            
            $cart = json_decode($_SESSION['cart'], 1);
            CartController::recalc($cart, $currency);
        }

        setcookie('currency', $currency, time() + 60 * 60 * 24 * 2, '/');

        redirect();
    }
}

