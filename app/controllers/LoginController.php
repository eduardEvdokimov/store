<?php

namespace app\controllers;

use \store\Db;
use \app\models\{Authorization, Mail, SignupModel};


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

        $id = \store\Register::get('config')['vk']['id'];

        $urlVk = "https://oauth.vk.com/authorize?client_id={$id}&redirect_uri=".HOST."/login/service/vk&scope=4194304&response_type=code&v=5.52";

        $urlGoogle = Google::createUri(\store\Register::get('config')['google']);
        



        $this->setParams(['email' => $email, 'password' => $password, 'remember' => $remember, 'urlVk' => $urlVk, 'urlGoogle' => $urlGoogle]);
    }

    public function authAction()
    {
        $response = ['msg' => ' ', 'type' => ''];

        $db = Db::getInstance();

        $data = filterData($_POST);

        $user = $db->execute('SELECT users.*, confirm, code_confirmed FROM `users` JOIN emails ON users.id=emails.user_id WHERE emails.email=?', [$data['email']]);
        
        if(empty($user)){
            $response['msg'] = "Пользователь с данной <strong>{$data['email']}</strong> электронной почтой не зарегистрирован.";
            $response['type'] = 'error';
            die(json_encode($response));
        }

        $user = $user[0];
        $data['name'] = $user['name'];
        $data['id'] = $user['id'];
        $data['confirm'] = $user['confirm'];
        $data['auth'] = true;

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

    public function restorePasswordAction()
    {

    }

    public function restoreAction()
    {
        $response = [];

        if(!isAjax()) redirect(HOST);

        $data = filterData($_POST);

        $db = Db::getInstance();

        $user = $db->execute('SELECT emails.email, users.* FROM emails JOIN users ON emails.user_id=users.id WHERE emails.email=?', [$data['email']]);

        if(empty($user)){
            $response['msg'] = "Пользователь с данной почтой <b>{$data['email']}</b> не найден.";
            $response['type'] = 'error';
            die(json_encode($response));
        }

        $user = $user[0];

        $code = mt_rand(1000000, 9999999);

        if($db->exec("UPDATE users SET restore_pass_code=$code WHERE id={$user['id']}")){

            $mail = new Mail($user['email']);
            $mail->sendRestorePassword($user['email'], $user['name'], $code);

            $response['type'] = 'success';
            die(json_encode($response));
        }
    }

    public function checkCodeRestoreAction()
    {
        $response = [];

        if(!isAjax()) redirect(HOST);

        $data = filterData($_POST);

        $db = Db::getInstance();

        $user = $db->execute('SELECT emails.email, users.* FROM users JOIN emails ON users.id=emails.user_id WHERE restore_pass_code=?', [$data['code']]);


        if(empty($user)){
            $response['msg'] = "Не верный код подтверждения";
            $response['type'] = 'error';
            die(json_encode($response));
        }

        $user = $user[0];

        if($db->exec("UPDATE users SET restore_pass_code=null WHERE id={$user['id']}")){

            $db->exec("UPDATE emails SET confirm=1, code_confirmed=null WHERE user_id={$user['id']}");

            $user['auth'] = true;
            $user['confirm'] = true;
            $user['remember'] = $_SESSION['user']['remember'];
            $user['restore_pass'] = true;
            Authorization::setSession($user);

            $response['type'] = 'success';
            die(json_encode($response));
        }
    }

    public function serviceAction()
    {
        if(empty($this->route['alias'])) redirect(HOST);

        $serviceName = ucfirst($this->route['alias']);

        $className = "\app\controllers\\$serviceName";

        $service = new $className;
        
        $user = $service->connectService();
       
        if(!$user){
            echo 'Произошла ошибка.';
            sleep(3);
            redirect(HOST . '/login');
        }

        $this->authInService($user);
    }

    private function authInService($userData)
    {

        $db = Db::getInstance();

        $user = $db->query("SELECT email, users.* FROM emails JOIN users ON users.id=emails.user_id WHERE email='{$userData['email']}'");

        if(empty($user)){
            $user = $userData;
            $model = new SignupModel;
            $user['confirm'] = 1;
            $user['code_confirmed'] = null;
            $user['id'] = $model->newUser($user, 'user');
        }else{
            $user = $user[0];
        }
        
        $user['confirm'] = true;
        $user['auth'] = true;
        Authorization::setSession($user);
        redirect(HOST . '/profile');

    }
}