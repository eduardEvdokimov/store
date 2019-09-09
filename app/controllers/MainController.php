<?php

namespace app\controllers;

use \store\base\Controller;
use \store\Register;

class MainController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);

        $cart = CartController::getAll();
        
        $cart['cart'] = array_reverse($cart['cart']);

        $hiddenCounterCart = 'hidden';
        $countProductCart = 0;
        if(!empty($cart['cart'])){
            $hiddenCounterCart = '';
            $countProductCart = $cart['cart.count'];
        }

        $this->setParams(['cart' => $cart, 'simbolCurrency' => Register::get('simbolCurrency'), 'hiddenCounterCart' => $hiddenCounterCart, 'countProductCart' => $countProductCart]);
    }

    
} 