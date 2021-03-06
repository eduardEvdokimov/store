<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->getMeta(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?= HOST ?>/images/favicon1.png" type='image/png'/>
</head>
<script type="application/x-javascript"> 
    var host = "<?= $_SERVER['HTTP_HOST'] ?>";
    var simbolCurrency = "<?= $simbolCurrency; ?>";
    var userAuth = "<?= $userAuth ?>";
    var userName = '';
    var userEmail = '';
    if(userAuth){
        userName = "<?= $_SESSION['user']['name'] ?>";
        userEmail = "<?= $_SESSION['user']['email'] ?>";
    }

 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<script src="<?= HOST ?>/js/jquery-2.2.3.min.js"></script> 
<script src="<?= HOST ?>/js/bootstrap.js"></script>
<script src="<?= HOST ?>/js/validator.js"></script>


<link href="<?= HOST ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />


<link href="<?= HOST ?>/css/style.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="<?= HOST ?>/css/menu.css" rel="stylesheet" type="text/css" media="all" /> <!-- menu style --> 
<link href="<?= HOST ?>/css/ken-burns.css" rel="stylesheet" type="text/css" media="all" /> <!-- banner slider --> 
<link href="<?= HOST ?>/css/animate.min.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="<?= HOST ?>/css/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider -->  
<!-- //Custom Theme files -->
<!-- font-awesome icons -->
<link href="<?= HOST ?>/css/all.css" rel="stylesheet"> 
<link href="<?= HOST ?>/css/font-awesome.css" rel="stylesheet"> 
<meta name="interkassa-verification" content="4bd253b110a8358ba2ed0fdb818f2ca7" />
<!--flex slider-->
<script defer src="<?= HOST ?>/js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="<?= HOST ?>/css/flexslider.css" type="text/css" media="screen" />
<script>
    // Can also be used with $(document).ready()
    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails"
      });
    });
</script>
<!--flex slider-->
<script src="<?= HOST ?>/js/imagezoom.js"></script>
<!-- //js --> 

<!-- //font-awesome icons -->
<!-- js -->

<!-- //js --> 
<!-- web-fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

<!-- web-fonts --> 
<script src="<?= HOST ?>/js/owl.carousel.js"></script>  
<script>
$(document).ready(function() { 
    $("#owl-demo").owlCarousel({ 
      autoPlay: 3000, //Set AutoPlay to 3 seconds 
      items :4,
      itemsDesktop : [640,5],
      itemsDesktopSmall : [480,2],
      navigation : true
 
    }); 
}); 
</script>
<script src="<?= HOST ?>/js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        // Dock the header to the top of the window when scrolled past the banner. This is the default behaviour.
        var r = /comparison\/[0-9]+/;
        if(!r.test(document.location.pathname))
        $('.header-two').scrollToFixed();  
        // previous summary up the page.

        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: $('.header-two').outerHeight(true) + 10, 
                zIndex: 999 
            });
        });
    });
</script>
<!-- start-smooth-scrolling -->
<script type="text/javascript" src="<?= HOST ?>/js/move-top.js"></script>
<script type="text/javascript" src="<?= HOST ?>/js/easing.js"></script> 
<script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){     
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
</script>
<!-- //end-smooth-scrolling -->
<!-- smooth-scrolling-of-move-up -->
    <script type="text/javascript">
        $(document).ready(function() {
        
            var defaults = {
                containerID: 'toTop', // fading element id
                containerHoverID: 'toTopHover', // fading element hover id
                scrollSpeed: 1200,
                easingType: 'linear' 
            };
            
            $().UItoTop({ easingType: 'easeOutQuart' });
            
        });
    </script>
    <!-- //smooth-scrolling-of-move-up -->




<script type="text/javascript" src="<?= HOST ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?= HOST ?>/js/jquery.autocomplete.js"></script>
</head>
<body>
    <!-- header -->
    <div class="header">
        <div class="w3ls-header"><!--header-one--> 
            <div class="w3ls-header-left">
                <p><a>Мы заботимся о вас и ваших покупках</a></p>
            </div>
            <div class="w3ls-header-right">
                <ul>
                    <li class="dropdown head-dpdn">
                        <!-- У не авторизованного пользователя "Мой аккаунт", авторизованного - Имя Фамилия -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><?= $nameDrpMenuUser ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if($userAuth): ?>
                            <!--Список у авторизованного пользователя -->
                            <li><a href="<?= HOST ?>/profile">Личные данные</a></li>  
                            <li><a href="<?= HOST ?>/profile/desires">Список желаний</a></li>  
                            <li><a href="<?= HOST ?>/comparison">Список сравнений</a></li> 
                            <li><a href="<?= HOST ?>/profile/cart">Корзина</a></li>
                            <li><a href="<?= HOST ?>/order/my">Мои заказы</a></li>
                            <li><a href="<?= HOST ?>/profile/comments">Мои отзывы</a></li>
                            <li><a href="<?= HOST ?>/profile/viewed">Просмотренные товары</a></li>
                            <li><a href="<?= HOST ?>/login/logout">Выход</a></li>   
                            <?php else: ?>
                             <!--Если не авторизованный пользователь -->
                            <li><a href="<?= HOST ?>/login">Вход</a></li> 
                            <li><a href="<?= HOST ?>/signup">Регистрация</a></li>
                            <?php endif; ?>
                        </ul> 
                    </li> 
                    <?php new \widgets\currency\Currency; ?>


                    
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle"><i class="fa fa-question-circle" aria-hidden="true"></i>Помощь</a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"> </div> 
        </div>
        <div class="header-two"><!-- header-two -->
            <div class="container">
                <div class="header-logo">
                    <h1><a href="<?= HOST ?>"><span>S</span>mart</a></h1>
                    <h6>Your stores. Your place.</h6> 
                </div>  
                <div class="header-search">
                    <form onsubmit="return false;">
                        <input type="search" id='autocomplete' style="font-size: 1.1em; color: black" name="Search" placeholder="Поиск по товарам..." autocomplete="off">
                        <button type="button" id='sub_search' style="height: 100%" class="btn btn-default" aria-label="Left Align">
                            <i class="fa fa-search" aria-hidden="true"> </i>
                        </button>
                    </form>
                </div>
                <div class="header-cart">
                    <div class="cart" id='comparison' title='Список сравнений'> 
                        <button class="w3view-cart" type="submit" name="submit" value="">
                            <i class="fas fa-balance-scale" style="font-size: 25px; color: white;"></i>
                        </button>
                        <?php if($comparisonCount): ?>
                            <span><?= $comparisonCount ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="cart" id='wishlist' title='Список желаний'>
                        <button class="w3view-cart" type="submit" name="submit" value="">
                            <i class="far fa-heart" style="font-size: 25px; color: white;"></i>
                        </button>
                        <?php if($wishCount): ?>
                            <span><?= $wishCount ?></span>
                        <?php endif;?>

                    </div>
                    <div class="cart" title='Корзина'> 
                        <button class="w3view-cart"  data-toggle="modal" data-target=".bs-example-modal-lg" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                                <span id='countProductCart' class="<?= $hiddenCounterCart ?>"><?= $countProductCart ?></span>
                    </div>
                    <div class="clearfix"> </div> 
                </div> 
                <div class="clearfix"> </div>
            </div>      
        </div><!-- //header-two -->
        <div class="header-three"><!-- header-three -->
            <div class="container">
                <div class="menu">
                    <?php new \widgets\category\Category; ?>
                    
                </div>
                <div class="move-text">
                    <div class="marquee"><a href="#"> Новые коллекции доступны здесь...... <span>Получи дополнительную скидку 10% на все | без дополнительных налогов </span> <span> Попробуйте бесплатную доставку на 15 дней без ограничений</span></a></div>
                    <script type="text/javascript" src="<?= HOST ?>/js/jquery.marquee.min.js"></script>
                    <script>
                      $('.marquee').marquee({ pauseOnHover: true });
                      //@ sourceURL=pen.js
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div id='c'>
    <?= $content ?>
    </div>
    <!-- //header -->
    
    <!-- footer -->
    <div class="footer">
        <div class="container">
            <div class="footer-info w3-agileits-info">
                <div class="col-md-4 address-left agileinfo">
                    <div class="footer-logo header-logo">
                        <h2><a href="<?= HOST ?>"><span>S</span>mart</a></h2>
                        <h6>Your stores. Your place.</h6>
                    </div>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> 123 San Sebastian, New York City USA.</li>
                        <li><i class="fa fa-mobile"></i> 333 222 3333 </li>
                        <li><i class="fa fa-phone"></i> +222 11 4444 </li>
                        <li><i class="fa fa-envelope-o"></i> <a href="mailto:example@mail.com"> mail@example.com</a></li>
                    </ul> 
                </div>
                <div class="col-md-8 address-right">
                    <div class="col-md-4 footer-grids">
                        <h3>Компания</h3>
                        <ul>
                            <li><a href="#">О нас</a></li>     
                            <li><a href="#">Главные ценности</a></li>  
                            <li><a href="#">политика конфиденциальности</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 footer-grids">
                        <h3>Службы</h3>
                        <ul>
                            <li><a href="#">Свяжитесь с нами</a></li>
                            <li><a href="#">Возвраты</a></li> 
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Карта сайта</a></li>
                            <li><a href="#">Статус заказа</a></li>
                        </ul> 
                    </div>
                    <div class="col-md-4 footer-grids">
                        <h3>Способы оплаты</h3>
                        <ul>
                            <li><i class="fa fa-laptop" aria-hidden="true"></i> Интернет банкинг</li>
                            <li><i class="fa fa-money" aria-hidden="true"></i> Наложенный платеж</li>
                            <li><i class="fa fa-gift" aria-hidden="true"></i> Ваучер</li>
                            <li><i class="fa fa-credit-card" aria-hidden="true"></i> Кредитная карта</li>
                        </ul>  
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Окно корзины -->




    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Корзина</h4>
                </div>
                <div class="modal-body" style="position: relative;">
                    <!-- Loader -->
                    <!--<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> -->
                    <!-- Loader -->
                    <?php 

                        $hiddenCart = '';
                        $hiddenH3 = 'hidden'; 
                        if(empty($cart['cart'])){
                            $hiddenCart = 'hidden';
                            $hiddenH3 = '';
                        }?>

                    <h3 class='<?= $hiddenH3 ?>'>Корзина пуста</h3>
                    

                    <table class="table table-striped table-sm <?= $hiddenCart ?>">
                        <thead>
                            <tr>
                                <th>Фото</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>Сумма</th>
                                <th><i class="fas fa-trash"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cart['cart'] as $item):  ?>
                        

                        <tr data-id='<?= $item['id'] ?>'>
                            <td>
                                <img src='<?= HOST . '/images/' . $item['img'] ?>' alt='img' style='width: 60px;'>
                            </td>
                            <td style="width: 50%;" ><a href='<?= HOST . '/product/' . $item['alias'] ?>'><?= $item['title'] ?></a></td>
                            <td><?= $simbolCurrency . '&nbsp;' . $item['price'] ?>
                            </td>
                            <td>
                                <div>
                                    <button class='btn_box_number delCountProduct'>&#8212;</button>
                                    <input type='text' class='box_number' readonly maxlength='3' value='<?= $item['count'] ?>'>
                                    <button class='btn_box_number addCountProduct'>+</button>
                                </div>
                            </td>
                            <td class='summProduct'><?= $simbolCurrency . '&nbsp;' . $item['summ'] ?></td>
                            <td>
                                <span style='cursor: pointer;' class='glyphicon glyphicon-remove text-danger del-item delProductCart' aria-hidden='true'></span>
                            </td>
                        </tr>


                        <?php endforeach; ?>


                        <tr class='result_line_catr' style="background: #b2ff96;">
                            <th scope="row" colspan="2" >Итоговая сумма</th>
                            <td></td>
                            <td></td>
                            <td class='final_price' colspan="2" style='background: #0280e1;'>
                                <span><?= $simbolCurrency . '&nbsp;' . $cart['cart.summ'] ?></span>
                            </td>
                          
                        </tr>
                        </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
                    <button type="button" class="btn btn-danger clearCart <?= $hiddenCart ?>">Очистить корзину</button>
                    <a href='<?= HOST ?>/order' type="button" class="btn btn-primary <?= $hiddenCart ?> btn_addOrder">Оформить заказ</a>
                </div>
            </div>
            
        </div>
    </div>

    <div class='widget-chat-modal hidden'>
        <div class='head'>
            <h4>Онлайн консультация</h4>
            <i class="fas fa-minus"></i>
        </div>
        <div class='body'>
            <div class="block-content-msgs hidden">

            </div>

            <form data-toggle="validator" role="form">
                <div class="form-group">
                    <label for="name">Как к Вам обращаться</label>
                    <input type="text" class="form-control" id="name" placeholder="Имя" required>
                </div>
                <div class="form-group">
                    <label for="msg">Опишите проблему</label>
                    <textarea class="form-control" rows="4" id="msg" placeholder="Сообщение" required></textarea>
                </div>
                <button type="submit" style="float: right" class="btn btn-primary">Отправить</button>
            </form>
        </div>

        <div class="field-msg hidden">
            <input type="text" placeholder="Сообщение..."><button>
                <i class="fas fa-angle-right"></i>
            </button>
        </div>
    </div>

    <div class="widget-chat">
        <button>
            <span class="hidden">Спроси у нас</span>
            <i class="far fa-comment"></i>
        </button>
    </div>


    <!-- Окно корзины -->

    <!-- //footer -->       
    <div class="copy-right"> 
        <div class="container">
            <p>© 2019 Smart bazaar . All rights reserved | Design by <a href="http://w3layouts.com"> W3layouts.</a></p>
        </div>
    </div> 
    
    <!-- countdown.js -->   
    <script src="<?= HOST ?>/js/jquery.knob.js"></script>
    <script src="<?= HOST ?>/js/jquery.throttle.js"></script>
    <script src="<?= HOST ?>/js/jquery.classycountdown.js"></script>
        <script>
            $(document).ready(function() {
                $('#countdown1').ClassyCountdown({
                    end: '1388268325',
                    now: '1387999995',
                    labels: true,
                    style: {
                        element: "",
                        textResponsive: .5,
                        days: {
                            gauge: {
                                thickness: .10,
                                bgColor: "rgba(0,0,0,0)",
                                fgColor: "#1abc9c",
                                lineCap: 'round'
                            },
                            textCSS: 'font-weight:300; color:#fff;'
                        },
                        hours: {
                            gauge: {
                                thickness: .10,
                                bgColor: "rgba(0,0,0,0)",
                                fgColor: "#05BEF6",
                                lineCap: 'round'
                            },
                            textCSS: ' font-weight:300; color:#fff;'
                        },
                        minutes: {
                            gauge: {
                                thickness: .10,
                                bgColor: "rgba(0,0,0,0)",
                                fgColor: "#8e44ad",
                                lineCap: 'round'
                            },
                            textCSS: ' font-weight:300; color:#fff;'
                        },
                        seconds: {
                            gauge: {
                                thickness: .10,
                                bgColor: "rgba(0,0,0,0)",
                                fgColor: "#f39c12",
                                lineCap: 'round'
                            },
                            textCSS: ' font-weight:300; color:#fff;'
                        }

                    },
                    onEndCallback: function() {
                        console.log("Time out!");
                    }
                });
            });
        </script>
    <!-- //countdown.js -->
    <!-- menu js aim -->
    <script type="text/javascript" src="<?= HOST ?>/js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" id="sourcecode">
    $(function()
    {
        $('body .scroll-pane').jScrollPane();
    });
    </script>
    <script src="<?= HOST ?>/js/jquery.menu-aim.js"> </script>
    <script type="text/javascript" src='<?= HOST ?>/js/html.js'></script>
    <script src="<?= HOST ?>/js/main.js"></script> <!-- Resource jQuery -->
    <script src="<?= HOST ?>/js/myjs.js"></script>
    <script src="<?= HOST ?>/js/socket.js"></script>
    <!-- //menu js aim --> 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster --> 

</body>
</html>