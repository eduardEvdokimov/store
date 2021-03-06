	<!-- breadcrumbs --> 
	<div class="container"> 
		<ol class="breadcrumb breadcrumb1">
			<?= $breadcrumbs->getHtml(); ?>
		</ol> 
		<div class="clearfix"> </div>
	</div>
	<!-- //breadcrumbs -->
	<!-- products -->
	<div class="products">	 
		<div class="container" data-id='<?= $product['id'] ?>'>  
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
						
						<div class="single-rating">
							<ul>
								<?php for($x = 0; $x < 5; $x++): ?>
                        		<?php if($x < $product['rating']): ?>
                        		<li><i class='fa fa-star' style='color: #0280e1;' aria-hidden='true'></i></li>
                        		<?php else: ?>
                        		<li><i class='fa fa-star-o' style='color: #0280e1;' aria-hidden='true'></i></li>
                        		<?php endif;?>
                        		<?php endfor; ?>   
								<li class="rating"><?= $product['count_otzuv'] ?> оценок</li>
							</ul> 
						</div>
						<div class="single-price">
							<ul>
								<li><?= $simbolCurrency . '&nbsp;' . $product['price'] ?></li> 
								<?php if($product['old_price'] > 0): ?> 
								<li><del style="font-size: 1.5em"><?= $simbolCurrency . '&nbsp;' . $product['old_price'] ?></del></li>

								<li><span class="w3off"><?= $product['discount'] ?>% СКИДКА</span></li> 
								
								<?php endif; ?>
							</ul>	
						</div> 
						<p class="single-price-text"><?= $product['little_specifications'] ?></p>
						
							<button data-id='<?= $product['id'] ?>' class="addToCart w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i>Купить</button>
						<?php if($product['wishlist']): ?>
						<button class="w3ls-cart w3ls-cart-like" id='add-wish-list'>
							<i class="fas fa-heart"></i>&nbsp;В списке желаний
						</button>
						<?php else: ?>
						<button class="w3ls-cart w3ls-cart-like" id='add-wish-list'><i class="fa fa-heart-o" aria-hidden="true"></i>&nbsp;В список желаний</button>
						<?php endif; ?>
						<?php if($issetComparison): ?>
						<button class="w3ls-cart w3ls-cart-like" data-type='press' id='add-comparison-list'><i class="fas fa-balance-scale"></i>&nbsp;Сравнивается</button>
						<?php else: ?>
						<button class="w3ls-cart w3ls-cart-like" id='add-comparison-list'><i class="fas fa-balance-scale"></i>&nbsp;К сравнению</button>
						<?php endif; ?>
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
					<?php 
						if(!empty($comments)){
							$block_comments = '';
							$block_form_add_comment = 'disactive';
						}else{
							$block_comments = 'disactive';
							$block_form_add_comment = '';
						}
					?>
					<div class='header_block_comments <?= $block_comments ?>'>
						<h3 class="w3ls-title" style="display: inline-block; float: left;">Отзывы покупателей&nbsp;<p style="display: inline;"><?= $countComments ?></p></h3>
						<div class='bth_comment' title='Добавить отзыв'>
							<i class="far fa-edit"></i>
						</div>
					</div>
					<div class='list_comments <?= $block_comments ?>' class='active'>	
						
						<ul>
							<?php foreach ($comments as $comment): ?>
							<?php if($comment['type'] == 'otzuv'): ?>
							<li data-id='<?= $comment['id'] ?>'>
								<div>
									<b class="name_user"><?= $comment['name'] ?></b>
									<div class='widget_stars'>
										<ul>
											<?php foreach ($comment['stars'] as $value): ?>
											<li><i class="fa fa-star<?= $value ?>" style='color: #0280e1;' aria-hidden="true"></i></li>
											<?php endforeach; ?>		
										</ul> 
									</div>
									<span class='date_comment'><?= $comment['date'] ?></span>
								</div>

								<p style="clear: left;"><?= $comment['comment'] ?></p>
								<p>
									<b style="color: black;">Достоинства: </b><?= $comment['good_comment'] ?>
								</p>
								<p>
									<b style="color: black;" >Недостатки: </b><?= $comment['bad_comment'] ?>			
								</p>
								<div style="margin-top: 10px;" class='footer_comment'>
									<div style="margin-top: 10px;" class='footer_response'>
									<button class='btn_response_comment' >&#8617;&nbsp;Ответить</button>
									<?php if($comment['count_response'] > 0): ?>
									<p class='btn_view_responses'>
										<i class="far fa-comment"></i>
										<span><?= $comment['count_response'] ?></span>&nbsp;ответ
									</p>
									<?php endif; ?>
									<div class='block_like_dislike'>
										<small class='c_like <?= ($comment['check_press_like'] == 'press') ? 'press' : 'counter-like' ?>  counter-like-dislike'><?= ($comment['plus_likes'] > 0) ? $comment['plus_likes'] : ''; ?>
										</small>&nbsp;<i class="fas fa-thumbs-up <?= $comment['check_press_like'] ?>" data-type='<?= ($comment['check_press_like'] == 'press') ? 'disable' : 'enable' ?>'></i>&nbsp;|&nbsp;
										<i class="fas fa-thumbs-down <?= $comment['check_press_dislike'] ?>" data-type='<?= ($comment['check_press_dislike'] == 'press') ? 'disable' : 'enable' ?>'></i>&nbsp;<small class='c_dis counter-like-dislike <?= ($comment['check_press_dislike'] == 'press') ? 'press' : 'counter-dislike' ?>'><?= ($comment['minus_likes'] > 0) ? $comment['minus_likes'] : ''; ?></small>
										</div>
									</div>
								</div>
							</li>
							<?php else: ?>
								<li data-id='<?= $comment['id'] ?>'>
								<div>
									<b class="name_user"><?= $comment['name'] ?></b>
									<span class='date_comment'><?= $comment['date'] ?></span>
								</div>
								<p style="clear: left;"><?= $comment['comment'] ?></p>
								<div style="margin-top: 10px;" class='footer_comment'>
									<div style="margin-top: 10px;" class='footer_response'>
									<button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>

									<?php if($comment['count_response'] > 0): ?>
									<p class='btn_view_responses'>
										<i class="far fa-comment"></i>
										<span><?= $comment['count_response'] ?></span>&nbsp;ответ
									</p>
									<?php endif; ?>

									<div class='block_like_dislike'>
										
										<small class='c_like <?= ($comment['check_press_like'] == 'press') ? 'press' : 'counter-like' ?> counter-like-dislike'><?= ($comment['plus_likes'] > 0) ? $comment['plus_likes'] : ''; ?>
										</small>&nbsp;<i class="fas fa-thumbs-up <?= $comment['check_press_like'] ?>" data-type='<?= ($comment['check_press_like'] == 'press') ? 'disable' : 'enable' ?>'></i>&nbsp;|&nbsp;
										<i class="fas fa-thumbs-down <?= $comment['check_press_dislike'] ?>" data-type='<?= ($comment['check_press_dislike'] == 'press') ? 'disable' : 'enable' ?>'></i>&nbsp;<small class='counter-like-dislike c_dis <?= ($comment['check_press_dislike'] == 'press') ? 'press' : 'counter-dislike' ?>'><?= ($comment['minus_likes'] > 0) ? $comment['minus_likes'] : ''; ?></small>
										</div>
									</div>
								</div>
							</li>

							<?php endif; ?>
							<?php endforeach; ?>
							
							<li style="border-bottom: none;">
								<a href='<?= HOST ?>/product/comments/<?= $product['alias'] ?>' class='view_all_comments'>Смотреть все отзывы&nbsp;&#8594;</a>
							</li>
							
						</ul>
					</div>
					
							
					<!-- Блок просмотра комментариев -->
					<!-- Отзыв о товаре -->
					<div class='form_add_comment <?= $block_form_add_comment ?>' data-id='<?= $product['id'] ?>'>
						<ul class="nav nav-tabs nav-justified" id='tabs'>
							 <li role="presentation" style="cursor: pointer;" data-type='kommentariy' class="active"><a data-active='active'>Отзыв о товаре</a></li>
							 <li role="presentation" style="cursor: pointer;" data-type='otzuv_o_tovare' class=""><a data-active=''>Краткий комментарий</a></li>
						</ul>

						

						<!-- Отзыв о товаре -->
						<div id='otzuv_o_tovare' data-type='otzuv' class="base_form_comment">
							<div style="text-align: center; margin: 20px 0;">
								<div class='stars_block' style="float: none; font-size: 3em;">
									<ul>
										<li><i class="fas fa-star stars_unchecked" data-count='1' aria-hidden="true"></i><span class='title_star'>Плохой</span></li>
										<li><i class="fas fa-star stars_unchecked" data-count='2' aria-hidden="true"></i><span class='title_star'>Так себе</span></li>
										<li><i class="fas fa-star stars_unchecked" data-count='3' aria-hidden="true"></i><span class='title_star'>Нормальный</span></li>
										<li><i class="fas fa-star stars_unchecked" data-count='4' aria-hidden="true"></i><span class='title_star'>Хороший</span></li>
										<li><i class="fas fa-star stars_unchecked" data-count='5' aria-hidden="true"></i><span class='title_star'>Отличный</span></li>
									</ul> 
								</div>
							</div>


							<form data-toggle="validator" role="form" style="margin-top: 10px;">

								<div class="form-group">
								    <label for="inputName" class="control-label">Достоинства</label>
								    <input type="text" name='good_comment' class="form-control" id="inputName" required>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Недостатки</label>
								    <input type="text" name='bad_comment' class="form-control" id="inputName" required>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Комментарий</label>
								    <textarea class="form-control" name='comment' rows="3" required></textarea>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Ваше имя и фамилия</label>
								    <?php if(isset($_SESSION['user']['auth']) && $_SESSION['user']['auth']): ?>
								    <input type="text" name='name' value="<?= $_SESSION['user']['name'] ?>" class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
								    <?php else: ?>
									<input type="text" name='name' class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
								    <?php endif; ?>
								</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Электронная почта</label>
								    <?php if(isset($_SESSION['user']['auth']) && $_SESSION['user']['auth']): ?>
								    <input type="email" name='email' value="<?= $_SESSION['user']['email'] ?>" class="form-control" readonly id="inputName" required>
								   
								    <?php else: ?>
									<input type="email" name='email' class="form-control" id="inputName" required>
								    <?php endif; ?>
								</div>

								<div class="form-group">
									<label id="container">Уведомлять об ответах по эл. почте
									  <input type="checkbox" checked="checked">
									  <span class="checkmark"></span>
									</label>
								</div>
									
								<div class="form-group" style="float: right;">
									<button type="submit" class="btn btn-primary">Оставить отзыв</button>
								</div>
							</form>
							<button type="button" class="btn btn-danger close_form_add_comment" style="float: right; margin-right: 10px;">Отмена</button>
						</div>
						<!-- Отзыв о товаре -->

						<!-- Комментарий -->
						<div id='kommentariy' data-type='comment' class='base_form_comment disactive' style="margin-top: 20px">
							<form data-toggle="validator" role="form" style="margin-top: 10px;">
							  	<div class="form-group">
							    	<label for="inputName" class="control-label">Комментарий</label>
							    	<textarea class="form-control" name='comment' rows="3" required></textarea>
							  	</div>

								<div class="form-group">
								    <label for="inputName" class="control-label">Ваше имя и фамилия</label>
								    <?php if(isset($_SESSION['user']['auth']) && $_SESSION['user']['auth']): ?>
								    <input type="text" name='name' value="<?= $_SESSION['user']['name'] ?>" class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
								    <?php else: ?>
									<input type="text" name='name' class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
								    <?php endif; ?>
								</div>

								<div class="form-group" >
								    <label for="inputName" class="control-label">Электронная почта</label>
								    <?php if(isset($_SESSION['user']['auth']) && $_SESSION['user']['auth']): ?>
								    <input type="email" name='email' value="<?= $_SESSION['user']['email'] ?>" class="form-control" readonly id="inputName" required>
								    <?php else: ?>
									<input type="email" name='email' class="form-control" id="inputName" required>
								    <?php endif; ?>
								</div>

								<div class="form-group">
									<label id="container">Уведомлять об ответах по эл. почте
									  <input type="checkbox" checked="checked">
									  <span class="checkmark"></span>
									</label>
								</div>
						
							 	<div class="form-group" style="float: right;">
							    	<button type="submit" class="btn btn-primary">Оставить комментарий</button>
							  	</div>
							</form>
							<button type="button" class="btn btn-danger close_form_add_comment" style="float: right; margin-right: 10px;">Отмена</button>
						</div>
						<!-- Комментарий -->
					</div>
					
				</div>
				<!-- Отзыв о товаре -->
			</div>



<!-- recommendations -->
			<?php if(!empty($viewedProducts)): ?>
			<div class="recommend">
				<h3 class="w3ls-title">Просмотренные ранее</h3> 
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
					<?php foreach ($viewedProducts as $viewedProduct): ?>
					<div class="item">
						<div class="glry-w3agile-grids agileits" style="height: 250px;">
							<?= $viewedProduct['sticker'] ?>
							<a href="<?= HOST . "/product/{$viewedProduct['alias']}" ?>"><img src="<?= HOST . "/images/{$viewedProduct['img']}" ?>" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a title='<?= $viewedProduct['title'] ?>' href="<?= HOST . "/product/{$viewedProduct['alias']}" ?>"><?= $viewedProduct['small_title'] ?></a></h4>
								
								<h5><?= $simbolCurrency . '&nbsp;' . $viewedProduct['price'] ?></h5>
								<button class="w3ls-cart addToCart" data-id='<?= $viewedProduct['id'] ?>'><i class="fa fa-cart-plus" aria-hidden="true"></i>Купить</button>
								
							</div>        
						</div> 
					</div>
					<?php endforeach; ?> 
				</div>    
			</div>
			<?php endif; ?>
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
