function addImage() {
    ths = $('#mainimage');
    if (ths.val().search(/(.jpe?g)|(.gif)|(.png)/i) != -1) {
        $('#files').remove();
        ths.closest('.form-group')
                .append('<div id="files" class="files"><img style="width: 20%; padding: 7px;" src="' + ths.val() + '" alt="" /></div>');
    }
}

function addHandlersArticles(){
    $('.deleteArticle').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        var title = $(this).closest('tr').find('td').eq(2).text();
        title = (title && title.length > 0) ? '<br><b>' + title + '</b>?' : 'эту статью?';
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
                var id = Number(t.attr('data-id'));
                var url = '/ajax/deleteArticle';
                $.post(url, {id: id}, function (data, status, jqXHR) {
                    if (status === 'success') {
                        t.closest('tr').fadeOut();
                    }
                });
            }
        });
    });
}

function responsive_filemanager_callback(ths) {
    addImage();
}

$(function () {
    addHandlersArticles();
    addImage();
});