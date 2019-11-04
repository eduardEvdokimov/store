<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список валют
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Список валют</li>
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
                                <th>Код</th>
                                <th>Значение</th>
                                <th>Базовая</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($currencies as $currency): ?>
                                <tr>
                                    <td><?=$currency['id']?></td>
                                    <td><?=$currency['name']?></td>
                                    <td><?=$currency['value']?></td>
                                    <td><?= $currency['base'] ? 'Да' : 'Нет' ?></td>
                                    <td>
                                        <a href="<?=HOST_ADMIN;?>/currency/edit?id=<?=$currency['id'];?>"><i class="fa fa-fw fa-pencil"></i></a>
                                        <a class="delete" href="<?=HOST_ADMIN;?>/currency/delete?id=<?=$currency['id'];?>"><i class="fa fa-fw fa-close text-danger"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

