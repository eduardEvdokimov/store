<?php
$categories = \widgets\category\Category::get();
$parent_id = isset($_GET['id']) ? $categories[$_GET['id']]['parent_id'] : null;
?>


<option value="<?=$key;?>"<?php if(isset($_GET['id']) && $key == $_GET['id']) echo ' disabled'; ?>>
    <?=$item['title'];?>
</option>

<?php if(isset($item['child'])): ?>
    <?php foreach ($item['child'] as $cat_id => $cat): ?>
        <option value="<?=$cat_id;?>"<?php if($cat_id == $parent_id) echo ' selected'; ?><?php if(isset($_GET['id']) && $cat_id == $_GET['id']) echo ' disabled'; ?>>
            <?=' - ' . $cat['title'];?>
        </option>
    <?php endforeach; ?>
<?php endif; ?>