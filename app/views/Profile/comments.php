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

                <?php if(isset($comment['responses'])): ?>
                <div class='responses'>
                <div class='head-response'>Ответы</div>
                <?php foreach ($comment['responses'] as $response): ?>
                <div class='body-response'>
                    <p>
                        <b><?= $response['name'] ?></b>&nbsp;<span><?= $response['date'] ?></span>
                    </p>
                    <p><?= $response['response'] ?></p>
                </div>

                <?php endforeach; ?>
                    
                </div>
                <?php endif; ?>

            </li>
            <?php endforeach; ?>

        </ul>
    </div>
    <?php endif; ?>
</div>