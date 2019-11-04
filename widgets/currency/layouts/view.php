<?php
$currencies = include CONFIG . '/simbols_currency.php';
?>
<?php foreach($currencies as $code => $tag): ?>
    <?php if($currentCurrency == $code): ?>
        <li class='currency'><a class="active" data-curr='<?= $code ?>'><?= $code ?> <?= $tag ?></a></li>
    <?php else: ?>
        <li class='currency'><a data-curr='<?= $code ?>'><?= $code ?> <?= $tag ?></a></li>
    <?php endif; ?>
<?php endforeach; ?>

