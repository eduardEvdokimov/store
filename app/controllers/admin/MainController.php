<?php

namespace app\controllers\admin;

use \store\Db;

class MainController extends \store\base\Controller
{
    protected $layout = 'adminLTE';

    public function __construct($route)
    {



        $this->db = Db::getInstance();
        parent::__construct($route);

        if(!preg_match('#admin/login#', $_SERVER['REQUEST_URI']) && !\app\models\UserModel::isAuth(1))
                redirect(HOST_ADMIN . '/login');

        if(\app\models\UserModel::isAuth(1)){
            $time = new \DateTime($_SESSION['user']['date_registration']);
            $dateRegAdmin = $time->format('d.m.Y');
            $this->setParams(['dateRegAdmin' => $dateRegAdmin]);
        }

    }
}