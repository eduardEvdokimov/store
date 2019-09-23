<div class='container'>
    
    <h3 class='w3ls-title'>Личные данные</h3>

   

    <table class='form-user-data'>
        <tr>
            <td colspan="2">
                <div id='notice-msg-user-profice'>
                    <p>Вы не подтвердили свою почту:</p>
                    <p><b>eduard.evdokimov@inbox.ru</b></p>
                    <button>Подтвердить</button>
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><span>Имя</span></td>
            <td>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleFormControlInput1" value="Эдуард">
                </div>
            </td>
            <td>
                <a href="<?= HOST ?>/profile/change-password">Изменить пароль</a>
            </td>
        </tr>
        <tr>
            <td><span>Фамилия</span></td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="Евдокимов">
                </div>
            </td>
            <td>
                <a href="<?= HOST ?>/login/logout">Выход</a>
            </td>
        </tr>
            <td><span>Электронная почта</span></td>
            <td>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleFormControlInput1" readonly="">
                </div>
            </td>
        </tr>
        <tr style="height: 100px">
            <td></td>
            <td style="text-align: right;">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </td>
            <td></td>
        </tr>
    </table>






   
</div>