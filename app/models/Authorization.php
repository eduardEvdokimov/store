<?php

namespace app\models;

class Authorization extends MainModel
{
    public static function setSession($data)
    {
        
        $session = [
            'user' => [
                'restore_pass' => false,
                'confirm' => false,
                'auth' => false,
                'remember' => false,
                'fast' => false,
                'role' => 'user',
                'date_registration' => '',
            ]
        ];

        foreach ($session['user'] as $key => $value) {
            if(array_key_exists($key, $data)){
                $session['user'][$key] = $data[$key];
            }
        }

        foreach ($session as $key => $value) {
            if(!is_array($value)){
                if(array_key_exists($key, $data)){
                    $session[$key] = $data[$key];
                }
            }
        }

        $user = [
            'id' => $data['id'], 
            'email' => $data['email'],  
            'name' => $data['name'], 
            'password' => $data['password'],

        ];

        $session = array_merge($session['user'], $user);

        $_SESSION['user'] = $session;
    }
}