<div class='container' id='cont-body'>
    <h3 class='w3ls-title' style="display: inline-block;">Списки желаний</h3>
    <button id='btn-add-wishlist'>+ Новый список</button>

    <div class="products-row wishlist hidden"  id='block-add-wishlist'>
        <div class='container-add-wishlist'>
            <form method="post" action='' style="margin-left: 15px;">
                <div class="form-group" style="width: 35%; max-width: 300px; display: inline-block;">
                    <input type="text" name='name' class="form-control" placeholder="Мой список желаний" required>
                </div>

                <input type="submit" id='save' value="Сохранить">
                <input type="button" id='exit' value="Отмена">
            </form>
        </div>
        <div class="clearfix"> </div>
    </div> 

    <?php if(empty($lists)): ?>
        <h3 class='msg-empty'>У вас пока нет списка желаний</h3>
    <?php else: ?>
        <?php foreach ($lists as $list): ?>
        <div class="products-row wishlist" data-id='<?= $list['id'] ?>'>
        
        <div class='container-head-list'>
            <div class='head-list'>
                <h3><?= $list['name'] ?></h3>
                <i class="far fa-edit" title='Переименовать список желаний'></i>
                <p class='btn-wishlist' id='btn-del-wishlist'>Удалить список</p>
                <?php if($list['type_def']): ?>
                <p><i class="fas fa-check"></i>&nbsp;Список по умолчанию</p>
                <?php else: ?>
                <p class='btn-wishlist' id='select-def-wishlist'>Сделать по умолчанию</p>
                <?php endif;?>
            </div>
            <?php if(isset($list['products'])): ?>
            <div class='final-summ'>
                <p><span id='count-product-wishlist'><?= $list['count'] ?></span> товаров на сумму <span id='price'><?= $list['summ'] ?>&nbsp;<?= $simbolCurrency ?></span></p>
                <button id='add-to-cart-from-wishlist'>Купить</button>
            </div>
            <?php endif;?>
            <p class='btn-wishlist hidden' id='btn-del-arr-wishlist'>Удалить из списка</p>
        </div>
    
        <div class='container-change-name-wishlist hidden'>  
        </div>

        <?php if(isset($list['products'])): ?>
        <?php foreach ($list['products'] as $product): ?>

        <div class="col-md-3 product-grids" data-id='<?= $product['id'] ?>' style="width: 280px;"> 
            <div class="agile-products chkbox-wishlist">
                <div class='head-item'>
                    <label id="container" style="display: inline; padding-left: 0; margin-bottom: 0; ">
                        <input type="checkbox" style="position: static;">
                        <span class="checkmark" style="top: 0"></span>
                    </label>

                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="<?= HOST . '/product/' . $product['alias'] ?>"><img style="height: 180px; margin: 0 auto;" src="<?= HOST . '/images/' . $product['img'] ?>" class="img-responsive" alt="img"></a>
                <div class="agile-product-text">              
                    <h5 style="overflow: hidden; height: 50px;"><a href="<?= HOST . "/product/{$product['alias']}" ?>" title='<?= $product['title'] ?>'><?= $product['small_title'] ?></a></h5> 
                    <h6 style="font-size: 1.5em;"><?= $simbolCurrency ?>&nbsp;<?= $product['price'] ?>&nbsp;
                        <?php if(!empty($product['old_price'])): ?>
                        <del style="font-size: 16px;"><?= $simbolCurrency ?>&nbsp;<?= $product['old_price'] ?></del>
                        <?php endif; ?>
                    </h6>  
  
                    <button class="w3ls-cart pw3ls-cart addToCart" data-id="<?= $product['id'] ?>"><i class="fa fa-cart-plus" aria-hidden="true"></i>Купить</button>
                    
                </div>
            </div> 
        </div>



        <?php endforeach;?>
        <div class="clearfix"> </div>
        <?php else:?>
        <p id='msg-empty-wishlist'>Ваш список желаний пока пуст</p>
        <?php endif;?>
        
        
        
    </div> 

        <?php endforeach; ?>
    <?php endif; ?>
    

    
</div>