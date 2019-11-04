


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактироване валюты
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=HOST_ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=HOST_ADMIN;?>/currency">Список валют</a></li>
        <li class="active">Редактироване валюты</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=HOST_ADMIN;?>/currency/edit" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="code">Код валюты</label>
                            <input type="text" name="code" class="form-control" id="code" value="<?= $currency['name'] ?>" placeholder="USD, EUR" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="symbol_left">Тег символа валюты</label>
                            <input type="text" name="symbol" class="form-control" value="<?= $currency['tag'] ?>" id="symbol_left" placeholder="<i class='symbol'></i>">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="value">Значение</label>
                            <input type="text" name="value" class="form-control"  value="<?= $currency['value'] ?>" id="value" placeholder="Значение" required data-error="Допускаются цифры и десятичная точка" pattern="^[0-9.]{1,}$">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="value">
                                <input type="checkbox" <?= $currency['base'] ? 'checked' : '' ?> name="base">
                                Базовая валюта</label>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?= $currency['id'] ?>">
                        <button type="submit" name="sub" class="btn btn-success">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->