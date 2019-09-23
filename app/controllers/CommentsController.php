<?php

namespace app\controllers;

use \store\Db;
use \app\models\{SignupModel, Authorization};

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
        $data['user_id'] = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

        if(!$_SESSION['user']['auth']){
            //Если не пользователь авторизован

            $user = $db->execute('SELECT * FROM users WHERE id=(SELECT user_id FROM emails WHERE email=?)', [$data['email']]);

            if(!empty($user)){
                //Если аккаунт существует
                $response['type'] = 'mail_exist';
                die(json_encode($response));
            }

            
            $data['password'] = password_hash(md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL), PASSWORD_DEFAULT);
            $data['confirm'] = md5(SOL_CONFIRM_EMAIL . $data['name'] . mt_rand(1000, 9999) . SOL_CONFIRM_EMAIL);
            $signup = new SignupModel;
            
            if(!($user_id = $signup->newUser($data))){
                $response['type'] = 'error';
                die(json_encode($response));
            }

            //Добавить отправку письма на почту с кодом подтверждения
            
            $data['id'] = $user_id;
            $data['remember'] = false;
            Authorization::setSession($data);
            $data['user_id'] = $user_id;

        }
        

        if($data['rating'] > 0){
            $productRating = $db->execute('SELECT rating, count_otzuv FROM product_info WHERE id_product=?', [$data['product_id']])[0];
            $productAllOtzuv = $db->execute('SELECT rating FROM comments WHERE product_id=?', [$data['product_id']]);

            if(empty($productAllOtzuv))

            $countOtzuv = $productRating['count_otzuv'];
            $countOtzuv++;

            $newProductRating = $



            d($productRating, 1);


        }


        

        if(!$db->exec("INSERT INTO comments (product_id, user_id, type, comment, good_comment, bad_comment, notice_response, rating) VALUES ({$data['product_id']}, {$data['user_id']}, '{$data['type']}', '{$data['comment']}', '{$data['good_comment']}', '{$data['bad_comment']}', {$data['notice_response']}, {$data['rating']})")){
                die('error');
        }

        $data['date'] = newFormatDate(date('Y-m-d H:i:s'));
        
        $response['data'] = $data;
        $response['type'] = 'success';


        die(json_encode($response));

    }
}