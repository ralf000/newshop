/*price range*/

$('#sl2').slider();

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function scrollToElement(el, indent) {
    indent = indent || 10;
    if (typeof el === 'string')
        el = $(el);
    var scrollTop = el.offset().top - indent;
    $('html, body').animate({
        scrollTop: scrollTop
    }, 700);
}

function initBasket() {
    var url = '/ajax/getProductsFromBasket';
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            var items = [];
            var allTotal = 0;
            var box = $('.miniBasket table tbody');
            box.empty();
            $.each(data, function (k, v) {
                if (typeof v === 'object') {
                    allTotal += Number(v.data.price) * Number(v.quantity);
                    items.push('<tr>\n\
                                 <td class="cart_description">\n\
                                     <p><a href="">' + v.data.title + '</a></p>\n\
                                 </td>\n\
                                 <td width="17%" class="cart_price">\n\
                                     <p>' + v.data.price + ' <i class="fa fa-rub"></i></p>\n\
                                 </td>\n\
                                 <td class="cart_quantity">\n\
                                     <div class="cart_quantity_button">\n\
                                         <a class="cart_quantity_up" href="' + v.id + '"> + </a>\n\
                                         <p class="main cart_quantity_input">' + v.quantity + '</p>\n\
                                         <a class="cart_quantity_down" href="' + v.id + '"> - </a>\n\
                                     </div>\n\
                                 </td>\n\
                                 <td width="17%" class="cart_total">\n\
                                     <p class="cart_total_price">' + Number(v.data.price) * Number(v.quantity) + ' <i class="fa fa-rub"></i></p>\n\
                                 </td>\n\
                                 <td class="cart_delete">\n\
                                     <a class="cart_quantity_delete" href="' + v.id + '"><i class="fa fa-times"></i></a>\n\
                                 </td>\n\
                             </tr>');
                }
            });
            if (items.length === 0) {
                box.append('<tr><td colspan="5" style="padding: 20px; text-align: center;">Корзина пуста</td></tr>');
                $('#basketBtns').hide();
            } else {
                box.append(items.join(''));
                $('.index_total').remove();
                $('.miniBasket table').after('<p class="index_total bg-warning" style="text-align: center">Итого: <b>' + allTotal + '</b> <i class="fa fa-rub"></i></p>');
                $('#basketBtns').show();
            }

            url3 = '/ajax/getNumProductsFromBasket';
            $.get(url3, function (data, status, jqXHR) {
                if (status === 'success') {
                    var span = $('.showBasket span');
                    span.empty();
                    span.append('(' + Number(data) + ')');
                    addDimamicHandlersForBasket();
                }
            });
        }
    });
}

function addDimamicHandlersForBasket() {
    $('a.cart_quantity_delete').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/deleteProductFromBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasket();
            }
        });
    });

    $('a.cart_quantity_up').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/incrementProductFromBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasket();
            }
        });
    });
    $('a.cart_quantity_down').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/reduseProductFromBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasket();
            }
        });
    });
}

function addHandlersMain() {
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('href'));
        var url = '/ajax/addToBasket';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasket();
            }
        });
    });

    $('.showBasket').on('click', function () {
        $('.miniBasket').fadeToggle();
    });

    $('.cleanBasket').on('click', function (e) {
        e.preventDefault();
        var url = '/ajax/cleanBasket';
        $.get(url, function (data, status, jqXHR) {
            if (status === 'success') {
                initBasket();
            }
        });
    });
    addDimamicHandlersForBasket();
}

/*scroll to top*/

$(document).ready(function () {
    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        scrollDistance: 300, // Distance from top/bottom before showing element (px)
        scrollFrom: 'top', // 'top' or 'bottom'
        scrollSpeed: 300, // Speed back to top (ms)
        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
        animation: 'fade', // Fade, slide, none
        animationSpeed: 200, // Animation in speed (ms)
        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
        //scrollTarget: false, // Set a custom target element for scrolling to the top
        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
        scrollTitle: false, // Set a custom <a> title if required.
        scrollImg: false, // Set true to use image
        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        zIndex: 2147483647 // Z-Index for the overlay
    });
    addHandlersMain();
    initBasket();
});
