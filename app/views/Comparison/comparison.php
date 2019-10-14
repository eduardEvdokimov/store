<div class='container'>
    <h3 class="w3ls-title">Сравниваем <?= $nameComparison ?></h3> 
    <table class='table-sravneniy table-hover'>
        <thead>
            <tr>
                <th></th>
                <?php foreach ($products as $product):?>
                <th>
                    <div>
                        <a href='<?= HOST ?>/product/<?= $product['alias'] ?>'>
                            <img src='<?= HOST . '/images/' . $product['img'] ?>' alt=''>
                        </a>
                        <a class="title" href='<?= HOST ?>/product/<?= $product['alias'] ?>'><?= $product['title'] ?></a>
                        <p><?= $simbolCurrency ?> <?= $product['price'] ?></p>
                    </div>
                </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($specs as $spec => $val): ?>
            <tr>
                <td class="spec">
                    <b><?= $spec ?></b>
                </td>
                <?php foreach ($val as $s): ?>
                    <td><p><?= $s ?></p></td>
                <?php endforeach;?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class='table-sravneniy table-hover hidden' style="position: fixed; top: 0; background: white; border-bottom: none; box-shadow: 0 10px 11px -11px rgba(51,51,51,.6);" id='test'>
        <thead>
            <tr>
                <th style="width: 200px; padding: 5px;"></th>
                <?php foreach ($products as $product):?>
                <th style="width: 200px; padding: 5px;">
                    <div>
                        <a href='<?= HOST ?>/product/<?= $product['alias'] ?>'>
                            <img src='<?= HOST . '/images/' . $product['img'] ?>' alt=''>
                        </a>
                        <a class="title" href='<?= HOST ?>/product/<?= $product['alias'] ?>'><?= $product['title'] ?></a>
                        <p><?= $simbolCurrency ?> <?= $product['price'] ?></p>
                    </div>
                </th>
                <?php endforeach; ?>
            </tr>
        </thead>
    </table>
</div>

