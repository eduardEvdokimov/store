<?php

namespace app\models;

class UserModel extends MainModel
{
    public function getUser()
    {
        d($this->getAll('users'));
    }

    public static function isAuth($isAdmin = false)
    {
        $check = false;

        if($isAdmin){
            if(isset($_SESSION['user']) && $_SESSION['user']['auth'] == true && $_SESSION['user']['role'] == 'admin')
                $check = true;
        }else{
            if(isset($_SESSION['user']) && $_SESSION['user']['auth'] == true)
                $check = true;
        }
        return $check;
    }
}