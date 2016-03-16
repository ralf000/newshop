function addHandlersForEditUser() {
    $('#roles').on('change', function () {
        var t = $(this);
        var url = '/ajax/getPermsByRoleId';
        var id = Number(t.find(':selected').val());
        $.getJSON(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                var items = [];
                var list = $('#rolesList');
                list.empty().hide();
                $.each(data, function (k, v) {
                    items.push('<li>' + k + '</li>');
                });
                $('<ul/>', {
                    html: items.join('')
                }).appendTo(list);
                list.fadeIn();
            }
        });
    });

//    $('#addPhone').on('click', function () {
//        var select = $('#nnumtype');
//        var url = '/ajax/getPhonesTypes';
//        $.getJSON(url, function (data, status, jqXHR) {
//            if (status === 'success') {
//                var items = [];
//                select.empty();
//                $.each(data, function (k, v) {
//                    items.push('<option value="' + k + '">' + v.number_type + '</option>');
//                });
//                select.append(items.join(''));
//            }
//        });
//    });

    $('#newaddress').on('click', function (e) {
        e.preventDefault();
        var url = '/ajax/addUserAddress';
        var userid = $('#userid');
        var address = $('#naddress');
        var postal = $('#npostal');
        if (address.val().length === 0) {
            var label = address.prev('label');
            label.text('Адрес');
            label.css('color', 'red').text(label.text() + ' (Не указан адрес)');
            return false;
        }
        var data = {
            userid: userid.val(),
            address: address.val(),
            postal: postal.val()
        };
        $.post(url, data, function (data, status, jqXHR) {
            if (status === 'success') {
                location.reload();
            }
        });
    });

    $('#naddress').on('input', function () {
        var label = $(this).prev('label');
        label.css('color', '').text('Адрес');
    });

    $('#newphone').on('click', function (e) {
        e.preventDefault();
        var url = '/ajax/addUserPhone';
        var userid = $('#userid');
        var number = $('#nnumber');
        var numtype = $('#nnumtype option:selected');
        if (number.val().length === 0) {
            var label = number.prev('label');
            label.text('Телефон');
            label.css('color', 'red').text(label.text() + ' (Не указан телефон)');
            return false;
        }
        var data = {
            userid: userid.val(),
            number: number.val(),
            numtype: numtype.text()
        };
        $.post(url, data, function (data, status, jqXHR) {
            if (status === 'success') {
                location.reload();
            }
        });
    });

    $('#nnumber').on('input', function () {
        var label = $(this).prev('label');
        label.css('color', '').text('Телефон');
    });

    $('.delAddress').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var msg = 'Вы точно хотите удалить ' + t.prev('label').text() + '?';

        swal({
            title: "Вы уверены?",
            text: msg,
            html: true,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да",
            closeOnConfirm: true,
            cancelButtonText: 'Отмена'
        },
        function (flag) {
            if (flag) {
                var id = Number(t.attr('data-id'));
                var url = '/ajax/deleteUserAddress';
                $.get(url, {id: id}, function (data, status, jqXHR) {
                    if (status === 'success') {
                        var block = t.closest('.form-group');
                        block.fadeOut();
                        block.next('.form-group').fadeOut();
                    }
                });
            }
        });
    });
    
    $('.delPhone').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var msg = 'Вы точно хотите удалить ' + t.prev('label').text() + '?';

        swal({
            title: "Вы уверены?",
            text: msg,
            html: true,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да",
            closeOnConfirm: true,
            cancelButtonText: 'Отмена'
        },
        function (flag) {
            if (flag) {
                var id = Number(t.attr('data-id'));
                var url = '/ajax/deleteUserPhone';
                $.get(url, {id: id}, function (data, status, jqXHR) {
                    if (status === 'success') {
                        var block = t.closest('.form-group');
                        block.fadeOut();
                        block.next('.form-group').fadeOut();
                    }
                });
            }
        });
    });


}

$(function () {
    addHandlersForEditUser();
});


