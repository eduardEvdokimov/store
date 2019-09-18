<?php

namespace app\controllers;

use \app\models\{SignupModel, Authorization};


class SignupController extends MainController
{
    public function indexAction()
    {
        
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

        if($this->create($data)){
            Authorization::setSession($data);

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
        $data['confirm'] = md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL);

        return $model->newUser($data);
    }
}