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
        

        if((isset($_SESSION['user']) && !$_SESSION['user']['auth']) || !isset($_SESSION['user'])){
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
        
        
        $db->conn->beginTransaction();
        $db->exec("INSERT INTO response_comments (comment_id, user_id, name, response) VALUES ({$data['parent_id']}, {$_SESSION['user']['id']}, '{$data['name']}', '{$data['comment']}')");
        $db->exec("UPDATE comments SET count_response=count_response+1 WHERE id={$data['parent_id']}");

        if($db->conn->commit()){

            $comment = $db->query("SELECT comments.id, comments.user_id, comments.name as comm_user_name, comment, notice_response, date, users.name as user_name, emails.email, product.title, product.alias, product.img FROM comments JOIN users ON users.id=comments.user_id JOIN emails ON users.id=emails.user_id JOIN product ON comments.product_id=product.id WHERE comments.id={$data['parent_id']}");
        
            if(!empty($comment)){
                $comment = $comment[0];
                $comment['date'] = newFormatDate($comment['date']);
                if($comment['notice_response'] == 1){
                    $response['name'] = $data['name'];
                    $response['date'] = newFormatDate(date('Y-m-d H:i:s'));
                    $response['response'] = $data['comment'];
                    $mail = new Mail($comment['email']);
                    
                    $mail->sendResponse($comment, $response);
                }
            }




            die(json_encode(['type' => 'success']));
        }
        die('error');

    }


    public function getResponseAction()
    {
        if(!isAjax()) redirect(HOST);

        $db = Db::getInstance();

        $responses = $db->query("SELECT * FROM response_comments WHERE comment_id={$_POST['comment_id']} ORDER BY date DESC");

        if(!empty($responses)){
            $result['type'] = 'success';
            if($_POST['getAll'] == 'false'){
                $final_responses = array_slice($responses, 0, 3);
                $result['checkAll'] = (count($responses) > 3) ? true : false;
                $result['hrefGetAll'] = HOST . '/product/comments/' . $_POST['alias'] . '?id=' . $_POST['comment_id']; 
            }else{
                $final_responses = $responses;
                $result['checkAll'] = false;
            }
            
            foreach ($final_responses as $key => $value) {
                $value['date'] = newFormatDate($value['date']);
                $final_responses[$key] = $value;
            }
            $result['responses'] = $final_responses;
            
            die(json_encode($result));
        }
        echo 'error';
    }

    public function getAction()
    {
        $count = isset($_POST['count']) ? $_POST['count'] : 0;
        if(!isset($_POST['alias'])) redirect();

        $db = Db::getInstance();
        
        if(empty($_SESSION['user']) || !$_SESSION['user']['auth']){
            $select= "SELECT CASE WHEN ( SELECT id FROM likes_comments WHERE comment_id = comments.id LIMIT 1) IS NOT NULL THEN 'like' ELSE 'like' END AS check_press_like, CASE WHEN ( SELECT id FROM dislikes_comments WHERE comment_id = comments.id LIMIT 1) IS NOT NULL THEN 'dislike' ELSE 'dislike' END AS check_press_dislike, comments.id, type, count_response, comment, good_comment, bad_comment, plus_likes, minus_likes, rating, date, comments.name FROM comments JOIN users ON comments.user_id = users.id WHERE comments.product_id =( SELECT id FROM product WHERE alias = ?) ORDER BY comments.date DESC LIMIT $count, 20";

        }else{
            $select = "SELECT CASE WHEN ( SELECT DISTINCT user_id FROM likes_comments WHERE comment_id = comments.id AND user_id={$_SESSION['user']['id']}) IS NOT NULL THEN 'press' ELSE 'like' END AS check_press_like, CASE WHEN ( SELECT DISTINCT user_id FROM dislikes_comments WHERE comment_id = comments.id AND user_id={$_SESSION['user']['id']}) IS NOT NULL THEN 'press' ELSE 'dislike' END AS check_press_dislike,  count_response, comments.id, type, comment, good_comment, bad_comment, plus_likes, minus_likes, rating, date, comments.name FROM comments JOIN users ON comments.user_id = users.id WHERE comments.product_id =( SELECT id FROM product WHERE alias = ?) ORDER BY comments.date DESC LIMIT $count, 20";
        }

        $comments = $db->execute($select, [$_POST['alias']]);
        
        

        if(!empty($comments)){
            foreach ($comments as $key => $value) {
                $value['date'] = newFormatDate($value['date']);
                $stars = [];
                for($x = 0; $x < 5; $x++) {
                    if($x < $value['rating'])
                        $stars[] = '';
                    else
                        $stars[] = '-o';
                }
                $value['stars'] = $stars;

                $comments[$key] = $value;
            }
            $count = count($comments);
        }else{
            $count = 0;
        }

        die(json_encode(['comments' => $comments, 'type' => 'success', 'count' => $count]));
        
    }
}