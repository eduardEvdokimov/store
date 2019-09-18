<?php

namespace app\models;

class Authorization extends MainModel
{
    public static function setSession($data)
    {
        $user = ['user' => ['email' => $data['email'], 'remember' => $data['remember'], 'name' => $data['name'], 'password' => $data['password'], 'auth' => true]];
        $_SESSION = $user;
    }
}