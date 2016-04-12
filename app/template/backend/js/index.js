function addHandlersIndex() {
    $('.hidedLink').on('click', function (e) {
        e.preventDefault();
        var block = $(this).closest('table').find('.hided tr');
        block.find('td').css({
            'padding-top': '8px'
        });
        block.slideToggle();
        if ($(this).text() === 'Весь заказ')
            $(this).text('Скрыть');
        else
            $(this).text('Весь заказ');
    });
}

$(function () {
    $.each($('.ordersWidget .prodList'), function (k, v) {
        if ($(this).find('tr').length > 2) {
            var block = $(this).find('tr').slice(2);
            block.wrapAll('<div class="hided"></div>');
            block.hide();
            $(this).append('<b><a style="display: block; padding-top: 10px;" href="#" class="hidedLink">Весь заказ</a></b>');
        }
        addHandlersIndex();
    });
});
