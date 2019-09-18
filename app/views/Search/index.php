    <!-- products -->
    <div class="products">   
        <div class="container">
            <div class="col-md-12 product-w3ls-right">
                <div class="product-top">
                    <h4>Поиск по запросу "<?= $search ?>"</h4>
                    <?php if(!empty($products)): ?>
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
                    <?php endif; ?>
                    <div class="clearfix"> </div>
                </div>

                <div class="products-row">
                    <?php if(empty($products)): ?>
                    <br>
                    <h3>Товары не найдены</h3>
                    <?php else: ?>
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
                    <?php endif; ?>

                    <div class="clearfix"> </div>
                </div>

                
            </div>
            
            

            
            <?= $pagination->run() ?>
            <div class="clearfix"> </div>
        </div>
    </div>
    <!--//products-->  
