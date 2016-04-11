<?

 use app\helpers\Helper;
 use app\services\Session;
?>

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <h2 class="title text-center">Корзина</h2>
        <div class="table-responsive cart_info main">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Изображение</td>
                        <td class="description">Название</td>
                        <td class="price">Цена</td>
                        <td class="quantity">Количество</td>
                        <td class="total">Итого</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="basketBtns_main" style="display: none;">
                <a href="/order" class="order_main btn btn-success btn-block">Оформить заказ</a>
                <a href="#" class="btn btn-block btn-warning cleanBasket_main">Очистить корзину</a>
            </div>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action" style="display: none;">
    <div class="container">
        <div class="delivery_choose">
            <div class="heading">
                <h2 class="title text-center">Оформление заказа</h2>
                <p>Выберите способ получения:</p>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="chose_area checkout_area courier_delivery">
                        <h3 class="title text-center">Доставка курьером</h3>
                        <div class="order_choose">
                            <p>Доставка в удобное для вас место и время. Осмотреть товар и принять решение можно до оплаты. Если товар не подошел, платить не нужно.</p>
                            <p>Оплата наличными или банковской картой прямо на месте.</p>
                            <p><b>Важно!</b> Доставка заказов на сумму свыше 120 тысяч рублей производится только после полной предоплаты.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="chose_area checkout_area mail_service">
                        <h3 class="title text-center">Почтовая доставка</h3>
                        <div class="order_choose">
                            <p>Доставка почтой России. Стоимость доставки по России в среднем составляют от 200 руб. Срок доставки зависит от города назначения, и составляет от 1 до 3 недель.</p>
                            <p>При желании вы можете выбрать доставку EMS Почтой России.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="chose_area checkout_area pickup">
                        <h3 class="title text-center">Самовывоз</h3>
                        <div class="order_choose">
                            <p>Вы можете совершенно бесплатно самостоятельно забрать заказ у нас в удобное для вас время.</p>
                            <p>Оплата наличными или банковской картой прямо на месте.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? require \app\helpers\Path::PATH_TO_INC . 'courier_delivery_form.inc.php'; ?>
        <? require \app\helpers\Path::PATH_TO_INC . 'mail_service_form.inc.php'; ?>
        <? require \app\helpers\Path::PATH_TO_INC . 'pickup_form.inc.php'; ?>
    </div>
</section><!--/#do_action-->
<script type="text/javascript" src="/app/template/js/order/order.js"></script>
<script type="text/javascript" src="/app/template/js/order/checkout.js"></script>
