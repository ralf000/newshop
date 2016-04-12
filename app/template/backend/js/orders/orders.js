function addStatusHandler() {
    var list = $('.orderStatusList');
    list.on('change', function () {
        var t = $(this);
        var orderId = Number(t.closest('tr').find('td:first').text()) || Number($('.orderId span').text());
        var statusId = Number(t.find('option:selected').val());
        var url = '/ajax/setOrderStatus';
        $.get(url, {orderId: orderId, statusId: statusId}, function (data, status, jqXHR) {
            if (status === 'success') {
            }
        });
    });
}

function addHandlerForOrders() {
    $('.deleteProductInOrder').on('click', function (e) {
        e.preventDefault();
        var orderId = Number($('#orderId').val());
        var productId = Number($(this).attr('href'));
        var url = '/ajax/deleteProductFromOrder';
        $.get(url, {orderId: orderId, productId: productId}, function (data, status, jqXHR) {
            if (status === 'success') {
                location.reload();
            }
        });
    });
    $('.plusProductInOrder').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var orderId = Number($('#orderId').val());
        var productId = Number(t.attr('href'));
        var url = '/ajax/plusProductFromOrder';
        $.get(url, {orderId: orderId, productId: productId}, function (data, status, jqXHR) {
            if (status === 'success') {
                var spanNum = t.next('span.num');
                var num = Number(spanNum.text());
                spanNum.empty().append(++num);
            }
        });
    });
    $('.minusProductInOrder').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var orderId = Number($('#orderId').val());
        var productId = Number(t.attr('href'));
        var url = '/ajax/minusProductFromOrder';
        $.get(url, {orderId: orderId, productId: productId}, function (data, status, jqXHR) {
            if (status === 'success') {
                var spanNum = t.prev('span.num');
                var num = Number(spanNum.text());
                if (num > 1)
                    spanNum.empty().append(--num);
            }
        });
    });
}

function getStatusList() {
    var url = '/ajax/getOrderStatusList';
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            var items = [], status = '';
            var list = $('.orderStatusList');
            list.empty();
            $.each(data, function (k, v) {
                items.push('<option value="' + v.id + '">' + v.status + '</option>');
            });
            list.append(items.join(''));
            $.each(list, function (k, v) {
                status = $(this).attr('data-status');
                $(this).find('option:contains(' + status + ')').attr('selected', 'selected');
            });
            addStatusHandler();
        }
    });
}

$(function () {
    getStatusList();
    addHandlerForOrders();
});


