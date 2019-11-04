<?php
if(!in_array($key, $parent_keys)){
    $delete = "<a href=" . HOST_ADMIN . "/category/delete?id=" . $key . " class='delete'><i class='fa fa-fw fa-close text-danger'></i></a>";
}else{
    $delete = '<i class="fa fa-fw fa-close"></i>';
}
?>
<p class="item-p">
    <a class="list-group-item" href="<?=HOST_ADMIN;?>/category/edit?id=<?=$key;?>"><?=$item['title'];?></a> <span><?= $delete ?></span>
</p>

<?php if(isset($item['child'])): ?>
    <div class="list-group">
    <?php foreach($item['child'] as $cat_id => $cat): ?>
        <?php
        if(!in_array($cat_id, $parent_keys)){
            $delete = "<a href=" . HOST_ADMIN . "/category/delete?id=" . $cat_id . " class='delete'><i class='fa fa-fw fa-close text-danger'></i></a>";
        }else{
            $delete = '<i class="fa fa-fw fa-close"></i>';
        }
        ?>
        <p class="item-p">
            <a class="list-group-item" href="<?=HOST_ADMIN;?>/category/edit?id=<?=$cat_id;?>"><?=$cat['title'];?></a> <span><?= $delete ?></span>
        </p>
        <?php if(isset($cat['child'])): ?>
            <div class="list-group">
                <?php foreach($cat['child'] as $c_id => $c): ?>
                    <?php
                    if(!in_array($c_id, $parent_keys)){
                        $delete = "<a href=" . HOST_ADMIN . "/category/delete?id=" . $c_id . " class='delete'><i class='fa fa-fw fa-close text-danger'></i></a>";
                    }else{
                        $delete = '<i class="fa fa-fw fa-close"></i>';
                    }
                    ?>
                    <p class="item-p">
                        <a class="list-group-item" href="<?=HOST_ADMIN;?>/category/edit?id=<?=$c_id;?>"><?=$c['title'];?></a> <span><?= $delete ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
    </div>



<?php endif; ?>


