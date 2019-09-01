

	
	<!-- breadcrumbs --> 
	<div class="container"> 
		<ol class="breadcrumb breadcrumb1">
			<?= $breadcrumbs->getHtml() ?>
		</ol> 
		<div class="clearfix"> </div>
	</div>
	<!-- //breadcrumbs -->
	<!-- products -->
	<div class="products">	 
		<div class="container">  
			<div class="single-page">
				<div class="single-page-row" id="detail-21">
					<div class="col-md-6 single-top-left">	
						<div class="flexslider">
							<ul class="slides">

								<?php $count = 0; foreach ($product['hrefs_img'] as $href): ?>
								<?php $activeImg = ($count == 0) ? 'detail_images' : ''; ?>
								<li data-thumb="<?= HOST ?>/images/<?= $href ?>">
									<div class="thumb-image <?= $activeImg ?>"> 
										<img src="<?= HOST ?>/images/<?= $href ?>" data-imagezoom="true" class="img-responsive" alt=""> 
									</div>
								</li>
								<?php if($count == 2) break; ?>
								<?php $count++; endforeach; ?>
								
								<!-- <h3 class="w3ls-title">About this item</h3> -->
							</ul>
						</div>
					</div>
					<div class="col-md-6 single-top-right">
						<h3 class="item_name"><?= $product['title'] ?></h3>
						<p>Processing Time: Item will be shipped out within 2-3 working days. </p>
						<div class="single-rating">
							<ul >
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li class="rating">20 reviews</li>
								<li><a href="#">Add your review</a></li>
							</ul> 
						</div>
						<div class="single-price">
							<ul>
								<li><?= \store\Register::get('simbolCurrency') . '&nbsp;' . $product['price'] ?></li> 
								<?php if($product['old_price'] > 0): ?> 
								<li><del><?= \store\Register::get('simbolCurrency') . '&nbsp;' . $product['old_price'] ?></del></li> 

								<li><span class="w3off"><?= $product['discount'] ?>% СКИДКА</span></li> 
								
								<?php endif; ?>
								
								<li><a href="#"><i class="fa fa-gift" aria-hidden="true"></i> Coupon</a></li>
							</ul>	
						</div> 
						<p class="single-price-text"><?= $product['little_specifications'] ?></p>
						<form action="#" method="post">
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="add" value="1" /> 
							<input type="hidden" name="w3ls_item" value="Snow Blower" /> 
							<input type="hidden" name="amount" value="540.00" /> 
							<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i>В корзину</button>
						</form>
						<button class="w3ls-cart w3ls-cart-like"><i class="fa fa-heart-o" aria-hidden="true"></i>В список желаний</button>
						<button class="w3ls-cart w3ls-cart-like"><i class="fas fa-balance-scale"></i>&nbsp;К сравнению</button>
					</div>
				   <div class="clearfix"> </div>  
				</div>
			</div> 

			<br><br><br><br>

		  	<div class="row">
				<div class='col-md-7'>
					<h3 class="w3ls-title">Характеристики</h3> 
					<?= $product['big_specifications'] ?>
				</div>
				<div class='col-md-5'>
					<!-- Блок просмотра комментариев -->
					<div class='header_block_comments'>
						<h3 class="w3ls-title" style="display: inline-block; float: left;">Отзывы покупателей</h3>
						<div class='bth_comment' title='Добавить отзыв'>
							<i class="far fa-edit"></i>
						</div>
					</div>
					<div class='list_comments' class='active'>	
						<ul>
							
							<li>
								<p>
									<b class="name_user">Эдуард Евдокимов</b>
									<div class='widget_stars'>
										<ul>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											
										</ul> 
									</div>
									<span class='date_comment'>28 августа 2019</span>
								</p>

								<p style="clear: left;">
									Текст отзыва Текст отзыва Текст отзыва  Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва  
								</p>
								<p>
									<b style="color: black;">Достоинства: </b>Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст 
								</p>
								<p>
									<b style="color: black;" >Недостатки: </b>Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст 
								</p>
								<div style="margin-top: 10px;">
									<button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>
									<div class='block_like_dislike'>
										<i class="fas fa-thumbs-up like"></i>|<i class="fas fa-thumbs-down dislike"></i>
									</div>
								</div>
							</li>
							<li>
								<p>
									<b class="name_user">Эдуард Евдокимов</b>
									<div class='widget_stars'>
										<ul>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											
										</ul> 
									</div>
									<span class='date_comment'>28 августа 2019</span>
								</p>

								<p style="clear: left;">
									Текст отзыва Текст отзыва Текст отзыва  Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва  
								</p>
								<p>
									<b style="color: black;">Достоинства: </b>Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст 
								</p>
								<p>
									<b style="color: black;" >Недостатки: </b>Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст 
								</p>
								<div style="margin-top: 10px;">
									<div style="margin-top: 10px;" id='footer_response'>
										<button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>

										<p class='btn_view_responses'>
											<i class="far fa-comment"></i>
											2 ответа
										</p>

										<div class='block_like_dislike'>
											<i class="fas fa-thumbs-up like"></i>|<i class="fas fa-thumbs-down dislike"></i>
										</div>
									</div>


									<div class='form_add_response disactive'>

										<form data-toggle="validator" role="form">
										  	<div class="form-group">
											    <label for="inputName" class="control-label">Комментарий</label>
											    <textarea class="form-control" rows="3" required></textarea>
										  	</div>

											<div class="form-group">
											    <label for="inputName" class="control-label">Ваше имя и фамилия</label>
											    <input type="text" class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
											</div>

											<div class="form-group" >
												<label for="inputName" class="control-label">Электронная почта</label>
											    <input type="email" class="form-control" id="inputName" required>
											</div>
										
											<!-- Если пользователь авторизован -->
											<!--
											<div class="form-group">
											    <label for="inputName" class="control-label">Электронная почта</label>
											    <input class="form-control" type="text" placeholder="index@mail.com" readonly>
											</div>
											-->
											<!-- Если пользователь авторизован -->
											
											<div class="form-group" style="float: right;">
												<button type="submit" class="btn btn-primary">Добавить</button>
											</div>
											<button type="button" id='close_form_add_response' class="btn btn-danger" style="float: right; margin-right: 10px;">Отмена</button>
										</form>
									
									</div>
 									

									
									<!-- Блок ответов на комментарий -->
									
									<ul class='block_responses disactive'>
										<i class="fas fa-times close" id='close_form_responses_response'></i>
										<li class="response">
											<p>
												<b class="name_user">Эдуард Евдокимов</b>
												<span class='date_comment'>28 августа 2019</span>
											</p>
											<p style="clear: left;">
												Текст отзыва Текст отзыва Текст отзыва  Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва  
											</p>
										</li>
										<li class="response">
											<p>
												<b class="name_user">Эдуард Евдокимов</b>
												<span class='date_comment'>28 августа 2019</span>
											</p>
											<p style="clear: left;">
												Текст отзыва Текст отзыва Текст отзыва  Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва  
											</p>
										</li>
										<li class="response">
											<p>
												<b class="name_user">Эдуард Евдокимов</b>
												<span class='date_comment'>28 августа 2019</span>
											</p>
											<p style="clear: left;">
												Текст отзыва Текст отзыва Текст отзыва  Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва  
											</p>
										</li>
										<li style="border-bottom: none; margin-top: 10px;">
											<a href='#' class='view_all_comments' style="">Смотреть все ответы&nbsp;&#8594;</a>
										</li>
									</ul>
									

									<!-- Блок ответов на комментарий -->

									
								</div>
							</li>
							<li>
								<p>
									<b class="name_user">Эдуард Евдокимов</b>
									<div class='widget_stars'>
										<ul>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											
										</ul> 
									</div>
									<span class='date_comment'>28 августа 2019</span>
								</p>

								<p style="clear: left;">
									Текст отзыва Текст отзыва Текст отзыва  Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва Текст отзыва  
								</p>
								
								<div style="margin-top: 10px;">
									<button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>

									<p class='btn_view_responses'>
										<i class="far fa-comment"></i>
										2 ответа
									</p>


									<div class='block_like_dislike'>
										<i class="fas fa-thumbs-up like"></i>|<i class="fas fa-thumbs-down dislike"></i>
									</div>
								</div>
							</li>

							<li style="border-bottom: none;">
								<a href='#' class='view_all_comments'>Смотреть все отзывы&nbsp;&#8594;</a>
							</li>
						</ul>
					</div>

					
					<!-- Блок просмотра комментариев -->
					<!-- Отзыв о товаре -->
				
					<div class='form_add_comment disactive'>
						<ul class="nav nav-tabs nav-justified" id='tabs'>
							 <li role="presentation" style="cursor: pointer;" data-type='kommentariy' class="active"><a data-active='active'>Отзыв о товаре</a></li>
							 <li role="presentation" style="cursor: pointer;" data-type='otzuv_o_tovare' class=""><a data-active=''>Краткий комментарий</a></li>
						</ul>

						


						<div id='otzuv_o_tovare'>
							<div style="text-align: center; margin: 20px 0;">
								<div class='stars_block' style="float: none; font-size: 3em;">
									<ul>
										<li><i class="fas fa-star" data-count='1' aria-hidden="true"></i><br><span class='title_star'>Плохой</span></li>
										<li><i class="fas fa-star" data-count='2' aria-hidden="true"></i><span class='title_star'>Так себе</span></li>
										<li><i class="fas fa-star" data-count='3' aria-hidden="true"></i><span class='title_star'>Нормальный</span></li>
										<li><i class="fas fa-star" data-count='4' aria-hidden="true"></i><span class='title_star'>Хороший</span></li>
										<li><i class="fas fa-star" data-count='5' aria-hidden="true"></i><span class='title_star'>Отличный</span></li>
									</ul> 
								</div>
							</div>


							<form data-toggle="validator" role="form" style="margin-top: 10px;">

								<div class="form-group">
								    <label for="inputName" class="control-label">Достоинства</label>
								    <input type="text" class="form-control" id="inputName" required>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Недостатки</label>
								    <input type="text" class="form-control" id="inputName" required>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Комментарий</label>
								    <textarea class="form-control" rows="3" required></textarea>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Ваше имя и фамилия</label>
								    <input type="text" class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
								</div>

								<div class="form-group" >
								    <label for="inputName" class="control-label">Электронная почта</label>
								    <input type="email" class="form-control" id="inputName" required>
								</div>
								
								  
									
								<div class="form-group" style="float: right;">
									<button type="submit" class="btn btn-primary">Добавить</button>
								</div>
							</form>
							<button type="button" class="btn btn-danger close_form_add_comment" style="float: right; margin-right: 10px;">Отмена</button>
						</div>

						<div id='kommentariy' class='disactive' style="margin-top: 20px">
							<form data-toggle="validator" role="form" style="margin-top: 10px;">
							  	<div class="form-group">
							    	<label for="inputName" class="control-label">Комментарий</label>
							    	<textarea class="form-control" rows="3" required></textarea>
							  	</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Ваше имя и фамилия</label>
								    <input type="text" class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
								</div>

								<div class="form-group" >
								    <label for="inputName" class="control-label">Электронная почта</label>
								    <input type="email" class="form-control" id="inputName" required>
								</div>
						
							 	<div class="form-group" style="float: right;">
							    	<button type="submit" class="btn btn-primary">Добавить</button>
							  	</div>
							</form>
							<button type="button" class="btn btn-danger close_form_add_comment" style="float: right; margin-right: 10px;">Отмена</button>
						</div>
					</div>
				</div>
				<!-- Отзыв о товаре -->
			</div>



<!-- recommendations -->
			<div class="recommend">
				<h3 class="w3ls-title">Our Recommendations </h3> 
				<script>
					$(document).ready(function() { 
						$("#owl-demo5").owlCarousel({
					 
						  autoPlay: 3000, //Set AutoPlay to 3 seconds
					 
						  items :4,
						  itemsDesktop : [640,5],
						  itemsDesktopSmall : [414,4],
						  navigation : true
					 
						});
						
					}); 
				</script>
				<div id="owl-demo5" class="owl-carousel">
					<div class="item">
						<div class="glry-w3agile-grids agileits">
							<div class="new-tag"><h6>20% <br> Off</h6></div>
							<a href="products1.html"><img src="<?= HOST ?>/images/f2.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products1.html">Women Sandal</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$20</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Women Sandal" /> 
									<input type="hidden" name="amount" value="20.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div> 
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<a href="products.html"><img src="<?= HOST ?>/images/e4.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products.html">Digital Camera</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$80</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Digital Camera"/> 
									<input type="hidden" name="amount" value="100.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div>  
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>New</h6></div>
							<a href="products4.html"><img src="<?= HOST ?>/images/s1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products4.html">Roller Skates</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$180</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Roller Skates"/> 
									<input type="hidden" name="amount" value="180.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<a href="products1.html"><img src="<?= HOST ?>/images/f1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products1.html">T Shirt</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$10</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="T Shirt" /> 
									<input type="hidden" name="amount" value="10.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div>    
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>New</h6></div>
							<a href="products6.html"><img src="<?= HOST ?>/images/p1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products6.html">Coffee Mug</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$14</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Coffee Mug" /> 
									<input type="hidden" name="amount" value="14.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>20% <br> Off</h6></div>
							<a href="products6.html"><img src="<?= HOST ?>/images/p2.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products6.html">Teddy bear</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$20</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Teddy bear" /> 
									<input type="hidden" name="amount" value="20.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div> 
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<a href="products4.html"><img src="<?= HOST ?>/images/s2.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products4.html">Football</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$70</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Football"/> 
									<input type="hidden" name="amount" value="70.00"/>
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div> 
					</div> 
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>Sale</h6></div>
							<a href="products3.html"><img src="<?= HOST ?>/images/h1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products3.html">Wall Clock</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$80</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Wall Clock" /> 
									<input type="hidden" name="amount" value="80.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div> 
				</div>    
			</div>
			<!-- //recommendations --> 

		</div>
	</div>
			


			
			<!-- collapse-tabs
			<div class="collpse tabs">
				<h3 class="w3ls-title">About this item</h3> 
				<div class="panel-group collpse" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a class="pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									<i class="fa fa-file-text-o fa-icon" aria-hidden="true"></i> Description <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									<i class="fa fa-info-circle fa-icon" aria-hidden="true"></i> additional information <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a> 
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							<div class="panel-body">
								Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
								<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									<i class="fa fa-check-square-o fa-icon" aria-hidden="true"></i> reviews (5) <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">
								Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title">
								<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									<i class="fa fa-question-circle fa-icon" aria-hidden="true"></i> help <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a>
							</h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
							<div class="panel-body">
								Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							</div>
						</div>
					</div>
				</div>
			</div>
			//collapse --> 
			
		</div>
	</div>
	<!--//products-->  
