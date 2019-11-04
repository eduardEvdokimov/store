<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование категории Компьютеры и ноотбуки
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=HOST_ADMIN;?>/category">Список категорий</a></li>
        <li class="active">Компьютеры и ноотбуки</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=HOST_ADMIN;?>/category/edit" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование категории</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Наименование категории" value="<?=$category['title']?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="title">Алиас</label>
                            <input type="text" name="alias" class="form-control" id="title" placeholder="Путь к категории" value="<?=$category['alias']?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Родительская категория</label>
                            <?php new \widgets\category\Category('select_view', 'select_layout') ?>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова" value="<?=$category['keywords']?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Описание" value="<?=$category['description']?>">
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?=$_GET['id']?>">
                        <button type="submit" name="sub" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->