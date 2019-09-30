<?php

namespace app\controllers;

use \app\models\{SignupModel, Authorization, Mail};
use \store\Db;

class SignupController extends MainController
{
    public function indexAction()
    {
        $id = \store\Register::get('config')['vk']['id'];

        $urlVk = "https://oauth.vk.com/authorize?client_id={$id}&redirect_uri=".HOST."/login/service/vk&scope=4194304&response_type=code&v=5.52";

        $urlGoogle = Google::createUri(\store\Register::get('config')['google']);
        
        $this->setParams(['urlVk' => $urlVk, 'urlGoogle' => $urlGoogle]);
    }

    public function newAction()
    {
        $response = ['msg' => '', 'type' => '', 'error' => ''];

        $data = filterData($_POST);

        if(!isAjax()) die;

        if($this->isEmail($data['email']) === false){
            $response['error'] = 'email';
            $response['type'] = 'valid';
            $response['msg'] = 'Электронная почта введена не корректно';
            echo json_encode($response);
            die;
        }

        if(!$this->checkExistEmail($data['email'])){
            $response['error'] = 'email';
            $response['type'] = 'exist';
            $response['msg'] = "Пользователь с электронной почтой <strong>{$data['email']}</strong> уже зарегистрирован.<br><a href=''>Забыли пароль?</a>";
            echo json_encode($response);
            die;
        }

        if(($confirmData = $this->create($data))){
            $data['id'] = $confirmData['user_id'];
            $data['auth'] = true;
            Authorization::setSession($data);

            $mail = new Mail($data['email']);
            
            $mail->sendConfirmEmail($confirmData['confirm']);

            $response['type'] = 'success';
            echo json_encode($response['type']);
        }else{
            echo 'Error';
        }
        die;
    }

    private function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function checkExistEmail($email)
    {
        $model = new SignupModel;
        return $model->checkExistMail($email);
    }

    private function create($data)
    {
        $model = new SignupModel;
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['confirm'] = 0;
        $data['code_confirmed'] = md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL);

        return ['confirm' => $data['code_confirmed'], 'user_id' => $model->newUser($data, 'user')];
    }

    public function add($data)
    {
        $model = new SignupModel;
        $data['password'] = password_hash(md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL), PASSWORD_DEFAULT);
        $data['confirm'] = md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL);
        return $model->newUser($data);
    }

    public function confirmAction()
    {
        if(!isset($_GET['code']) || empty($_GET['code']))
            redirect(HOST);

        

        $code = $_GET['code'];

        $db = Db::getInstance();

        $check = $db->execute('SELECT email FROM emails WHERE code_confirmed=?', [$code]);
        

        if(empty($check) || $check[0]['email'] != $_SESSION['user']['email'])
            redirect(HOST);

        if($db->execute('UPDATE emails SET confirm=1, code_confirmed=null WHERE code_confirmed=?', [$code])){
           
            $_SESSION['user']['confirm'] = true;
            $_SESSION['user']['confirm_action'] = true;
            if(isset($_GET['fast'])){
                redirect(HOST . '/profile/add-password');
                die;
            }else{
                redirect(HOST . '/profile');
            }
            
        }
        redirect(HOST);
    }

}