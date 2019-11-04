<div class="col-xs-12" style="margin-top: 20px;">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Чаты с тех. поддержкой пользователей</h3>

            <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover" id="table-chats-admin-panel">
                <tbody><tr>
                    <th>Пользователь</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Сообщение</th>
                </tr>
                <?php foreach ($newChats as $chat): ?>
                    <tr style="cursor: pointer" data-hash="<?= $chat['hash'] ?>">
                        <td><?= $chat['name'] ?></td>
                        <td><?= $chat['date'] ?></td>
                        <td><span class="label label-success">Новое</span></td>
                        <td><?= $chat['msg'] ?></td>
                    </tr>
                <?php endforeach; ?>


                <!--<tr>
                    <td>657</td>
                    <td>Bob Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="label label-primary">Прочитанно</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr> -->


                </tbody></table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>