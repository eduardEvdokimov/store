<?php

namespace app\controllers;

use \app\interfaces\IWorkService;

class Google implements IWorkService
{
    public static function createUri($config)
    {
        $url = 'https://accounts.google.com/o/oauth2/auth';

        $params = array(
            'redirect_uri'  => HOST . '/login/service/google',
            'response_type' => 'code',
            'client_id'     => $config['client_id'],
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'

        );

        $resultUri = $url . '?' . urldecode(http_build_query($params));
        return $resultUri;
    }

    public function connectService()
    {
        $config = \store\Register::get('config')['google'];

        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'redirect_uri'  => HOST . '/login/service/google',
                'grant_type'    => 'authorization_code',
                'code'          => $_GET['code']
            );

            $url = 'https://accounts.google.com/o/oauth2/token';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($curl);
            curl_close($curl);
            $tokenInfo = json_decode($result, true);

        }else{
            return false;
        }

        if(isset($tokenInfo['access_token'])){
            $params['access_token'] = $tokenInfo['access_token'];

            $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);

            if(isset($userInfo['id'])){

                $resultData['email'] = $userInfo['email'];
                $resultData['name'] = $userInfo['name'];
                $resultData['password'] = password_hash($userInfo['id'], PASSWORD_DEFAULT);
                return $resultData;
            }
        }
        return false;

        /*

        $result = false;

        

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
        */
    }
}