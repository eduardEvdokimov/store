<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список товаров
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Список товаров</li>
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
                                <th>Категория</th>
                                <th>Наименование</th>
                                <th>Цена</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($products as $product): ?>
                                <tr>
                                    <td><?=$product['id'];?></td>
                                    <td><?=$product['category_title'];?></td>
                                    <td><?=$product['title'];?></td>
                                    <td><?=$product['price'];?> $</td>
                                    <td><?=$product['status'] ? 'On' : 'Off';?></td>
                                    <td><a class="delete" href="<?=HOST_ADMIN;?>/product/delete?id=<?=$product['id'];?>"><i class="fa fa-fw fa-close text-danger"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <p>(<?=count($products);?> товаров из <?=$countProduct;?>)</p>

                            <?=$pagination->run();?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->