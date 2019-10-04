<!DOCTYPE html>
<html>
<head>
    <title></title>

    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }

        #mail{
            width: 100%;
            max-width: 600px;
            font-family: sans-serif;   
            margin: 0 auto;
            margin-top: 5%;
            border: 1px solid silver;
            border-radius: 5px;

        }

        #header{
            width: 100%;
           
            border-bottom: 1px solid silver;
        }

        .header-logo{
            padding: 0 10px;
            display: inline-block;
            
        }

        #header > span{
            font-size: 18px;
            display: inline-block;
            margin-right: 10px;
            margin-top: 40px;
            float: right;
        }

        .header-logo h1{
            font-size: 2em;
            font-weight: 900;
        }

        .header-logo a{
            display: inline-block;
            color: #000;
            text-decoration: none;
            
        }

        .header-logo a span{
            font-family: sans-serif;
            font-size: 2em;
            color: #F44336;
            vertical-align: sub;
            margin-right: 3px;
        }

        #body{
            padding: 20px; 
            font-size: 16px; 
        }

        #body h3{
            margin: 10px 0;
            font-size: 20px;
        }

        #body > p{
            line-height: 22px;
            font-size: 16px;
        }

        #body > p > a{
            color: #0280e1;
            text-decoration: none;
        }

        #img-left{
            float: left;
        }

        #img-left a img{
            width: 120px;
            float: left;
            margin: 20% 0;
        }

        #article-right{
            margin-left: 170px;
        }

        #article-right a{
            font-size: 16px;
            color: #337ab7;
            text-decoration: none;
        }
        
        .block-content{
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 0 10px;
        }

        .title-content{
            color: black;
            margin: 10px 0;
        }

        .title-content span{
            float: right;
        }
        
        #btn{
            display: inline-block;
            width: 257px;
            background: #0280e1;
            padding: 10px;
            font-size: 1.3em;
            text-decoration: none;
            text-align: center;
            margin: 0 auto;
            border-radius: 5px;
            margin-top: 40px;
            color: white;
        }
        


    </style>
</head>
<body>
    <div id='mail'>
        <div id='header'>
            <div class="header-logo">
                <h1><a href="http://beststore.ddns.net"><span>S</span>mart</a></h1>
            </div>
            <span>Мы заботимся о вас и ваших покупках</span>
        </div>
        <div id='body'>
            <h3>На Ваш отзыв ответили</h3>
            <p>Здравствуйте, <?= $comment['user_name'] ?>. На Ваш отзыв:</p>
                <div class='block-content'>
                    <div id='img-left'>
                        <a href="<?= HOST . '/product/' . $comment['alias'] ?>"><img src="<?= $cid ?>" alt=''></a>
                    </div>
                    <div id='article-right'>
                        <a href="<?= HOST . '/product/' . $comment['alias'] ?>"><?= $comment['title'] ?></a>
                        <p class="title-content"><b><?= $comment['comm_user_name'] ?></b>&nbsp;<span><?= $comment['date'] ?></span></p>
                        
                        <p><?= $comment['comment'] ?></p>
                    </div>
                </div>
                <p>ответил:</p>
                <div class='block-content'>
                    <div>
                        <p class="title-content"><b><?= $response['name'] ?></b>&nbsp;<span><?= $response['date'] ?></span></p>
                        
                        <p><?= $response['response'] ?></p>
                    </div>
                </div>

            <a href='<?= HOST ?>/profile' id='btn' style="background: #f44336">Личный кабинет</a>
            <a href='<?= HOST . '/profile/comment/' . $comment['id'] ?>' id='btn'>Смотреть все ответы</a>

        </div>
        
    </div>
</body>
</html>