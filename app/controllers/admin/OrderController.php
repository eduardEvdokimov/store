<?php

namespace app\controllers\admin;

use \widgets\pagination\Pagination;

class OrderController extends MainController
{
    public function indexAction()
    {
        $viewCountOrders = \store\Register::get('config')['admin']['view_count_orders'];

        $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;
        $startOrder = ($currentPage - 1) * $viewCountOrders;

        $orders = $this->db->query("SELECT orders.id, orders.user_id, orders.currency, orders.status, orders.summ, orders.date, orders.update_date, users.name FROM orders JOIN users ON orders.user_id=users.id ORDER BY date DESC LIMIT {$startOrder}, {$viewCountOrders}");

        $countOrders = $this->db->query('SELECT COUNT(*) FROM orders')[0]['COUNT(*)'];

        $pagination = new Pagination($countOrders, $currentPage, $viewCountOrders);
        $this->setParams(['orders' => $orders, 'countOrders' => $countOrders, 'pagination' => $pagination]);
    }

    public function viewAction()
    {
        $order_id = !empty($_GET['id']) ? ((is_numeric($_GET['id'])) ? $_GET['id'] : redirect(HOST_ADMIN)) : redirect(HOST_ADMIN);

        $order = $this->db->query("SELECT *, orders.id, users.id as u_id FROM orders JOIN users ON orders.user_id=users.id WHERE orders.id={$order_id}");
        $products = $this->db->query("SELECT * FROM order_product WHERE order_id={$order_id}");

        if(empty($order))
            redirect(HOST_ADMIN);
        
        $this->setParams(['order' => $order[0], 'products' => $products]);
    }

    public function deleteAction()
    {
        $order_id = !empty($_GET['id']) ? ((is_numeric($_GET['id'])) ? $_GET['id'] : redirect(HOST_ADMIN)) : redirect(HOST_ADMIN);

        if($this->db->exec("DELETE FROM orders WHERE id={$order_id}")){
            $_SESSION['success'] = 'Заказ успешно удален!';
        }else{
            $_SESSION['error'] = 'Произошла ошибка! Заказ не был удален.';
        }
        redirect(HOST_ADMIN . '/order');
    }

    public function changeAction()
    {
        $order_id = !empty($_GET['id']) ? ((is_numeric($_GET['id'])) ? $_GET['id'] : redirect(HOST_ADMIN)) : redirect(HOST_ADMIN);
        if(!isset($_GET['status'])){
            redirect();
        }
        if($_GET['status']){
            $date = date('Y-m-d H:i:s');
            if($this->db->exec("UPDATE orders SET status=1, update_date='{$date}' WHERE id={$order_id}")){
                $_SESSION['success'] = 'Заказ успешно подтвержден!';
            }else{
                $_SESSION['error'] = 'Произошла ошибка! Заказ не был подтвержден.';
            }
        }else{
            if($this->db->exec("UPDATE orders SET status=0, update_date=null WHERE id={$order_id}")){
                $_SESSION['success'] = 'Заказ успешно вернулся на доработку!';
            }else{
                $_SESSION['error'] = 'Произошла ошибка!';
            }
        }
        
        redirect();
    }
}