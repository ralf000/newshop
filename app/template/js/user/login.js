function addHandlersLogin() {
    $('.phone_plus').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        t.closest('.form-group').after('<div class="form-group">\n\
                    <a href="#" class="phone_minus"><i class="fa fa-minus-circle"></i></a> <label>Телефон</label>\n\
                    <input type="tel" name="number[]" class="form-control" placeholder="Телефон"/>\n\
                    <label>Тип телефона</label>\n\
                    <select name="numtype[]">\n\
                        <option value="Домашний">Домашний</option>\n\
                        <option value="Рабочий">Рабочий</option>\n\
                        <option value="Другой">Другой</option>\n\
                    </select></div>');
        $('.phone_minus').on('click', function (e) {
            e.preventDefault();
            var t = $(this);
            t.closest('.form-group').remove();
        });
    });
    $('.address_plus').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        t.closest('.form-group').after('<div class="form-group">\n\
                    <a href="#" class="address_minus"><i class="fa fa-minus-circle"></i></a> <label>Адрес</label>\n\
                    <input type="text" name="address[]" class="form-control" placeholder="Адрес"/>\n\
                    <label>Индекс</label>\n\
                    <input type="text" name="postal[]" class="form-control" placeholder="Индекс"/></div>');
        $('.address_minus').on('click', function (e) {
            e.preventDefault();
            var t = $(this);
            t.closest('.form-group').remove();
        });
    });
}

$(function () {
    addHandlersLogin();
});

