<!-- sign up-page -->
    <div class="login-page">
        <div class="container"> 
            <h3 class="w3ls-title w3ls-title1">Создать аккаунт</h3>  
            <div class="login-body" id='form_signup'>
                <div class='block-notice-form hidden'>
                    <img src='<?= HOST ?>/images/notice.gif'>
                    <p></p>
                </div>
                <form action='<?= HOST ?>/signup/new' method='post'>
                    <input type="text" class="user" name="name" placeholder="Имя">
                    <input type="text" class="user" name="email" placeholder="Электронная почта">
                    <p class='notice-form-error hidden'></p><br>
                    <input type="password" name="password" class="lock" placeholder="Пароль">
                    <p class='notice-form'>Пароль должен быть не менее 6 символов, содержать цифры и заглавные буквы</p><br>
                    <input type="submit" id='subReg' value="Зарегистрироваться">
                    <div class="forgot-grid">
                        <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Запомнить меня</label>
                        <div class="clearfix"> </div>
                    </div>
                </form>
            </div>  
            <h6>Уже есть аккаунт?<a href="<?= HOST ?>/login">Войти</a> </h6>
            <div class="login-page-bottom social-icons">
                <h5>Авторизация с помощью социальных сетей</h5>
                <ul>
                    <li><a href="<?= $urlGoogle ?>" class="fa fa-google-plus icon googleplus"> </a></li>
                    <li><a href="<?= $urlVk ?>" class="fa fa-dribbble icon dribbble"><i class="fab fa-vk"></i></a></li> 
                </ul> 
            </div>  
        </div>
    </div>
    <!-- //sign up-page --> 