<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список пользователей
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Список пользователей</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роль</th>
                                <th>Дата создания</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($users as $user): ?>
                                <td><?=$user['id'];?></td>
                                <td><?=$user['name'];?></td>
                                <td><?=$user['email'];?></td>
                                <td><?=$user['role'];?></td>
                                <td><?= $user['date_registration'] ?></td>
                                <td><a href="<?=HOST_ADMIN;?>/user/edit?id=<?=$user['id'];?>"><i class="fa fa-fw fa-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <p>(<?=count($users);?> пользователей из <?=$countUsers;?>)</p>

                            <?=$pagination->run();?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->