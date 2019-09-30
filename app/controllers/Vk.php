<?php

namespace app\controllers;

use \app\interfaces\IWorkService;

class Vk implements IWorkService
{
    public function connectService()
    {
        $result = false;

        $config = \store\Register::get('config')['vk'];

        //Проверяем пришел ли код для получения access_token
        if(!$_GET['code'])
            return $result;


        //Получаем токен и попутно мыло пользователя
        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=' . $config['id'] . '&client_secret=' . $config['secret'] . '&redirect_uri=' . HOST . '/login/service/vk&code=' . $_GET['code']), true);

        if(!$token)
            return $result;

        //Получаем данные пользователя ВК
        $data = json_decode(file_get_contents('https://api.vk.com/method/users.get?&user_id=' . $token['user_id'] . '&access_token=' . $token['access_token'] . '&v=5.52&fields=uid'), true);

        if(!$data)
            return $result;

        //Если у пользователя ВК нет подтверждения по мылу не идем дальше
        if(!isset($token['email'])){
            return $result;
        }

        $name = $data['response'][0]['first_name'] . ' ' . $data['response'][0]['last_name'];
        $password = password_hash($data['response'][0]['id'], PASSWORD_DEFAULT);
        $result = ['email' => $token['email'], 'name' => $name, 'password' => $password];
        
        return $result;
    }
}