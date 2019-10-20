<div class="products-row">
<?php if($product): ?>      
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

<?php else: ?>
<h3>Товары по данному фильтру не найденны</h3>

<?php endif; ?>
<div class="clearfix"> </div>
</div>
