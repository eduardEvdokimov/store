<?php

namespace app\controllers;

use \store\{Db, Register};
use \app\models\{Mail, ProductModel};
use \widgets\pagination\Pagination;

class ProfileController extends MainController
{

    public function __construct($route)
    {
        parent::__construct($route);

        if((isset($_SESSION['user']['auth']) && !$_SESSION['user']['auth']) || !isset($_SESSION['user']['auth'])){
            redirect(HOST);
        }
    }

    public function indexAction()
    {
        $msgSuccessConfirm = '';
        $firstName = '';
        $lastName = '';

        if(isset($_SESSION['user']['confirm_action']) && $_SESSION['user']['confirm_action']){
            $msgSuccessConfirm = "<div class='alert alert-success'><i class='fa fa-check-circle'></i>&nbsp;" . 'Электронная почта успешно подтверждена!';
            $msgSuccessConfirm .= "<button type='button' class='close' data-dismiss='alert'>×</button></div>";
            $_SESSION['user']['confirm_action'] = false;
        }

        $dataName = explode(' ', $_SESSION['user']['name'], 2);
        $firstName = $dataName[0];

        if(isset($dataName[1]))
            $lastName = $dataName[1];

        $email = $_SESSION['user']['email'];

        $data['msgSuccessConfirm'] = $msgSuccessConfirm;
        $data['firstName'] = $firstName;
        $data['lastName'] = $lastName;
        $data['email'] = $email;

        $this->setParams(['data' => $data]);
    }

    public function cartAction()
    {
        $cart = CartController::getAll();
        $this->setParams(['cart' => $cart]);
    }


    public function viewedAction()
    {
        $model = new ProductModel;
        $db = Db::getInstance();

        $viewedProducts = !empty($_COOKIE['viewedProducts']) ? $_COOKIE['viewedProducts'] : '';
        
        $products = [];
        $countProduct = 0;
        $countProductOnePage = Register::get('config')['countProductSearchPage'];
        if($viewedProducts){
            $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;

            
            $startProduct = ($currentPage - 1) * $countProductOnePage;

            if(strpos($viewedProducts, ',') !== false){
                $arrViewedProducts = explode(',', $viewedProducts);
                $sql = implode(',', array_slice(explode(',', $viewedProducts), $startProduct, $countProductOnePage));
            }
            else{
                $arrViewedProducts = [$viewedProducts];
                $sql = $viewedProducts;
            }

            $viewedProductsData = $model->db->query("SELECT * FROM product WHERE id IN ($sql)");

            $countProduct = $db->query("SELECT COUNT(*) FROM product WHERE id IN ($viewedProducts)")[0]['COUNT(*)'];

            foreach ($viewedProductsData as $key => $value) {
                $arrNew[$value['id']] = $value;  
            }

            foreach ($arrViewedProducts as $key => $value) {
                if(isset($arrNew[$value])){
                    $sortViewedProducts[] = $arrNew[$value];
                }
            } 

            $products = $model->createDataProduct($sortViewedProducts);
        }

        $pagination = new Pagination($countProduct, $countProductOnePage);

        $this->setParams(['products' => $products, 'pagination' => $pagination]);
    }

    public function desiresAction()
    {
        $lists = $this->db->query("SELECT wishlists.id, wishlists.name, wishlists.type_def FROM wishlists WHERE wishlists.user_id = {$_SESSION['user']['id']} ORDER BY wishlists.type_def DESC");

        if(!empty($lists)){
            $lists = $this->sortLists($lists);
        }
        
        $this->setParams(['lists' => $lists]);
    }

    private function sortLists($lists)
    {
        $model = new ProductModel;
        
        foreach ($lists as $key => $value) {
            $products = $this->db->query("SELECT * FROM product WHERE id IN (SELECT product_id FROM wishlist_product WHERE list_id={$value['id']})");
            $summ = $this->db->query("SELECT SUM(price), COUNT(price) FROM product WHERE id IN (SELECT product_id FROM wishlist_product WHERE list_id={$value['id']})");
            
            if(!empty($products)){
                $lists[$key]['products'] = $model->createDataProduct($products);
                $lists[$key]['summ'] = $model->recalcPrice($summ[0]['SUM(price)']);
                $lists[$key]['count'] = $summ[0]['COUNT(price)'];
            }
        }
        
        return $lists;
    }

    public function ordersAction(){}

    public function commentsAction()
    {
        $db = Db::getInstance();

        $addTerm = '';
        if(isset($this->route['id'])){
            $addTerm = "AND comments.id={$this->route['id']}";
        }

        $comments = $db->query("SELECT comments.id, comments.comment, comments.name, comments.date, product.title, product.alias, product.img FROM comments JOIN product ON comments.product_id=product.id WHERE comments.user_id={$_SESSION['user']['id']} $addTerm ORDER BY date DESC");

        if(!empty($comments)){
            foreach ($comments as $key => $value) {
                $responses = $db->query("SELECT name, response, date FROM response_comments WHERE comment_id={$value['id']} ORDER BY date DESC");
                
                if(!empty($responses)){
                    foreach ($responses as $keyR => $response) {
                        $response['date'] = newFormatDate($response['date']);
                        $responses[$keyR] = $response;
                    }

                    $value['responses'] = $responses;
                }

                $value['date'] = newFormatDate($value['date']);
                $comments[$key] = $value;
                unset($responses);
            }
        }
        
        $this->setParams(['comments' => $comments]);
    }

    public function setPasswordAction()
    {
        if(!isAjax()) redirect(HOST);

        $data = filterData($_POST);


        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $db = Db::getInstance();

        if($db->exec("UPDATE users SET password='$password' WHERE id={$_SESSION['user']['id']}")){
            $response['type'] = 'success';
            $_SESSION['user']['restore_pass'] = false;
            $_SESSION['user']['password'] = $data['password'];
            $_SESSION['user']['fast'] = false;
            die(json_encode($response));
        }
        echo 'error';
    }

    public function restorePasswordAction()
    {   
        if(!$_SESSION['user']['restore_pass']) redirect(HOST);
    }

    public function setNewPasswordAction()
    {
        $data = filterData($_POST);

        if($data['oldPass'] !== $_SESSION['user']['password'])
            die(json_encode(['type' => 'error']));

        $password = password_hash($data['newPass'], PASSWORD_DEFAULT);
        $db = Db::getInstance();

        if($db->exec("UPDATE users SET password='$password' WHERE id={$_SESSION['user']['id']}")){
            $response['type'] = 'success';
            $_SESSION['user']['password'] = $data['newPass'];
            die(json_encode($response));
        }
        echo 'error';
    }

    public function changeNameAction()
    {
        $data = filterData($_POST);

        $db = Db::getInstance();
        $name = $data['firstName'] . ' ' . $data['lastName'];

        if($db->exec("UPDATE users SET name='{$name}' WHERE id={$_SESSION['user']['id']}")){
            $_SESSION['user']['name'] = $name;
            die(json_encode(['type' => 'success']));
        }
        echo 'error';
    }

    public function changePasswordAction()
    {
        
    }

    public function addPasswordAction()
    {
        if((isset($_SESSION['user']['fast']) && !$_SESSION['user']['fast']) || !isset($_SESSION['user']['fast'])) redirect(HOST);

        $msgSuccessConfirm = '';
        if(isset($_SESSION['user']['confirm_action']) && $_SESSION['user']['confirm_action']){
            $msgSuccessConfirm = "<div class='alert alert-success'><i class='fa fa-check-circle'></i>&nbsp;" . 'Электронная почта успешно подтверждена!';
            $msgSuccessConfirm .= "<button type='button' class='close' data-dismiss='alert'>×</button></div>";
            $_SESSION['user']['confirm_action'] = false;
        }
        $this->setParams(['msgSuccessConfirm' => $msgSuccessConfirm]);
    }

    public function sendCodeConfirmEmailAction()
    {  
        $mail = new Mail($_SESSION['user']['email']);
        $db = Db::getInstance();
        $code = $db->query("SELECT code_confirmed FROM emails WHERE user_id={$_SESSION['user']['id']}");

        if(empty($code))
            die('error');
      
        $code = $code[0]['code_confirmed'];

        $mail->sendConfirmEmail($code, $_SESSION['user']['fast']);
        die(json_encode(['type' => 'success']));
    }
}