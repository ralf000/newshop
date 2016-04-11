function getProductsBySubcategory(id) {
    var url = '/ajax/getProductsBySubcategoryId';
    var data = {id: id};
    $.getJSON(url, data, function (data, status, jqXHR) {
        if (status === 'success') {
            var box = $('#productsBySubcategory');
            box.empty().hide();
            var items = [];
            $.each(data, function (k, v) {
                if (typeof v === 'object') {
                    items.push('<div class="col-md-3">\n\
                                        <div class="product-image-wrapper">\n\
                                            <div class="single-products">\n\
                                                <div class="productinfo text-center">\n\
                                                <a href="/product/view/id/' + v['product_id'] + '">\n\
                                                    <img src="/' + v['image'] + '" alt="' + v['title'] + '" />\n\
                                                </a>\n\
                                                <h2>' + v['price'] + ' <i class="fa fa-rub"></i></h2>\n\
                                                <p>' + v['title'] + '</p>\n\
                                                <a href="' + v['product_id'] + '" class="btn btn-default add-to-cart current">\n\
                                                    <i class="fa fa-shopping-cart"></i>\n\
                                                    В корзину\n\
                                                </a>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>');
                }
            });
            if (data.rowCount == 0)
                items.push('<p style="margin: 20px 0 40px;text-align: center;">Нет товаров для отображения</p>');
            $('<div/>', {
                html: items.join('')
            }).appendTo(box);
            box.fadeIn();

            $('.add-to-cart.current').on('click', function (e) {
                e.preventDefault();
                var t = $(this);
                var id = Number(t.attr('href'));
                var url = '/ajax/addToBasket';
                $.get(url, {id: id}, function (data, status, jqXHR) {
                    if (status === 'success') {
                        initBasket();//main.js
                    }
                });
            });
        }
    });
}

function initIndex() {
    var id = Number($('.category-tab ul li.active a').attr('data-id'));
    getProductsBySubcategory(id);
}

function addHandlersForIndex() {
    $('.showSubsProducts').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var id = Number(t.attr('data-id'));
        getProductsBySubcategory(id, t);
    });
}

$(function () {
    initIndex();
    addHandlersForIndex();
});

