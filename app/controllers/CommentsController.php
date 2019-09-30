<?php

namespace app\controllers;

use \store\Db;
use \app\models\{SignupModel, Authorization, Mail};

class CommentsController extends MainController
{
    public function addAction()
    {   
        if(!isAjax()) redirect();
        $response = ['type' => ''];
        $db = Db::getInstance();

        $data = filterData($_POST);
        $data['good_comment'] = isset($data['good_comment']) ? $data['good_comment'] : null;
        $data['bad_comment'] = isset($data['bad_comment']) ? $data['bad_comment'] : null;
        $data['id'] = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

        if((isset($_SESSION['user']) && !$_SESSION['user']['auth']) || !isset($_SESSION['user'])){
            //Если не пользователь авторизован

            $user = $db->execute('SELECT * FROM users WHERE id=(SELECT user_id FROM emails WHERE email=?)', [$data['email']]);

            if(!empty($user)){
                //Если аккаунт существует
                $response['type'] = 'mail_exist';
                die(json_encode($response));
            }

            
            $data['password'] = password_hash(md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL), PASSWORD_DEFAULT);
            $data['confirm'] = 0;
            $data['code_confirmed'] = md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL);

            $signup = new SignupModel;
            if(!($user_id = $signup->newUser($data, 'user'))){
                $response['type'] = 'error';
                die(json_encode($response));
            }


            $mail = new Mail($data['email']);
            $mail->sendConfirmEmail($data['code_confirmed'], true);

            $data['id'] = $user_id;
            $data['remember'] = false;
            $data['auth'] = true;
            $data['fast'] = true;
            Authorization::setSession($data);
        }

        if($data['rating'] > 0){
            $productAllOtzuv = $db->execute('SELECT SUM(rating), COUNT(rating) FROM comments WHERE product_id=?', [$data['product_id']]);

            $countOtzuv = $productAllOtzuv[0]['COUNT(rating)'];
            $countOtzuv++;
            $sumRating = ($productAllOtzuv[0]['SUM(rating)']) ? $productAllOtzuv[0]['SUM(rating)'] : 0;
            $ratingProduct = ($sumRating + $data['rating']) / $countOtzuv; 
            
            if(!$db->exec("UPDATE product_info SET rating={$ratingProduct}, count_otzuv={$countOtzuv} WHERE id_product={$data['product_id']}"))
                die('error');
        }        

        if(!$db->exec("INSERT INTO comments (product_id, user_id, name, type, comment, good_comment, bad_comment, notice_response, rating) VALUES ({$data['product_id']}, {$data['id']}, '{$data['name']}', '{$data['type']}', '{$data['comment']}', '{$data['good_comment']}', '{$data['bad_comment']}', {$data['notice_response']}, {$data['rating']})")){
                die('error');
        }

        

        $data['date'] = newFormatDate(date('Y-m-d H:i:s'));
        $response['id'] = $db->conn->lastInsertId();
        $response['data'] = $data;
        $response['type'] = 'success';


        die(json_encode($response));
    }

    public function likeAction()
    {
        $id = $_POST['id'];
        $checkPressDislike = $_POST['checkPressDislike'];
        if(!empty($id)){
            $db = Db::getInstance();
            $db->conn->beginTransaction();
            if($checkPressDislike == 'disable'){
                $db->exec("UPDATE comments SET minus_likes=minus_likes-1 WHERE id={$id}");
                $db->exec("DELETE FROM dislikes_comments WHERE user_id={$_SESSION['user']['id']} AND comment_id={$id}");
            }
            $db->exec("UPDATE comments SET plus_likes=plus_likes+1 WHERE id={$id}");
            $db->exec("INSERT INTO likes_comments VALUES (null, {$_SESSION['user']['id']}, {$id})");
            if($db->conn->commit())
                die(json_encode(['type' => 'success']));
        }
        die('error');
    }

    public function dislikeAction()
    {
        $id = $_POST['id'];

        $checkPressLike = $_POST['checkPressLike'];

        if(!empty($id)){
            $db = Db::getInstance();
            $db->conn->beginTransaction();
            if($checkPressLike == 'disable'){
                $db->exec("UPDATE comments SET plus_likes=plus_likes-1 WHERE id={$id}");
                $db->exec("DELETE FROM likes_comments WHERE user_id={$_SESSION['user']['id']} AND comment_id={$id}");
            }
            
            $db->exec("UPDATE comments SET minus_likes=minus_likes+1 WHERE id={$id}");
            $db->exec("INSERT INTO dislikes_comments VALUES (null, {$_SESSION['user']['id']}, {$id})");
            if($db->conn->commit())
                die(json_encode(['type' => 'success']));
        }
        die('error');
    }

    public function addResponseAction()
    {
        $data = filterData($_POST);
        if(empty($data)) redirect(HOST);

        $db = Db::getInstance();
        $db->conn->beginTransaction();
        $db->exec("INSERT INTO response_comments (comment_id, user_id, name, response) VALUES ({$data['parent_id']}, {$_SESSION['user']['id']}, '{$data['name']}', '{$data['comment']}')");
        $db->exec("UPDATE comments SET count_response=count_response+1 WHERE id={$data['parent_id']}");
        if($db->conn->commit()){
            die(json_encode(['type' => 'success']));
        }
        die('error');

    }
}