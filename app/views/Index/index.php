	<!-- banner -->
	<div class="banner">
		<div id="kb" class="carousel kb_elastic animate_text kb_wrapper" data-ride="carousel" data-interval="6000" data-pause="hover">
			<!-- Wrapper-for-Slides -->
            <div class="carousel-inner" role="listbox">  
                <div class="item active"><!-- First-Slide -->
                    <img src="images/5.jpg" alt="" class="img-responsive" />
                    <div class="carousel-caption kb_caption kb_caption_right">
                        <h3 data-animation="animated flipInX">Постоянные <span>50%</span> скидки</h3>
                        <h4 data-animation="animated flipInX">Горячее предложение только сегодня</h4>
                    </div>
                </div>  
                <div class="item"> <!-- Second-Slide -->
                    <img src="images/8.jpg" alt="" class="img-responsive" />
                    <div class="carousel-caption kb_caption kb_caption_right">
                        <h3 data-animation="animated fadeInDown">Наши последние модные предложения</h3>
                        <h4 data-animation="animated fadeInUp">Актуальный стиль</h4>
                    </div>
                </div> 
                <div class="item"><!-- Third-Slide -->
                    <img src="images/3.jpg" alt="" class="img-responsive"/>
                    <div class="carousel-caption kb_caption kb_caption_center">
                        <h3 data-animation="animated fadeInLeft">Конец сезонной распродажи</h3>
                        <h4 data-animation="animated flipInX">Успей купить</h4>
                    </div>
                </div> 
            </div> 
            <!-- Left-Button -->
            <a class="left carousel-control kb_control_left" href="#kb" role="button" data-slide="prev">
				<span class="fa fa-angle-left kb_icons" aria-hidden="true"></span>
                <span class="sr-only">Предыдущий</span>
            </a> 
            <!-- Right-Button -->
            <a class="right carousel-control kb_control_right" href="#kb" role="button" data-slide="next">
                <span class="fa fa-angle-right kb_icons" aria-hidden="true"></span>
                <span class="sr-only">Следующий</span>
            </a> 
        </div>
		<script src="js/custom.js"></script>
	</div>
	<!-- //banner -->  
	<!-- welcome -->



	<!-- Слайдер топ товаров -->
	<div class="welcome"> 
		<div class="container"> 
			<div class="welcome-info">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<!-- Переключатели слайдера товаров -->
					
					<ul id="myTab" class=" nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#home" id="home-tab" role="tab" data-toggle="tab" >
								<i class="fa fa-laptop" aria-hidden="true"></i> 
								<h5><?= $htmlButtonSlider[0]['title'] ?></h5>
							</a>
						</li>
						<li role="presentation">
							<a href="#carl" role="tab" id="carl-tab" data-toggle="tab"> 
								<i class="fa fa-mobile" aria-hidden="true"></i>
								<h5><?= $htmlButtonSlider[1]['title'] ?></h5>
							</a>
						</li>
						<li role="presentation">
							<a href="#james" role="tab" id="james-tab" data-toggle="tab"> 
								<i class="fas fa-snowflake" aria-hidden="true" style="font-size: 55px;"></i>
								<h5><?= $htmlButtonSlider[2]['title'] ?></h5>
							</a>
						</li>
						<li role="presentation">
							<a href="#decor" role="tab" id="decor-tab" data-toggle="tab"> 
								<i class="fa fa-home" aria-hidden="true"></i>
								<h5><?= $htmlButtonSlider[3]['title'] ?></h5>
							</a>
						</li>
					</ul>
					<div class="clearfix"> </div>
					<!-- Переключатели слайдера товаров -->

					<!-- Плашки топ цена, скидка и новый -->
					
					<!-- Плашки топ цена, скидка и новый -->

					<h3 class="w3ls-title">Рекомендуемые товары</h3>
					<div id="myTabContent" class="tab-content">


						<?php 
							

							$count = 0;
							foreach ($productSlider as $products): ?>
							<?php 
								$class = ($count == 0) ? 'active' : '';
								if($count != 0){
									$own_demo = $count;
									$script = "<script>
												$(document).ready(function() { 
													$('#owl-demo{$own_demo}').owlCarousel({
													  autoPlay: 3000, //Set AutoPlay to 3 seconds
													  items :4,
													  itemsDesktop : [640,5],
													  itemsDesktopSmall : [414,4],
													  navigation : true
													});
												}); 
												</script>";
								}else{
									$script = '';
									$own_demo = '';
								} 
							?>
						<div role="tabpanel" class="tab-pane fade in <?= $class ?>" id="<?= $data_id_carusel[$count] ?>" aria-labelledby="<?= $data_id_carusel[$count] ?>-tab">
							<div class="tabcontent-grids">  
								<?= $script ?>
								<div id="owl-demo<?= $own_demo ?>" class="owl-carousel"> 
									<?php foreach ($products as $product): ?>
									<div class="item" >
										<div class="glry-w3agile-grids agileits" style="height: 250px;"> 
											<?= $product['sticker'] ?>
											<a href="<?= HOST . '/product/' . $product['alias'] ?>"><img width="100%" src="images/<?= $product['img'] ?>" alt="img"></a>
											<div class="view-caption agileits-w3layouts">           
												<h4><a href="<?= HOST . '/product/' . $product['alias'] ?>" title='<?= $product['title'] ?>'><?= $product['small_title'] ?></a></h4>
												<p></p>
												<h5><?= $simbolCurrency.'&nbsp;'.$product['price']?></h5> 
												
												<button class="w3ls-cart addToCart" data-id='<?= $product['id'] ?>'><i class="fa fa-cart-plus" aria-hidden="true"></i>Купить</button>
												 
											</div>   
										</div>   
									</div>
									<?php endforeach; ?>



								</div> 
							</div>
						</div>
							

						<?php $count++; endforeach; ?>

					</div> 
				</div>  
			</div>  	
		</div>  	
	</div> 
	<!-- Слайдер топ товаров -->









	<!-- //welcome -->
	<!-- add-products -->
	<div class="add-products"> 
		<div class="container">  
			<div class="add-products-row">
				<div class="w3ls-add-grids">
					<a href="products1.html"> 
						<h4>TOP 10 TRENDS FOR YOU FLAT <span>20%</span> OFF</h4>
						<h6>Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				<div class="w3ls-add-grids w3ls-add-grids-mdl">
					<a href="products1.html"> 
						<h4>SUNDAY SPECIAL DISCOUNT FLAT <span>40%</span> OFF</h4>
						<h6>Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				<div class="w3ls-add-grids w3ls-add-grids-mdl1">
					<a href="products.html"> 
						<h4>LATEST DESIGNS FOR YOU <span> Hurry !</span></h4>
						<h6>Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				<div class="clerfix"> </div>
			</div>  	
		</div>  	
	</div>
	<!-- //add-products -->
	<!-- deals -->
	<div class="deals"> 
		<div class="container"> 
			<h3 class="w3ls-title">Основные категории</h3>
			<div class="deals-row">
				<div class="col-md-3 focus-grid"> 
					<a href="<?= HOST ?>/category/link" class="wthree-btn"> 
						<div class="focus-image"><i class="fa fa-mobile"></i></div>
						<h4 class="clrchg">Связь</h4> 
					</a>
				</div>
				<div class="col-md-3 focus-grid"> 
					<a href="<?= HOST ?>/category/notebooks_&_compucters" class="wthree-btn wthree1"> 
						<div class="focus-image"><i class="fa fa-laptop"></i></div>
						<h4 class="clrchg">Ноутбуки и компьютеры</h4> 
					</a>
				</div>
				<div class="col-md-3 focus-grid"> 
					<a href="<?= HOST ?>/category/household_products" class="wthree-btn wthree3"> 
						<div class="focus-image"><i class="fa fa-home"></i></div>
						<h4 class="clrchg">Товары для дома</h4>
					</a>
				</div> 
				<div class="col-md-3 focus-grid"> 
					<a href="<?= HOST ?>/category/white_goods" class="wthree-btn wthree5"> 
						<div class="focus-image"><i class="fas fa-blender" style="font-size: 40px;"></i></div>
						<h4 class="clrchg">Бытовая техника</h4> 
					</a>
				</div> 
				<div class="clearfix"> </div>
			</div>  	
		</div>  	
	</div> 
	<!-- //deals --> 
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