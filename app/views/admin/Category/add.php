<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список категорий
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=HOST_ADMIN;?>/category">Список категорий</a></li>
        <li class="active">Новая категория</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=HOST_ADMIN;?>/category/add" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование категории</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Наименование категории" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="title">Алиас</label>
                            <input type="text" name="alias" class="form-control" id="title" placeholder="Строка для запроса" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Родительская категория</label>
                            <?php new \widgets\category\Category('select_view', 'select_layout') ?>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Описание">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="sub" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->