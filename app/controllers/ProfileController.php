<?php

namespace app\controllers;

class ProfileController extends MainController
{
    public function indexAction()
    {

    }

    public function cartAction()
    {
        $cart = CartController::getAll();
        $this->setParams(['cart' => $cart]);
    }


    public function viewedAction(){}

    public function desiresAction(){}

    public function ordersAction(){}

    public function commentsAction(){}

    public function changePasswordAction(){}
}