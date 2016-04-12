function getDeliveryTypes(){
    var list = $('#deliveryTypeList');
    var url = '/ajax/getDeliveryTypes';
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            console.log(data);
            var items = [];
            $.each(data, function (k,v) {
                items.push('<option value="'+v.id+'">'+v.delivery_type+'</option>');
            });
            list.append(items.join(''));
            $.each(list, function (k, v) {
                status = $(this).attr('data-status');
                $(this).find('option:contains(' + status + ')').attr('selected', 'selected');
            });
        }
    });
}

function addHandlerForDeliveryType(){
    $('#deliveryTypeList').on('change', function () {
        var t = $(this);
        var orderId = Number($('.orderId span').text());
        var typeId = Number(t.find('option:selected').val());
        var url = '/ajax/setDeliveryType';
        $.get(url, {orderId: orderId, typeId: typeId}, function (data, status, jqXHR) {
            if (status === 'success') {
            }
        });
    });
}

$(function () {
    getDeliveryTypes();
    addHandlerForDeliveryType();
});

