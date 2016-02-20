function addHandlers() {
    $('#cat').on('change', function () {
        var catId = $('#cat option:selected').val();
        $('#categoryid').val(catId);
        getSubCategoriesAjax(catId);
    });

    $('#delCat').on('click', function () {
        swal({
            title: "Вы уверены?",
            text: 'Вы точно хотите удалить категорию <br><b>' + $('#cat option:selected').text() + '</b><br>а также все связанные подкатегории и товары?',
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
                var catId = $('#cat option:selected').val();
                var url = '/ajax/deleteCategory/?catid=' + catId;
                $.get(url, function (data, status, jqXHR) {
                    if (status === 'success') {
                        location.reload();
                    }
                });
            }
        });
    });

    $('#delSubCat').on('click', function () {
        swal({
            title: "Вы уверены?",
            text: 'Вы точно хотите удалить подкатегорию <br><b>' + $('#subcat option:selected').text() + '</b><br>а также все связанные товары?',
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
                var subCatId = $('#subcat option:selected').val();
                var url = '/ajax/deleteSubCategory/?subcatid=' + subCatId;
                $.get(url, function (data, status, jqXHR) {
                    if (status === 'success') {
                        location.reload();
                    }
                });
            }
        });
    });
}

function getCategoriesAjax() {
    var url = '/ajax/getCategories';
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            var cat = $('#cat');
            cat.empty();
            if (data.length > 0) {
                $(data).each(function (idx, el) {
                    cat.append('<option value="' + el.id + '">' + el.category_name + '</option>');
                });
            }
        }
    });
}

function getSubCategoriesAjax(catId) {
    var url = '/ajax/getSubCategories/?catid=' + catId;
    $.getJSON(url, function (data, status, jqXHR) {
        if (status === 'success') {
            var subCat = $('#subcat');
            subCat.empty();
            if (!$.isEmptyObject(data)) {
                for (var name in data) {
                    if (typeof (data[name]) === 'object')
                        subCat.append('<option value="' + data[name].id + '">' + data[name].subcategory_name + '</option>');
                }
            }
        }
    });
}

$(function () {
    var catId = $('#cat option:selected').val();
    $('#categoryid').val($('#cat option:selected').val());
    addHandlers();
    getSubCategoriesAjax(catId);
    
    //for pagination, blocked prev or next
    $('ul.pagination li.disabled a').on('click', function (e) {
            e.preventDefault();
        });
});

