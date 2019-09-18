<?php

namespace app\models;

class SignupModel extends MainModel
{
    public function checkExistMail($email)
    {
        $result = $this->getOne('emails', "email=?", [$email]);
        return empty($result[0]) ? true : false;
    }

    public function newUser($data)
    {
        if($this->add('users', ['id', 'name', 'password', 'role'], [null, $data['name'], $data['password'], 'user'])){
            $user_id = $this->db->conn->lastInsertId();
            if($this->add('emails', ['id', 'user_id', 'email', 'confirm', 'code_confirmed'], [null, $user_id, $data['email'], 0, $data['confirm']])){
                return true;
            }else{
                $this->db->conn->query("DELETE FROM users WHERE name={$data['name']}");
            }
        }
        return false;
    }
}