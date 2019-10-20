<div class='container'>
    <div class='header_block_comments'>
        <h3 class="w3ls-title" style="display: inline-block; float: left;">Отзывы покупателей о товаре "<?= $product['title'] ?>"&nbsp;<p style="display: inline;"><?= $countComments ?></p></h3>
        
        <div class='bth_comment' id='add-comment' title='Добавить отзыв'>
            Добавить отзыв
        </div>
    </div>
    <div class='list_comments <?= $block_comments ?>' class='active'>   
        <ul data-count='<?= count($comments) ?>' id='list-otzuv'>
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
            <?php if($countComments > 20): ?>
                <li style="text-align: center; border-bottom: none;"><a style="cursor: pointer;" id='btn-get-response'>Показать еще</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class='form_add_comment disactive' data-id='<?= $product['id'] ?>' style='margin: 20px 0;'>
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