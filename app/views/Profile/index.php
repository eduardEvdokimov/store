<div class='container'>
    <h3 class='w3ls-title'>Личные данные</h3>

    <form data-toggle="validator" role="form" id='form-change-name-user'>
    <table class='form-user-data'>
        <?= $data['msgSuccessConfirm'] ?>
        <?php if(!$_SESSION['user']['confirm']): ?>
        <tr>
            <td colspan="2">
                <div id='notice-msg-user-profice'>
                    <p>Отправленно письмо на эл. почту <b><?= $data['email'] ?></b> с ссылкой подтверждения.</p>
                    <p>Чтобы отправить повторно письмо нажмите кнопку "Отправить"</p>
                    <button id='send_code_confirm_email'>Отправить</button>
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><span>Имя</span></td>
            <td>
                <div class="form-group">
                    <input type="text" name='firstName' class="form-control" id="exampleFormControlInput1" value="<?= $data['firstName'] ?>" required>
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
                    <input type="text" name='lastName' class="form-control" id="exampleFormControlInput1" value="<?= $data['lastName'] ?>" required>
                </div>
            </td>
            <td>
                <a href="<?= HOST ?>/login/logout">Выход</a>
            </td>
        </tr>
        <tr>
            <td><span>Электронная почта</span></td>
            <td>
                <div class="form-group">
                    <input type="email" name='email' class="form-control" id="exampleFormControlInput1" readonly="" value="<?= $data['email'] ?>">
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
    </form>
</div>