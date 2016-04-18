function setPopularOrRecommended(id, type, mode) {
    var url = '/ajax/setPopularOrRecommended';
    $.get(url, {id: id, type: type, mode: mode}, function (data, status, jqXHR) {
        if (status === 'success') {
        }
    });
}

function addHandlers() {
    $('.deleteProduct').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var title = $(this).closest('tr').find('td').eq(2).text();
        title = (title && title.length > 0) ? '<br><b>' + title + '</b>?' : 'этот товар?';
        var msg = 'Вы точно хотите удалить ' + title;
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
                var id = t.attr('href');
                var url = '/ajax/deleteProduct';
                $.post(url, {id: id}, function (data, status, jqXHR) {
                    if (status === 'success') {
                        t.closest('tr').fadeOut();
                    }
                });
            }
        });
    });

    $('input.popular').on('change', function () {
        var id = Number($(this).closest('tr').children('td').eq(0).text()), mode;
        var type = 'popular';
        if ($(this).attr('checked')) {
            $(this).removeAttr('checked');
            mode = 0;
        } else {
            $(this).attr('checked', 'checked');
            mode = 1;
        }
        setPopularOrRecommended(id, type, mode);
    });
    $('input.recommended').on('change', function () {
        var id = Number($(this).closest('tr').children('td').eq(0).text()), mode;
        var type = 'recommended';
        if ($(this).attr('checked')) {
            $(this).removeAttr('checked');
            mode = 0;
        } else {
            $(this).attr('checked', 'checked');
            mode = 1;
        }
        setPopularOrRecommended(id, type, mode);
    });
}


$(function () {
    addHandlers();
    var parts = location.pathname.split('/');
    var name = '';
    for (var k in parts) {
        if (parts[k] == 'limit') {
            var num = parts[Number(k) + 1];
            continue;
        }
        if (parts[k] == 'orderBy') {
            name = parts[Number(k) + 1];
        }
        if (parts[k] == 'direction' && name.length > 0) {
            nextd = parts[Number(k) + 1];
            arrow = (nextd == 'desc') ? ' <span class="glyphicon glyphicon-chevron-down"></span>' : ' <span class="glyphicon glyphicon-chevron-up"></span>';
            var a = $('a[data-name=' + name + ']');
            a.append(arrow);
        }
    }

    //for admin allProducts view
    $('#showNumProducts select').on('change', function () {
        var limit = $(this).val(), add = false;
        var parts = location.pathname.split('/');
        var newParts = [];
        for (var k in parts) {
            if (parts[k].length !== 0)
                newParts[k] = parts[k];
        }
        for (var i in newParts) {
            if (newParts[i] == 'limit') {
                newParts[Number(i) + 1] = limit;
                add = true;
                break;
            }
        }
        if (!add)
            add = '/limit/' + limit;
        else
            add = '';
        newParts = newParts.splice(1);
        var url = '/' + newParts.join('/') + add;
        location.href = url;
    });


    $('#showNumProducts select option').each(function () {
        if (Number($(this).val()) == num)
            $(this).attr("selected", "selected");
    });

    $('.sorting').on('click', function (e) {
        e.preventDefault();
        var flag1 = false, flag2 = false, addlink = '', arrow = '';
        var name = $(this).attr('data-name');
        var parts = location.pathname.split('/');
        for (var k in parts) {
            if (parts[k] == 'orderBy') {
                parts[Number(k) + 1] = name;
                flag1 = true;
                continue;
            }
            if (parts[k] == 'direction') {
                var next = parts[Number(k) + 1].toLowerCase().trim();
                flag2 = true;
                if (next == 'asc') {
                    parts[Number(k) + 1] = 'desc';
                } else {
                    parts[Number(k) + 1] = 'asc';
                }
                continue;
            }
        }
        if (!flag1)
            addlink += '/orderBy/' + name;
        if (!flag2)
            addlink += '/direction/asc';

        path = (parts.join('/') + addlink).replace('//', '/');
        $(this).attr('href', path);
        location.href = path;
    });
});