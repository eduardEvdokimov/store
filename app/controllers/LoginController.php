<?php

namespace app\controllers;

use \store\Db;
use \app\models\Authorization;

class LoginController extends MainController
{
    public function indexAction()
    {
        $email = '';
        $password = '';
        $remember = '';

        if(isset($_SESSION['user']) && $_SESSION['user']['remember'] === 'true'){
            $email = $_SESSION['user']['email'];
            $password = $_SESSION['user']['password'];
            $remember = 'checked';
        }

        $this->setParams(['email' => $email, 'password' => $password, 'remember' => $remember]);
    }

    public function authAction()
    {
        $response = ['msg' => ' ', 'type' => ''];

        $db = Db::getInstance();

        $data = filterData($_POST);

        $user = $db->execute('SELECT * FROM `users` WHERE id = (SELECT user_id FROM emails WHERE email=?)', [$data['email']]);
        
        if(empty($user)){
            $response['msg'] = "Пользователь с данной <strong>{$data['email']}</strong> электронной почтой не зарегистрирован.";
            $response['type'] = 'error';
            die(json_encode($response));
        }

        $user = $user[0];
        $data['name'] = $user['name'];
        $data['id'] = $user['id'];

        if(!password_verify($data['password'], $user['password'])){
            $response['msg'] = "Введен неверный пароль!<br>Проверьте раскладку клавиатуры и Caps Lock";
            $response['type'] = 'error';
            die(json_encode($response));
        }

        Authorization::setSession($data);

        $response['type'] = 'success';

        die(json_encode($response));
    }

    public function logoutAction()
    {
        if(isset($_SESSION['user'])){
            $_SESSION['user']['auth'] = false;
        }
        $http = '';
        
        if(strpos($_SERVER['HTTP_REFERER'], 'profile'))
            $http = HOST;

        redirect($http);
    }
}