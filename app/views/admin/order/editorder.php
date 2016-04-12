<?

use app\helpers\Basket;
use app\helpers\Helper;
use app\helpers\Path;

$order       = $this->getData()[1]['order'][0];
 $basketId    = Basket::getBasketId($order['body']);
 $productList = Basket::getProductsList($order['body']);
?>
<section class="content">
    <div class="box">
        <form action="editOrder" method="post" role="form">
            <div class="box-body">
                <p class="orderId">ID заказа: <span><b><?= $order['id'] ?></b></span></p>
                <p>ID корзины: <b><?= $basketId ?></b></p>
                <a class="btn btn-default" href="#addProductInOrderPopup" title="Добавить товар в заказ"><span class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#addProductInOrderPopup"></span></a>
                <label> Содержание заказа </label>
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Количество</th>
                        <th>Управление товаром</th>
                    </tr>
                    <? if ($productList && is_array($productList)): ?>
                         <? foreach ($productList as $id => $product): ?>
                             <tr>
                                 <td><?= $id ?></td>
                                 <td><a href="/admin/view/product/<?= $id ?>"><?= $product['title'] ?></a></td>
                                 <td>
                                 <a href="<?= $id ?>" class="plusProductInOrder"><span class="glyphicon glyphicon-plus"></span></a>
                                 <span class="num"><?= $product['quantity'] ?></span>
                                 <a href="<?= $id ?>" class="minusProductInOrder"><span class="glyphicon glyphicon-minus"></span></a>
                                 </td>
                                 <td>
                                     <a href="<?= $id ?>" class="deleteProductInOrder admin-data-control"><span class="glyphicon glyphicon-minus"></span></a>
                                 </td>
                             </tr>
                         <? endforeach; ?>
                     <? endif; ?>
                </table>
                <div class="form-group">
                    <label for="deliveryTypeList">Тип доставки</label>
                    <select name="deliveryTypeList" id="deliveryTypeList" data-status="<?=$order['delivery']?>" class="form-control"></select>
                </div>
                <p>Заказчик: <?= $order['user_name'] ?></p>
                <div class="form-group">
                    <label for="deliveryDate">Желаемая дата доставки</label>
                    <p><?= $order['delivery_date'] ? $order['delivery_date'] : 'Дата не указана' ?></p>
                </div>
                <div class="form-group">
                    <label for="deliveryTime">Желаемое время доставки</label>
                    <p><?= $order['delivery_time'] ? $order['delivery_time'] : 'Время не указано'?></p>
                </div>
                <div class="form-group">
                    <label for="orderStatusList">Статус заказа</label>
                    <select name="orderStatusList" data-status="<?=$order['status']['status']?>" class="form-control orderStatusList"></select>
                </div>
                <p>Добавлен: <?= Helper::dateConverter($order['created_time']) ?></p>
            </div>
        </form>
    </div>
</section>
<? require Path::PATH_TO_INC . 'addProductInOrder.inc.php' ?>
<script type="text/javascript" src="/app/template/backend/js/orders/orders.js"></script>
<script type="text/javascript" src="/app/template/backend/js/orders/editOrder.js"></script>