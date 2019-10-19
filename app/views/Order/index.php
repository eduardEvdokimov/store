<div class='container' style="height: 500px;">
    <h3 class="w3ls-title">Оформление заказа</h3> 

    <form data-toggle="validator" role="form" style="display: flex;">
    <table class='form-user-data'>
         <tr class="hidden" id='msg_success'>
            <td colspan="2">
                <div id='notice-msg-user-profice' style="background-color: #e7ffeb; border: solid 1px rgba(39, 251, 0, 0.72);">
                    <p>Заказ успешно оформлен. Для получения дополнительной информации перейдите на свою эл. почту.</p>
                </div>
            </td>   
        </tr>

        <tr class="hidden" id='msg_user_exist'>
            <td colspan="2">
                <div id='notice-msg-user-profice'>
                    <p>Пользователь с данной эл. почтой уже зарегистрирован. <a style="margin-left: 0; font-size: 1em;" href='<?= HOST ?>/login'>Авторизоваться</a></p>
                </div>
            </td>   
        </tr>

        <tr>
            <td><span>Имя и фамилия</span></td>
            <td>
                <div class="form-group">
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']['auth']): ?>
                        <input type="text" name='name' class="form-control" id="exampleFormControlInput1" pattern="^\S+\s\S+$" value="<?= $_SESSION['user']['name'] ?>" required>
                    <?php else: ?>
                        <input type="text" name='name' pattern="^\S+\s\S+$" class="form-control" id="exampleFormControlInput1" required>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php if(!isset($_SESSION['user']) || !$_SESSION['user']['auth']): ?>
        <tr>
            <td><span>Эл. почта</span></td>
            <td>
                
                <div class="form-group">
                    <input type="text" name='email' class="form-control" id="exampleFormControlInput1" required>
                </div>
                
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><span>Адрес</span></td>
            <td>
                <div class="form-group">
                    <input type="text" name='addr' class="form-control" id="exampleFormControlInput1" required>
                </div>
            </td>
        </tr>
        <tr style="height: 100px">
            <td><span>Дополнительная информация (необязательно)</span></td>
            <td>
                <div class="form-group">
                    <textarea name='notice' class='form-control' rows="3" ></textarea>
                </div>
            </td>
        </tr>
    </table>
    <div class='block-info-order'>
        <h3>Итого</h3>
        <p><span><?= $order['count'] ?></span> товаров на сумму <span class="val"><?= $order['summ'] ?>&nbsp;<?= $simbolCurrency ?></span></p>
        <p>Стоимость доставки <span class="val">бесплатно</span></p>
        <p style="border-bottom: 1px solid #cdd3d5; padding-bottom: 15px; border-top: 1px solid #cdd3d5; padding-top: 15px; ">К оплате <span class="val" style="font-size: 1.5em;"><?= $order['summ'] ?>&nbsp;<?= $simbolCurrency ?></span></p>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" id='btn-checkout-order'>Заказ подтверждаю</button>
        </div>
        <a href='#' style="text-align: center; width: 100%;" id='btn-change-order'>Редактировать заказ</a>
    </div>
    </form>



</div>