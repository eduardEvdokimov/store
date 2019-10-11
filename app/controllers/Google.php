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
    }
}