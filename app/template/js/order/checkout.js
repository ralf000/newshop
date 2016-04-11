function initAreas() {
    $('.area').hide();
    $('.checkout_area').css('border', '');
}

function getAndAppendUserContacts(id, box) {
    var url = '/ajax/getUserAddresses';
    $.getJSON(url, {id: id}, function (data, status, jqXHR) {
        if (status === 'success') {
            var select = $('.user_address');
            select.empty();
            var items = ['<option value="0"></option>'];
            $.each(data, function (k, v) {
                if (v.address.length > 0) {
                    var index = (v.postal_code.length > 3) ? ' Индекс: ' + v.postal_code : '';
                    items.push('<option value="' + v.id + '">' + v.address + index + '</option>');
                }
            });
            if (items.length === 0) {
                var curArea = $('.area .chose_area');
                curArea.find('h4.title').hide();
                curArea.find('.box_address').hide();
                curArea.find('.new_user_address h2.or').hide();
            } else {
                select.append(items.join(''));
            }
            getUserPhones(id, box);
        }
    });
}

function getUserPhones(id, box) {
    var url = '/ajax/getUserPhones';
    $.getJSON(url, {id: id}, function (data, status, jqXHR) {
        if (status === 'success') {
            var select = $('.user_phone');
            select.empty();
            var items = ['<option value="0"></option>'];
            $.each(data, function (k, v) {
                if (v.number.length > 0) {
                    var numType = (v.number_type.length > 0) ? ' Тип: ' + v.number_type : '';
                    items.push('<option value="' + v.id + '">' + v.number + numType + '</option>');
                }
            });
            if (items.length === 0) {
                var curArea = $('.area .chose_area');
                curArea.find('h4.title').hide();
                curArea.find('.box_phone').hide();
                curArea.find('.new_user_phone h2.or').hide();
            } else {
                select.append(items.join(''));
            }
            addDeferredHandlersCheckOut();
            box.fadeIn();
            scrollToElement(box, 40);
        }
    });
}

function confirmDataGenerator(form) {
    var output = '<table class="table table-bordered table-stripped">', label, text = '';
    var deliveryType = $('.checkout_area.checked').find('.title').text();
    output += '<tr><td><b>Тип доставки</b>:</td><td>' + deliveryType + '</td></tr>';
    var collection = form.find('input:visible:not([type=submit]):not([type=checkbox]):not([type=button])').add('select:visible option:selected').add('textarea:visible');
    $.each(collection, function (k, v) {
        v = $(v);
        text = (v.attr('type') === 'text' || v.attr('data-type') === 'textarea' || v.attr('type') === 'tel') ? v.val() : v.text();
        if (text && text.length > 0) {
            if (label = v.closest('.form-group').find('label')) {
                output += '<tr><td><b>' + label.text() + '</b>:</td><td>' + text + '</td></tr>\n';
            } else {
                output += '<tr><td colspan="2">' + text + '</td></tr>\n';
            }
        }
    });
    if (deliveryType !== 'Самовывоз') {
        var date = ($('#deliveryDate').val().length > 0) ? $('#deliveryDate').val() : 'Дата доставки не была выбрана. Удобная дата будет согласована с вами по телефону';
        var time = ($('#deliveryTime').val().length > 0) ? $('#deliveryTime').val() : 'Время доставки не было выбрано. Удобное время будет согласовано с вами по телефону';
        output += '<tr><td><b>Желаемая дата доставки</b>:</td><td>' + date + '</td></tr>';
        output += '<tr><td><b>Желаемое время доставки</b>:</td><td>' + time + '</td></tr>';
    }
    output += '<tr><td colspan="2" style="text-align="center"><h4>Состав заказа:</h4></td></tr>';
    var url = '/ajax/getProductsFromBasket';
    var deliveryPrice = 250;
    var items = [], cnt = 0, totalPrice;
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            $.each(data, function (k, v) {
                totalPrice = v.data.price * v.quantity;
                cnt += totalPrice;
                items.push('<tr>\n\
                                    <td>' + v.data.title + '</td>\n\
                                    <td>Цена: ' + v.data.price + ' <i class="fa fa-rub"></i><br>Количество: ' + v.quantity + '<br>Общая цена: ' + totalPrice + ' <i class="fa fa-rub"></i></td>\n\
                                </tr>');
            });
            output += items.join('\n');
            output += '<tr><td>Стоимость доставки:</td><td>' + deliveryPrice + ' <i class="fa fa-rub"></i></td></tr>';
            output += '<tr><td>Общая сумма заказа:</td><td>' + (cnt + deliveryPrice) + ' <i class="fa fa-rub"></i></td></tr>';
            output += '</table>';

            var box = form.find('.confirm-content');
            box.empty();
            box.append(output);
            $('#cart_items').add('.row.area.checkout_area').add('.delivery_choose').hide();
            form.find('.confirm_order').fadeIn();
            scrollToElement($('body'), 80);
        }
    });
}

function area_handler(t, e, box) {
    e.preventDefault();
    $('.checkout_area').removeClass('checked');
    initAreas();
    t.css('border', '1px solid #FE980F').addClass('checked');
    var id = Number($('.user_id').val());
    getAndAppendUserContacts(id, box);
    setTotalArea();
}

function addHandlersCheckOut() {
    $('.courier_delivery').on('click', function (e) {
        area_handler($(this), e, $('.courier_delivery_box'));
    });
    $('.mail_service').on('click', function (e) {
        area_handler($(this), e, $('.mail_service_box'));
    });
    $('.pickup').on('click', function (e) {
        area_handler($(this), e, $('.pickup_box'));
    });
    $('.user_address').on('change', function () {
        var t = $(this);
        if (t.find('option:selected').first().val() == 0)
            $('.address_cancel').click();
        else
            t.closest('.checkout_area').find('.new_user_address').fadeOut();
    });
    $('.user_phone').on('change', function () {
        var t = $(this);
        if (t.find('option:selected').first().val() == 0) {
            $('.phone_cancel').click();
        } else {
            t.closest('.checkout_area').find('.new_user_phone').fadeOut();
        }
    });
    $('.confirm_btn').on('click', function (e) {
        e.preventDefault();
        var formId = $(this).attr('data-form');
        var form = $(formId);
        confirmDataGenerator(form);
    });

    $('.reorder').on('click', function () {
        var formId = $(this).attr('data-form');
        var form = $(formId);
        $('.confirm_order').add('.row.area').hide();
        form.find('#cart_items').fadeIn();
        form.find('.row.area.checkout_area').fadeIn();
        form.find('.delivery_choose').fadeIn();
        $('.delivery_choose').add('#cart_items').fadeIn();
    });
}

function addDeferredHandlersCheckOut() {
    $('.address_cancel').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        t.closest('.checkout_area').find('.new_user_address').fadeIn();
        var opt = t.parent().prev('select').find('option:first');
        opt.attr("selected", "selected");
    });
    $('.phone_cancel').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        t.closest('.checkout_area').find('.new_user_phone').fadeIn();
        t.parent().prev('select').find('option[value="0"]').attr("selected", "selected");
    });
}

$(function () {
    addHandlersCheckOut();
});

