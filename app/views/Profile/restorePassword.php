<div class='container'>
    
    <h3 class='w3ls-title'>Восстановление пароля</h3>
    <form data-toggle="validator" role="form">
    <table class='form-user-data' id='form-change-password'>
        <tr>
            <td><span>Новый пароль</span></td>
            <td>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleFormControlInput1" required="">
                </div>
            </td>
        </tr>
        <tr>
            <td><span>Новый пароль еще раз</span></td>
            <td>
                <div class="form-group">
                    <input type="password" data-match="#exampleFormControlInput1" class="form-control" required="">
                </div>
            </td>
        </tr>

        <tr style="height: 20px">
            <td></td>
            <td><p class='notice-form'>Пароль должен быть не менее 6 символов, содержать цифры и заглавные буквы</p></td>
            <td></td>
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
    </form>
</div>