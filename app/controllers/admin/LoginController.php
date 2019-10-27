<?php

namespace app\controllers\admin;

class LoginController extends MainController
{
    public function indexAction()
    {
        $data = filterData($_POST);

        if(isset($data['sub'])){
            $user = $this->db->query("SELECT emails.email, users.id, users.role, users.name, users.date_registration, password FROM emails JOIN users ON emails.user_id=users.id WHERE emails.email='{$data['email']}'");

            if(!empty($user) && ($user[0]['role'] == 'admin') && password_verify($data['password'], $user[0]['password'])){
                $session = $user[0];
                $session['auth'] = true;
                $session['password'] = $data['password'];
                if(isset($data['remember'])){
                    $session['remember'] = true;
                }

                \app\models\Authorization::setSession($session);
                redirect(HOST_ADMIN);
            }
            $_SESSION['error'] = 'Проверьте правильность введенных данных';
            redirect();
        }
        $this->loadView();
    }

}