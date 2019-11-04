<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование пользователя
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=HOST_ADMIN;?>/user/list"> Список пользователей</a></li>
        <li class="active">Редактирование пользователя</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=HOST_ADMIN;?>/user/edit" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="login">Имя и фамилия</label>
                            <input type="text" pattern="\s*\S+\s\S+\s*" class="form-control" name="name" id="login" value="<?=$user['name'];?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]+$" name="password" id="password" placeholder="Введите пароль, если хотите его изменить">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="email">Электронная почта</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?=$user['email'];?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label>Роль</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user"<?php if($user['role'] == 'user') echo ' selected'; ?>>Пользователь</option>
                                <option value="admin"<?php if($user['role'] == 'admin') echo ' selected'; ?>>Администратор</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?=$user['id'];?>">
                        <button type="submit" name="sub" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>

            <h3>Заказы пользователя</h3>
            <div class="box">
                <div class="box-body">
                    <?php if($orders): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($orders as $order): ?>
                                    <?php $class = $order['status'] ? 'success' : ''; ?>
                                    <tr class="<?=$class;?>">
                                        <td><?=$order['id'];?></td>
                                        <td><?=$order['status'] ? 'Завершен' : 'Новый';?></td>
                                        <td><?=$order['summ'];?> <?=\store\Register::get('simbols_currency')[$order['currency']];?></td>
                                        <td><?=$order['date'];?></td>
                                        <td><?=$order['update_date'];?></td>
                                        <td><a href="<?=HOST_ADMIN;?>/order/view?id=<?=$order['id'];?>"><i class="fa fa-fw fa-eye"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-danger">Пользокатель пока ничего не заказывал...</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->