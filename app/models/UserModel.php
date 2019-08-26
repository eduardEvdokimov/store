<?php

namespace app\models;

class UserModel extends MainModel
{
    public function getUser()
    {
        d($this->getAll('users'));
    }
}