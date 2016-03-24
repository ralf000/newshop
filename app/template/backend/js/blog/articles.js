function responsive_filemanager_callback(ths) {
    ths = $('#mainimage');
    if (ths.val().search(/(.jpe?g)|(.gif)|(.png)/i) != -1) {
        $('#files').remove();
        ths.closest('.form-group').append('<div id="files" class="files"><img style="width: 20%; padding: 7px;" src="' + ths.val() + '" alt="" /></div>');
    }
//    $('#fileManager').modal('hide');
}

function addHandlersArticles() {
    $('#mainimage').on('change', function () {
        if ($(this).val().search(/(.jpe?g)|(.gif)|(.png)/i) != -1) {
            $('#files').remove();
            $(this).closest('.form-group').append('<div id="files" class="files"><img style="width: 20%; padding: 7px;" src="' + $(this).val() + '" alt="" /></div>');
        }
//        responsive_filemanager_callback($(this));
    });
}

$(function () {
    addHandlersArticles();
});