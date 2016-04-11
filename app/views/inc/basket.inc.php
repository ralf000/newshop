<?

//
// use app\helpers\Basket;

// use app\services\Cookie;
//if (Cookie::has('basket') && count(Basket::get()) > 1)
//     $productsFromBasket = Basket::getProductsFromBasket();
?>
<div class="miniBasket" style="display: none">
    <div class="table-responsive cart_info">
        <table class="table table-condensed">
            <thead>
                <tr class="cart_menu">
                    <td class="description">Название</td>
                    <td class="price">Цена</td>
                    <td class="quantity">Количество</td>
                    <td class="total">Итого</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr><!-- ajax --></tr>
            </tbody>
        </table>
        <div id="basketBtns" style="display: none;">
            <a href="/order" class="order btn btn-default btn-block">Заказать</a>
            <a href="#" class="btn btn-block btn-default cleanBasket">Очистить</a>
        </div>
    </div>
</div>
