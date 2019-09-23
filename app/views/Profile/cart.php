<div class='container'>
    <h3 class='w3ls-title <?= $hiddenH3 ?>'>Корзина пуста</h3>
                    

    <table class="table table-striped table-sm <?= $hiddenCart ?>">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th><i class="fas fa-trash"></i></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cart['cart'] as $item):  ?>
        
        <tr data-id='<?= $item['id'] ?>'>
            <td>
                <img src='<?= HOST . '/images/' . $item['img'] ?>' alt='img' style='width: 60px;'>
            </td>
            <td style="width: 50%;" ><a href='<?= HOST . '/product/' . $item['alias'] ?>'><?= $item['title'] ?></a></td>
            <td><?= $simbolCurrency . '&nbsp;' . $item['price'] ?>
            </td>
            <td>
                <div>
                    <button class='btn_box_number delCountProduct'>&#8212;</button>
                    <input type='text' class='box_number' readonly maxlength='3' value='<?= $item['count'] ?>'>
                    <button class='btn_box_number addCountProduct'>+</button>
                </div>
            </td>
            <td class='summProduct'><?= $simbolCurrency . '&nbsp;' . $item['summ'] ?></td>
            <td>
                <span style='cursor: pointer;' class='glyphicon glyphicon-remove text-danger del-item delProductCart' aria-hidden='true'></span>
            </td>
        </tr>

        <?php endforeach; ?>

        <tr class='result_line_catr' style="background: #b2ff96;">
            <th scope="row" colspan="2" >Итоговая сумма</th>
            <td></td>
            <td></td>
            <td class='final_price' colspan="2" style='background: #0280e1;'>
                <span><?= $simbolCurrency . '&nbsp;' . $cart['cart.summ'] ?></span>
            </td>
        </tr>
        </tbody>
    </table>

    <div style="float: right; margin-bottom: 30px;">
        <button type="button" class="btn btn-danger clearCart <?= $hiddenCart ?>">Очистить корзину</button>
        <button type="button" class="btn btn-primary <?= $hiddenCart ?>" id='btn_addOrder'>Оформить заказ</button>
    </div>
    
</div>