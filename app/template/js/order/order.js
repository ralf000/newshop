function initBasketFromOrder() {
    var url = '/ajax/getProductsFromBasket';
    $.getJSON(url, {mode: 1}, function (data, status, jqXHR) {
        if (status === 'success') {
            var items = [];
            var allTotal = 0;
            var box = $('.cart_info.main table tbody');
            box.empty();
            $.each(data, function (k, v) {
                if (typeof v === 'object') {
                    allTotal += Number(v.data.price) * Number(v.quantity);
                    items.push('<tr>\n\
                        <td class="cart_product">\n\
                            <a href="' + v.data.image + '"><img src="' + v.data.image + '" alt="" class="img-responsive"></a>\n\
                        </td>\n\
                        <td class="cart_description">\n\
                            <h4><a href="/product/view/id/' + v.id + '">' + v.data.title + '</a></h4>\n\
                        </td>\n\
                        <td class="cart_price">\n\
                            <p>' + v.data.price + ' <i class="fa fa-rub"></i></p>\n\
                        </td>\n\
                        <td class="cart_quantity">\n\
                            <div class="cart_quantity_button">\n\
                                <a class="cart_quantity_up_main" href="' + v.id + '"> + </a>\n\
                                <p class="main cart_quantity_input">' + v.quantity + '</p>\n\
                                <a class="cart_quantity_down_main" href="' + v.id + '"> - </a>\n\
                            </div>\n\
                        </td>\n\
                        <td class="cart_total">\n\
                            <p class="cart_total_price">' + v.data.price * v.quantity + ' <i class="fa fa-rub"></i></p>\n\
                        </td>\n\
                        <td class="cart_delete">\n\
                            <a class="cart_quantity_delete_main" href="' + v.id + '"><i class="fa fa-times"></i></a>\n\
                        </td>\n\
                    </tr>');
                }
            });
            if (items.length === 0) {
                box.append('<tr><td colspan="5" style="padding: 20px; text-align: center;"><h4>Корзина пуста</h4></td></tr>').fadeIn();
                $('#basketBtns_main').hide();
            } else {
                $('.total_main').remove();
                $('.cart_info.main table').after('<h4 class="total_main bg-warning" style="text-align: center">Итого: <b>' + allTotal + '</b> <i class="fa fa-rub"></i></h4>');
                box.append(items.join('')).fadeIn();
                $('#basketBtns_main').fadeIn();
                addHandlersOrder();
                setTotalArea();
            }
            setTimeout(function () {
                if (location.hash === '#checkout')
                    showCheckOut();
            }, 400);
        }
    });
}

function setTotalArea() {
    var url = '/ajax/getProductsFromBasket';
    var deliveryPrice = 250;
    var cnt = 0;
    var totalOrderPriceBox = $('.total_order_price span');
    var deliveryPriceBox = $('.deliveryPrice span');
    var totalOrderPricePlusDeliveryBox = $('.total_order_price_add_delivery span');
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            $.each(data, function (k, v) {
                cnt += v.data.price * v.quantity;
            });
            totalOrderPriceBox.empty();
            deliveryPriceBox.empty();
            totalOrderPricePlusDeliveryBox.empty();
            totalOrderPriceBox.append(cnt + ' <i class="fa fa-rub"></i>');
            deliveryPriceBox.append(deliveryPrice + ' <i class="fa fa-rub"></i>');
            totalOrderPricePlusDeliveryBox.append(cnt + deliveryPrice + ' <i class="fa fa-rub"></i>');
        }
    });
}

function showCheckOut() {
    history.pushState('', document.title, window.location.pathname);
    var checkoutForm = $('#do_action');
    $('#basketBtns_main').hide();
    checkoutForm.fadeIn();
    scrollToElement(checkoutForm, 40);
}

function addHandlersOrder() {
    $('a.cart_quantity_delete_main').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/deleteProductFromBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasketFromOrder();
            }
        });
    });

    $('a.cart_quantity_up_main').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/incrementProductFromBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasketFromOrder();
            }
        });
    });
    $('a.cart_quantity_down_main').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/reduseProductFromBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasketFromOrder();
            }
        });
    });
    $('.cleanBasket_main').on('click', function (e) {
        e.preventDefault();
        var url = '/ajax/cleanBasket';
        $.get(url, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasketFromOrder();
            }
        });
    });

    $('.order_main').on('click', function (e) {
        e.preventDefault();
        var url = '/ajax/checkUser';
        $.get(url, function (data, status, jqXHR) {
            if (status === 'success') {
                if (Number(data) == 1) {
                    console.log(111);
                    showCheckOut();
                } else {
                    url = '/ajax/setUserMsg';
                    $.get(url, {
                        msg: 'Авторизуйтесь или зарегистрируйтесь, для того, чтобы оформить заказ'
                    }, function (data, status, jqXHR) {
                        if (status === 'success') {
                            location.href = '/user/login?redirect=/order&hash=checkout';
                        }
                    });
                }
            }
        });
    });
}

$(function () {
    $('.cart_info.main table tbody').hide();
    $('.showBasket').hide();
    initBasketFromOrder();
});
