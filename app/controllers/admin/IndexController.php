<?php

namespace app\controllers\admin;

class IndexController extends MainController
{
    public function indexAction()
    {
        $countUsers = $this->db->query('SELECT COUNT(*) FROM users')[0]['COUNT(*)'];
        $countCategories = $this->db->query('SELECT COUNT(*) FROM category')[0]['COUNT(*)'];
        $countProducts = $this->db->query("SELECT COUNT(*) FROM product")[0]['COUNT(*)'];
        $countNewOrders = $this->db->query('SELECT COUNT(*) FROM orders WHERE status = 0')[0]['COUNT(*)'];

        $this->setParams(['countUsers' => $countUsers, 'countCategories' => $countCategories, 'countProducts' => $countProducts, 'countNewOrders' => $countNewOrders]);
    }
}