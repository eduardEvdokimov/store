<div class='container'>
    <?php foreach($categoryTree as $category): ?>
    <div >
        <h3 class="w3ls-title"><?= $category['title'] ?></h3>
        <?php if(isset($category['child'])): ?>
        <?php foreach ($category['child'] as $cat): ?>
        <div class='sub_category'>    
        <h3 class="w3ls-title"><?= $cat['title'] ?></h3>
            <ul style="list-style: none;">
                <?php if(isset($cat['child'])): ?>
            <?php foreach ($cat['child'] as $value): ?>
            

                <li style="">
                    <a href='<?= HOST . "/category/{$value['alias']}" ?>'>
                        <img src='<?= HOST . "/images/{$value['img']}" ?>' alt=''>
                        <p><?= $value['title'] ?></p>
                    </a>
                </li>

            
            <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>