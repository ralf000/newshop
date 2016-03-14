function addHandlersForEditUser(){
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
                    items.push('<li>'+k+'</li>');
                });
                $('<ul/>', {
                    html: items.join('')
                }).appendTo(list);
                list.fadeIn();
            }
        });
    });
    
    $('#addPhone').on('click', function () {
        var select = $('#numtype');
        var url = '/ajax/getPhonesTypes';
        $.getJSON(url, function (data, status, jqXHR) {
            if (status === 'success') {
                var items = [];
                select.empty();
                $.each(data, function (k, v) {
                    items.push('<option value="'+k+'">'+v.number_type+'</option>');
                });
                select.append(items.join(''));
            }
        });
    });
}

$(function () {
    addHandlersForEditUser();
    getPhonesTypes();
});


