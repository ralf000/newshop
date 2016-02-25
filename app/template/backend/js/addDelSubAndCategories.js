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
            console.log(data);
            var subCat = $('#subcat');
            subCat.empty();
            if (!$.isEmptyObject(data)) {
                for (var name in data) {
                    console.log(data[name].id);
                    if (typeof (data[name]) === 'object')
                        subCat.append('<option value="' + data[name].id + '">' + data[name].subcategory_name + '</option>');
                }
            }
        }
    });
}

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
                        var list = $('#cat');
                        list.empty();
                        data = JSON.parse(data).reverse();
                        $(data).each(function (idx, el) {
                            list.append('<option value="' + el.id + '">' + el.category_name + '</option>');
                        });
                        var catId = $('#cat option:selected').val();
                        getSubCategoriesAjax(catId);
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
                        var catId = $('#cat option:selected').val();
                        getSubCategoriesAjax(catId);
                    }
                });
            }
        });
    });

    $('#newcatform').on('click', function () {
        var url = '/ajax/addCategory';
        var name = $('#newcat').val();
        $.post(url, {newcat: name}, function (data, status, jqXHR) {
            if (status === 'success') {
                $('#addCategoryPopup').modal('hide');
                var list = $('#cat');
                list.empty();
                data = JSON.parse(data).reverse();
                $(data).each(function (idx, el) {
                    list.append('<option value="' + el.id + '">' + el.category_name + '</option>');
                });
                var catId = $('#cat option:selected').val();
//                $('#categoryid').val(catId);
                getSubCategoriesAjax(catId);
            }
        });
    });

    $('#newsubcarform').on('click', function () {
        var catid = Number($('#cat :selected').val());
        var url = '/ajax/addSubCategory?catid=' + catid;
        var name = $('#newsubcat').val();
        $.post(url, {newsubcat: name, categoryid: catid}, function (data, status, jqXHR) {
            if (status === 'success') {
                $('#addSubCategoryPopup').modal('hide');
                var list = $('#subcat');
                list.empty();
                data = JSON.parse(data);
                for (var idx in data) {
                    if (typeof (data[idx]) === 'object')
                        list.prepend('<option value="' + data[idx].id + '">' + data[idx].subcategory_name + '</option>');
                }
            }
        });
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