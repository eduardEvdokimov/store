<?php

namespace app\controllers\admin;

use widgets\pagination\Pagination;

class UserController extends MainController
{
    public function listAction()
    {
        $viewCountUser = \store\Register::get('config')['admin']['view_count_users'];
        $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;
        $startUser = ($currentPage - 1) * $viewCountUser;
        $users = $this->db->query("SELECT users.*, emails.email FROM users JOIN emails ON users.id=emails.user_id ORDER BY date_registration DESC LIMIT {$startUser}, {$viewCountUser}");
        $countUsers = $this->db->query('SELECT COUNT(*) FROM users JOIN emails ON users.id=emails.user_id')[0]['COUNT(*)'];
        $pagination = new Pagination($countUsers, $currentPage, $viewCountUser);

        $this->setParams(['users' => $users, 'countUsers' => $countUsers, 'pagination' => $pagination]);
    }

    public function editAction()
    {
        if(isset($_POST['sub'])){
            $data = filterData($_POST);
            if($this->db->query("SELECT COUNT(*) FROM emails WHERE email='{$data['email']}' AND user_id!={$data['id']}")[0]['COUNT(*)']){
                $_SESSION['error'] = "Другой пользователь уже зарегистрирован с данной эл. почто <b>{$data['email']}</b>";
                redirect();
            }
            if(!empty($data['password']) && preg_match('#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]+$#', $data['password'])){
                $_SESSION['error'] = "Пароль должен быть не менее 6 символов, содержать цифры и заглавные буквы";
                redirect();
            }

            $passwordHash = !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : '';

            if($passwordHash){
                $this->db->exec("UPDATE users SET name='{$data['name']}', password='$passwordHash', role='{$data['role']}' WHERE id={$data['id']}");

            }else{
                $this->db->exec("UPDATE users SET name='{$data['name']}', role='{$data['role']}' WHERE id={$data['id']}");
            }

            $this->db->exec("UPDATE emails SET email='{$data['email']}' WHERE user_id={$data['id']}");

            if($_SESSION['user']['id'] == $data['id']){
                $_SESSION['user']['name'] = $data['name'];
                if($passwordHash)
                    $_SESSION['user']['password'] = $data['password'];
                $_SESSION['user']['role'] = $data['role'];
                $_SESSION['user']['email'] = $data['email'];
            }

            $_SESSION['success'] = 'Данные пользователя успешно сохранены!';
            redirect();
        }

        $user_id = !empty($_GET['id']) ? ((is_numeric($_GET['id'])) ? $_GET['id'] : redirect(HOST_ADMIN)) : redirect(HOST_ADMIN);

        $user = $this->db->query("SELECT users.*, emails.email FROM users JOIN emails ON users.id = emails.user_id WHERE users.id={$user_id}");

        if(empty($user)) redirect(HOST_ADMIN);
        $user = $user[0];
        $orders = $this->db->query("SELECT * FROM orders WHERE user_id={$user['id']}");
        $this->setParams(['user' => $user, 'orders' => $orders]);
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
        $this->db->exec("INSERT INTO users (name, password, role) VALUES ('{$data['name']}', '$passwordHash', '{$data['role']}')");
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