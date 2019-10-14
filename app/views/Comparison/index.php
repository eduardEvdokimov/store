<div class='container'>
    <h3 class="w3ls-title">Списки сравнений</h3> 

    <?php if($comparison): ?>

    <?php foreach ($comparison as $category_id => $listProducts): ?>
    <div class='list-content'>

    <h3><?= $listProducts['title']; unset($listProducts['title']); ?></h3>

    <div class="products-row comparison-list" data-id='<?= $category_id ?>'>
    
    <?php foreach ($listProducts as $product): ?>
    
    <div class="col-md-3 product-grids" data-id='<?= $product['id'] ?>' style="width: 280px;"> 
        <div class="agile-products">
            <div class='head-item'>
                <i class="fas fa-times-circle btn-del-comparison-product" style="font-size: 1.6em;"></i>
            </div>

            <a href="<?= HOST . '/product/' . $product['alias'] ?>">
                <img style="height: 180px; margin: 0 auto;" src="<?= HOST . '/images/' . $product['img'] ?>" class="img-responsive" alt="img">
            </a>

            <div class="agile-product-text">              
                <h5 style="overflow: hidden; height: 50px;"><a href="<?= HOST . "/product/{$product['alias']}" ?>" title='<?= $product['title'] ?>'><?= $product['small_title'] ?></a></h5> 
                <h6 style="font-size: 1.5em;"><?= $simbolCurrency ?>&nbsp;<?= $product['price'] ?>&nbsp;
                    <?php if(!empty($product['old_price'])): ?>
                    <del style="font-size: 16px;"><?= $simbolCurrency ?>&nbsp;<?= $product['old_price'] ?></del>
                    <?php endif; ?>
                </h6>

                <button class="w3ls-cart pw3ls-cart addToCart" data-id="<?= $product['id'] ?>">
                    <i class="fa fa-cart-plus" aria-hidden="true"></i>Купить
                </button>
            </div>
        </div> 
    
    </div>
    <?php endforeach; ?>
    </div>

    <div class="clearfix" style="margin-bottom: 20px;"></div>
    <?php if(count($listProducts) > 1): ?>
    <a href='<?= HOST ?>/comparison/<?= $category_id ?>' class='comparison-products'>Сравнить эти товары</a>
    <?php endif; ?>
    </div>
    <?php endforeach ?>

    <?php else:?>
        <h3>У вас пока нет товаров для сравнения</h3>
    <?php endif; ?>
    
</div>