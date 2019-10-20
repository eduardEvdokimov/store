<div class='container'>
	<h3 class='w3ls-title'>Мои заказы</h3>

	<div class="products-row wishlist" data-id='<?= $list['id'] ?>'>
        
        <div class='container-head-list'>
            <div class='head-list'>
                <h3>Заказ № 00000001</h3>
            </div>
            
           	<table>
                <thead>
                <tr style="background: #f9f9f9;">
                    <th>Наименование</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($products as $product): ?>
                    <tr>
                        <td><?=$product['title'] ?></td>
                        <td><?=$product['count'] ?></td>
                        <td><?=$product['price']?></td>
                        <td><?=$product['summ'] ?></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="3">Итого:</td>
                    <td><?= $_SESSION['cart.count'] ?></td>
                </tr>
                <tr>
                    <td colspan="3">На сумму:</td>
                    <td><?= $_SESSION['cart.summ']?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix"> </div>
    </div> 

</div>