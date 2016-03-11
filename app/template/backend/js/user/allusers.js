function addAllUsersHandlers(){
    $('.deleteUser').on('click',function (e) {
        e.preventDefault();
        t = $(this);
        var id = t.attr('href');
        var url = '/ajax/deleteUser';
        $.get(url, {id: id}, function (data, status, jqXHR) {
            if (status === 'success') {
                t.closest('tr').fadeOut();
            }
        });
    });
}

$(function () {
    addAllUsersHandlers();
});


