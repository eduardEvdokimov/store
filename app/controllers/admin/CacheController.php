<?php

namespace app\controllers\admin;

class CacheController extends MainController
{
    public function indexAction()
    {

    }

    public function deleteAction()
    {
        if(empty($_GET['key'])) redirect();

        $cache = new \store\Cache();
        $cache->remove($_GET['key']);
        $_SESSION['success'] = 'Кеш успешно удален!';
        redirect();
    }
}