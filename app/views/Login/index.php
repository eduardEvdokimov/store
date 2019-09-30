<!-- login-page -->
    <div class="login-page">
        <div class="container"> 
            <h3 class="w3ls-title w3ls-title1">Вход в свой аккаунт</h3>  
            <div class="login-body" id='form_login'>
                <div class='block-notice-form hidden'>
                    <img src='<?= HOST ?>/images/notice.gif'>
                    <p></p>
                </div>
                <form id='form-login-user' action="<?= HOST ?>/login/auth" method="post">
                    <input type="text" class="user" name="email" value="<?= $email ?>" placeholder="Электронная почта">
                    <input type="password" name="password" class="lock" value="<?= $password ?>" placeholder='Пароль'>
                    <input type="submit" value="Войти">
                    <div class="forgot-grid">
                        <label class="checkbox"><input type="checkbox" <?= $remember ?> name="checkbox"><i></i>Запомнить меня</label>
                        <div class="forgot">
                            <a href="<?= HOST ?>/login/restore-password">Забыли пароль?</a>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </form>
            </div>  
            <h6>Еще нет аккаунта?<a href="<?= HOST ?>/signup">Зарегистрироваться</a> </h6> 
            <div class="login-page-bottom social-icons">
                <h5>Авторизация с помощью социальных сетей</h5>
                <ul>
                    
                    <li><a href="<?= $urlGoogle ?>" class="fa fa-google-plus icon googleplus"> </a></li>
                    <li><a href="<?= $urlVk ?>" class="fa fa-dribbble icon dribbble"><i class="fab fa-vk"></i></a></li>
                    
                </ul> 
            </div>
        </div>
    </div>
    <!-- //login-page --> 