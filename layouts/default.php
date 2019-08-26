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
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<script src="<?= HOST ?>/js/jquery-2.2.3.min.js"></script> 
<script src="<?= HOST ?>/js/bootstrap.js"></script> 


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

<script type="text/javascript" src="<?= HOST ?>/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" id="sourcecode">
    $(function()
    {
        $('.scroll-pane').jScrollPane();
    });
</script>
<script type="text/javascript" src="<?= HOST ?>/js/jquery.mousewheel.js"></script>
</head>
<body>
    <!-- header -->
    <div class="header">
        <div class="w3ls-header"><!--header-one--> 
            <div class="w3ls-header-left">
                <p><a href="#">UPTO $50 OFF ON LAPTOPS | USE COUPON CODE LAPPY </a></p>
            </div>
            <div class="w3ls-header-right">
                <ul>
                    <li class="dropdown head-dpdn">
                        <!-- У не авторизованного пользователя "Мой аккаунт", авторизованного - Имя Фамилия -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i>Мой аккаунт<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <!--Если не авторизованный пользователь -->
                            <li><a href="login.html">Вход</a></li> 
                            <li><a href="signup.html">Регистрация</a></li>
                            <!--Список у авторизованного пользователя

                                <li><a href="login.html">Личные данные</a></li>  
                                <li><a href="login.html">Списки желаний</a></li>  
                                <li><a href="login.html">Корзина</a></li>
                                <li><a href="login.html">Мои заказы</a></li>
                                <li><a href="login.html">Мои отзывы</a></li>
                                <li><a href="login.html">Просмотренные товары</a></li>
                                <li><a href="login.html">Выход</a></li>   
                            --> 
                            
                        </ul> 
                    </li> 
                    <?php new \widgets\currency\Currency; ?>
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-globe"></i> Язык<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="offers.html">Русский</a></li> 
                            <li><a href="offers.html">Украiнська</a></li>
                            <li><a href="offers.html">English</a></li> 
                        </ul> 
                    </li>
                    <li class="dropdown head-dpdn">
                        <a href="help.html" class="dropdown-toggle"><i class="fa fa-question-circle" aria-hidden="true"></i>Помощь</a>
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
                    <form action="#" method="post">
                        <input type="search" name="Search" placeholder="Поиск по товарам..." required="">
                        <button type="submit" class="btn btn-default" aria-label="Left Align">
                            <i class="fa fa-search" aria-hidden="true"> </i>
                        </button>
                    </form>
                </div>
                <div class="header-cart">
                    <div class="cart"> 
                        <button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                    </div>
                    <div class="cart"> 
                        <button class="w3view-cart" type="submit" name="submit" value=""><i class="far fa-heart" style="font-size: 25px; color: white;"></i></button>
                    </div>
                    <div class="cart"> 
                        <button class="w3view-cart" type="submit" name="submit" value=""><i class="fas fa-balance-scale" style="font-size: 25px; color: white;"></i></button>
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
                    <div class="marquee"><a href="offers.html"> Новые коллекции доступны здесь...... <span>Получи дополнительную скидку 10% на все | без дополнительных налогов </span> <span> Попробуйте бесплатную доставку на 15 дней без ограничений</span></a></div>
                    <script type="text/javascript" src="<?= HOST ?>/js/jquery.marquee.min.js"></script>
                    <script>
                      $('.marquee').marquee({ pauseOnHover: true });
                      //@ sourceURL=pen.js
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?= $content ?>
    <!-- //header -->
    <!-- footer-top -->
    <div class="w3agile-ftr-top">
        <div class="container">
            <div class="ftr-toprow">
                <div class="col-md-4 ftr-top-grids">
                    <div class="ftr-top-left">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                    </div> 
                    <div class="ftr-top-right">
                        <h4>БЕСПЛАТНАЯ ДОСТАВКА</h4>
                        <p>Закажите любой товар и вы приятно удивитесь, что за доставку платить не нужно</p>
                    </div> 
                    <div class="clearfix"> </div>
                </div> 
                <div class="col-md-4 ftr-top-grids">
                    <div class="ftr-top-left">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div> 
                    <div class="ftr-top-right">
                        <h4>ЗАБОТА О ПОКУПАТЕЛЯХ</h4>
                        <p>Мы позаботимся, чтоб покупка в нашем интернет-магазине прошла для Вас легко и быстро</p>
                    </div> 
                    <div class="clearfix"> </div>
                </div>
                <div class="col-md-4 ftr-top-grids">
                    <div class="ftr-top-left">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    </div> 
                    <div class="ftr-top-right">
                        <h4>ВЫСОКОЕ КАЧЕСТВО</h4>
                        <p>Магазин дает гарантию за высокое качество за предлагаемую продукцию</p>
                    </div>
                    <div class="clearfix"> </div>
                </div> 
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //footer-top --> 
    <!-- footer -->
    <div class="footer">
        <div class="container">
            <div class="footer-info w3-agileits-info">
                <div class="col-md-4 address-left agileinfo">
                    <div class="footer-logo header-logo">
                        <h2><a href="index.html"><span>S</span>mart</a></h2>
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
                        <h3>Company</h3>
                        <ul>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="marketplace.html">Marketplace</a></li>  
                            <li><a href="values.html">Core Values</a></li>  
                            <li><a href="privacy.html">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 footer-grids">
                        <h3>Services</h3>
                        <ul>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="login.html">Returns</a></li> 
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="sitemap.html">Site Map</a></li>
                            <li><a href="login.html">Order Status</a></li>
                        </ul> 
                    </div>
                    <div class="col-md-4 footer-grids">
                        <h3>Payment Methods</h3>
                        <ul>
                            <li><i class="fa fa-laptop" aria-hidden="true"></i> Net Banking</li>
                            <li><i class="fa fa-money" aria-hidden="true"></i> Cash On Delivery</li>
                            <li><i class="fa fa-pie-chart" aria-hidden="true"></i>EMI Conversion</li>
                            <li><i class="fa fa-gift" aria-hidden="true"></i> E-Gift Voucher</li>
                            <li><i class="fa fa-credit-card" aria-hidden="true"></i> Debit/Credit Card</li>
                        </ul>  
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- //footer -->       
    <div class="copy-right"> 
        <div class="container">
            <p>© 2019 Smart bazaar . All rights reserved | Design by <a href="http://w3layouts.com"> W3layouts.</a></p>
        </div>
    </div> 
    <!-- cart-js -->
    <script src="<?= HOST ?>/js/minicart.js"></script>
    <script>
        w3ls.render();

        w3ls.cart.on('w3sb_checkout', function (evt) {
            var items, len, i;

            if (this.subtotal() > 0) {
                items = this.items();

                for (i = 0, len = items.length; i < len; i++) {
                    items[i].set('shipping', 0);
                    items[i].set('shipping2', 0);
                }
            }
        });
    </script>  
    <!-- //cart-js -->  
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
    <script src="<?= HOST ?>/js/jquery.menu-aim.js"> </script>
    <script src="<?= HOST ?>/js/main.js"></script> <!-- Resource jQuery -->
    <!-- //menu js aim --> 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster --> 
</body>
</html>