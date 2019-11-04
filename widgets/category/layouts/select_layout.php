<?php
$categories = \widgets\category\Category::get();
$parent_id = isset($_GET['id']) ? $categories[$_GET['id']]['parent_id'] : null;
?>
<select class="form-control" name="parent_id" id="parent_id">
    <option value="0" '<?php if(!empty($_GET['id']) && $_GET['id'] == $parent_id) echo 'selected'; ?>'>
        <?= 'Самостоятельная категория' ?>
    </option>
    <?= $view; ?>
</select>