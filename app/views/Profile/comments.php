<div class='container'>
    <h3 class='w3ls-title <?= $hiddenH3 ?>'>Мои отзывы</h3>
    <?php if(empty($comments)): ?>
    <h3>Список пуст</h3>
    <?php else: ?>
    <div class='col-md-9 list-comments-user-profile' style="">
        <ul>
            <?php foreach ($comments as $comment): ?>
            <li>
                <div id='img-left'>
                    <a href='<?= HOST ?>/product/<?= $comment['alias'] ?>'><img src='<?= HOST ?>/images/<?= $comment['img'] ?>' alt=''></a>
                </div>
                <div id='article-right'>
                    <a href='<?= HOST ?>/product/<?= $comment['alias'] ?>'><?= $comment['title'] ?></a>
                    <p><b><?= $comment['name'] ?></b>&nbsp;<span><?= $comment['date'] ?></span></p>
                    
                    <p><?= $comment['comment'] ?></p>
                </div>
            </li>
            <?php endforeach; ?>
            <li>
                <div id='img-left'>
                    <a href=''><img src='<?= HOST ?>/images/asus/adf7f0ef166d1d475776bd68930e8c64.jpg' alt=''></a>
                </div>
                <div id='article-right'>
                    <a href=''>Универсальный набор инструмента Alloid 3/8" 82 предмета (НИ-3082П)</a>
                    <p><b>Эдуард Евдокимов</b>&nbsp;<span>20 сентября 2019</span></p>
                    
                    <p>Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий</p>
                </div>
            </li>
            <li>
                <div id='img-left'>
                    <a href=''><img src='<?= HOST ?>/images/asus/adf7f0ef166d1d475776bd68930e8c64.jpg' alt=''></a>
                </div>
                <div id='article-right'>
                    <a href=''>Универсальный набор инструмента Alloid 3/8" 82 предмета (НИ-3082П)</a>
                    <p><b>Эдуард Евдокимов</b>&nbsp;<span>20 сентября 2019</span></p>
                    
                    <p>Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий</p>
                </div>
            </li>
            <li>
                <div id='img-left'>
                    <a href=''><img src='<?= HOST ?>/images/asus/adf7f0ef166d1d475776bd68930e8c64.jpg' alt=''></a>
                </div>
                <div id='article-right'>
                    <a href=''>Универсальный набор инструмента Alloid 3/8" 82 предмета (НИ-3082П)</a>
                    <p><b>Эдуард Евдокимов</b>&nbsp;<span>20 сентября 2019</span></p>
                    
                    <p>Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий Комментарий</p>
                </div>
            </li>

        </ul>
    </div>
    <?php endif; ?>
</div>