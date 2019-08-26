<li class="has-children">
    <a href="<?= HOST ?>/category/<?= $item['alias'] ?>"><?= $item['title'] ?></a> 
    <ul class="cd-secondary-dropdown is-hidden" style="width: 800px;">
        <li class="go-back"><a style="cursor: pointer;">Назад</a></li>
        <?php foreach ($item['child'] as $key => $value): ?>
        <li class="has-children">
            <a href="<?= HOST ?>/category/<?= $value['alias'] ?>"><?= $value['title'] ?></a>  
            <ul class="is-hidden">
                <li class="go-back"><a style="cursor: pointer;">Назад</a></li>
                <?php foreach ($value['child'] as $key => $value1): ?>
                <li><a href="<?= HOST ?>/category/<?= $value1['alias'] ?>"><?= $value1['title'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li> 
        <?php endforeach; ?>
    </ul> 
</li> 
