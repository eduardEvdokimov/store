<?php

namespace app\controllers;

use \store\base\Controller;
use \store\{Register, Db};


class MainController extends Controller
{
    protected $db;

    public function __construct($route)
    {
        parent::__construct($route);
        $db = Db::getInstance();
        $this->db = $db;
        $wishCount = 0;

        $cart = CartController::getAll();
        if(isset($_SESSION['user']) && $_SESSION['user']['auth'])
            $wishCount = WishlistController::getCount();

        $cart['cart'] = array_reverse($cart['cart']);

        $hiddenCounterCart = 'hidden';
        $countProductCart = 0;
        if(!empty($cart['cart'])){
            $hiddenCounterCart = '';
            $countProductCart = $cart['cart.count'];
        }

        $userAuth = false;
        $nameDrpMenuUser = 'Мой аккаунт';
        if(isset($_SESSION['user']['auth']) && $_SESSION['user']['auth'] == true){
            $userAuth = true;
            $nameDrpMenuUser = $_SESSION['user']['name'];
        }

        $comparisonCount = ComparisonController::getCount();

        $this->setParams(['cart' => $cart, 'userAuth' => $userAuth, 'simbolCurrency' => Register::get('simbolCurrency'), 'hiddenCounterCart' => $hiddenCounterCart, 'countProductCart' => $countProductCart, 'nameDrpMenuUser' => $nameDrpMenuUser, 'wishCount' => $wishCount, 'comparisonCount' => $comparisonCount]);
    }

    
} 