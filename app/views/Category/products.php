    <!-- products -->
    <div class="products">   
        <div class="container">
            <div class="col-md-9 product-w3ls-right">
                <!-- breadcrumbs --> 
                <ol class="breadcrumb breadcrumb1">

                    <?= $breadcrumbs->getHtml(); ?>

                </ol> 
                <div class="clearfix"> </div>
                <!-- //breadcrumbs -->
                <div class="product-top">
                    <h4>Electronics</h4>
                    <ul> 
                        <li class="dropdown head-dpdn">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Сортировка<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">От дешевых к дорогим</a></li> 
                                <li><a href="#">От дорогих к дешевым</a></li>
                                <li><a href="#">Популярные</a></li> 
                                <li><a href="#">Новинки</a></li>
                                <li><a href="#">По рейтингу</a></li>  
                            </ul> 
                        </li>
                    </ul> 
                    <div class="clearfix"> </div>
                </div>

                <div class="products-row">
                   
                    <?php foreach($products as $product): ?>
                    <div class="col-md-3 product-grids" style="width: 280px;"> 
                        <div class="agile-products">
                            <?= $product['sticker'] ?>
                            <a href="<?= HOST . "/product/{$product['alias']}" ?>"><img style="height: 180px; margin: 0 auto;" src="<?= HOST ?>/images/<?= $product['img'] ?>" class="img-responsive" alt="img"></a>
                            <div class="agile-product-text">              
                                <h5 style="overflow: hidden; height: 50px;"><a href="<?= HOST . "/product/{$product['alias']}" ?>" title='<?= $product['title'] ?>'><?= $product['small_title'] ?></a></h5> 
                                <h6 style="font-size: 1.5em;"><?= $simbolCurrency ?>&nbsp;<?= $product['price'] ?>&nbsp;
                                    <?php if(!empty($product['old_price'])): ?>
                                    <del style="font-size: 16px;"><?= $simbolCurrency ?>&nbsp;<?= $product['old_price'] ?></del>
                                    <?php endif; ?>
                                </h6> 
                                
                                    <button class="w3ls-cart pw3ls-cart addToCart" data-id='<?= $product['id'] ?>' ><i class="fa fa-cart-plus" aria-hidden="true"></i>Купить</button>
                                
                            </div>
                        </div> 
                    </div>




                    <?php endforeach; ?>


                    <div class="clearfix"> </div>
                </div>

                
            </div>
            <div class="col-md-3 rsidebar">
                <div class="rsidebar-top">
                    <div class="slider-left">
                        <h4>Filter By Price</h4>            
                        <div class="row row1 scroll-pane">
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>0 - $100 </label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$100 - $200 </label> 
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$200 - $250  </label> 
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$250 - $300 </label> 
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$350 - $400 </label> 
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>$450 - $500  </label> 
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>More</label> 
                        </div> 
                    </div>
                    <div class="sidebar-row">
                        <h4> Electronics</h4>
                        <ul class="faq">
                            <li class="item1"><a href="#">Mobile phones<span class="glyphicon glyphicon-menu-down"></span></a>
                                <ul>
                                    <li class="subitem1"><a href="#">Smart phones</a></li>                                      
                                    <li class="subitem1"><a href="#">Accessories</a></li>                                       
                                    <li class="subitem1"><a href="#">Tabs</a></li>                                      
                                </ul>
                            </li>
                            <li class="item2"><a href="#">Large appliances<span class="glyphicon glyphicon-menu-down"></span></a>
                                <ul>
                                    <li class="subitem1"><a href="#">Refrigerators </a></li>                                        
                                    <li class="subitem1"><a href="#">Washing Machine </a></li>                                      
                                    <li class="subitem1"><a href="#">Kitchen Appliances </a></li>                                       
                                    <li class="subitem1"><a href="#">Air Conditioner</a></li>                                       
                                </ul>
                            </li>
                            <li class="item3"><a href="#">Entertainment<span class="glyphicon glyphicon-menu-down"></span></a>
                                <ul>
                                    <li class="subitem1"><a href="#"> Tv & Accessories</a></li>                                     
                                    <li class="subitem1"><a href="#">Digital Camera </a></li>                                       
                                    <li class="subitem1"><a href="#">Computer</a></li>                                      
                                </ul>
                            </li>
                        </ul>
                        <!-- script for tabs -->
                        <script type="text/javascript">
                            $(function() {
                            
                                var menu_ul = $('.faq > li > ul'),
                                       menu_a  = $('.faq > li > a');
                                
                                menu_ul.hide();
                            
                                menu_a.click(function(e) {
                                    e.preventDefault();
                                    if(!$(this).hasClass('active')) {
                                        menu_a.removeClass('active');
                                        menu_ul.filter(':visible').slideUp('normal');
                                        $(this).addClass('active').next().stop(true,true).slideDown('normal');
                                    } else {
                                        $(this).removeClass('active');
                                        $(this).next().stop(true,true).slideUp('normal');
                                    }
                                });
                            
                            });
                        </script>
                        <!-- script for tabs -->
                    </div>
                    <div class="sidebar-row">
                        <h4>DISCOUNTS</h4>
                        <div class="row row1 scroll-pane">
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Upto - 10% (20)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>70% - 60% (5)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>50% - 40% (7)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>30% - 20% (2)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>10% - 5% (5)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>30% - 20% (7)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>10% - 5% (2)</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Other(50)</label>
                        </div>
                    </div>
                    <div class="sidebar-row">
                        <h4>Color</h4>
                        <div class="row row1 scroll-pane">
                            <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>White</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Pink</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Gold</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Blue</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Orange</label>
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i></i> Brown</label> 
                        </div>
                    </div>           
                </div>
                <div class="related-row">
                    <h4>Related Searches</h4>
                    <ul>
                        <li><a href="products.html">Air conditioner </a></li>
                        <li><a href="products.html">Gaming</a></li>
                        <li><a href="products.html">Monitors</a></li>
                        <li><a href="products.html">Pc </a></li>
                        <li><a href="products.html">Food Processors</a></li>
                        <li><a href="products.html">Oven</a></li>
                        <li><a href="products.html">Purifiers</a></li>
                        <li><a href="products.html">Oven</a></li>
                        <li><a href="products.html">Cleaners</a></li>
                        <li><a href="products.html">Small devices</a></li>
                    </ul>
                </div>
                <div class="related-row">
                    <h4>YOU MAY ALSO LIKE</h4>
                    <div class="galry-like">  
                        <a href="single.html"><img src="images/e1.png" class="img-responsive" alt="img"></a>             
                        <h4><a href="products.html">Audio speaker</a></h4> 
                        <h5>$100</h5>       
                    </div>
                </div>
            </div>
            

            
            <?= $pagination->run() ?>
            <div class="clearfix"> </div>
        </div>
    </div>
    <!--//products-->  
