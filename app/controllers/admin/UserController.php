<?php

namespace app\controllers\admin;

class UserController extends MainController
{
    public function listAction()
    {

    }

    public function addAction()
    {

    }

    public function signupAction()
    {
        $data = filterData($_POST);

        if($this->db->query("SELECT COUNT(*) FROM emails WHERE email='{$data['email']}'")[0]['COUNT(*)']){
            $_SESSION['error'] = "Пользователь с данной эл. почтой <b>{$data['email']}</b> уже существует.";
            $_SESSION['form_data'] = $data;
            redirect();
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->conn->beginTransaction();
        $this->db->exec("INSERT INTO users (name, password, role) VALUES ('{$data['login']}', '$passwordHash', '{$data['role']}')");
        $user_id = $this->db->conn->lastInsertId();
        $this->db->exec("INSERT INTO emails (user_id, email, confirm) VALUES ({$user_id}, '{$data['email']}', 1)");
        if($this->db->conn->commit()){
            $_SESSION['success'] = 'Пользователь успешно добавлен!';
        }
        redirect();
    }

    public function logoutAction()
    {
        $_SESSION['user']['auth'] = false;
        redirect();
    }

}