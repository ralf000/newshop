<? $product = $this->getData()[1]['products'][0] ?>
<? $images  = $this->getData()[1]['images'] ?>
<link rel="stylesheet" type="text/css" media="all" href="/app/template/css/jgallery/jgallery.min.css?v=1.5.5" />
<script type="text/javascript" src="/app/template/js/jgallery/jgallery.min.js?v=1.5.5"></script>
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div id="gallery" >
                        <? foreach ($images as $image): ?>
                             <? if (isset($image['image'])): ?>
                                 <a href="/<?= $image['image'] ?>"><img src="/<?= $image['image'] ?>" alt="<?= $image['product_id'] ?>" style="width:50%; float: left;"/></a>
                             <? endif; ?>
                         <? endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body box-profile">
                    <form action="/admin/editProduct" method="post">
                        <div class="form-group">
                            <label for="title">Наименование</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= $product['title'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="cat">Категория</label>
                            <div class="input-group">
                                <select id="cat" class="form-control" name="cat">
                                    <? foreach ($this->categoryList as $c): ?>
                                         <option value="<?= $c['id'] ?>"><?= $c['category_name'] ?></option>
                                     <? endforeach; ?>
                                </select>
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="#addCategoryPopup"><span class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#addCategoryPopup"></span></a>
                                    <button class="btn btn-default" type="button" id="delCat"><span class="glyphicon glyphicon-minus"></span></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subcat">Подкатегория</label>
                            <div class="input-group">
                                <select id="subcat" class="form-control" name="subcat">
                                    <? foreach ($this->subCategoryList as $s): ?>
                                         <option value="<?= $s['id'] ?>"><?= $s['subcategory_name'] ?></option>
                                     <? endforeach; ?>
                                </select>
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="#addSubCategoryPopup"><span class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#addSubCategoryPopup"></span></a>
                                    <button class="btn btn-default" type="button" id="delSubCat"><span class="glyphicon glyphicon-minus"></span></button>
                                </span>
                            </div>
                        </div>
                        <p class="text-muted text-center"><?= $product['category_name'] ?> / <?= $product['subcategory_name'] ?></p>
                    </form>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Цена (руб.)</b> <span class="pull-right"><b><?= $product['price'] ?></b></span>
                        </li>
                        <li class="list-group-item">
                            <b>Количество</b> <span class="pull-right"><?= $product['quantity'] ?></span>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-success btn-block"><b>Сохранить</b></a>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Дополнительно</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Опубликован</b> <span class="pull-right"><?= ($product['published'] == 1) ? 'Да' : 'Нет' ?></span>
                        </li>
                        <li class="list-group-item">
                            <b>Дата публикации</b> <span class="pull-right"><?= Helper::dateConverter($product['created_time']) ?></span>
                        </li>
                        <li class="list-group-item">
                            <b>Дата обновления</b> <span class="pull-right"><?= Helper::dateConverter($product['updated_time']) ?></span>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="box box-warning">
                <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                    <h3 class="box-title">Полное описание</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?= $product['description'] ?>
                    <hr>
                    <?= Helper::tableToBootstrap($product['spec']) ?>                    
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <!--<a href="javascript::;" class="btn btn-sm btn-primary btn-flat pull-right">Редактировать</a>-->
                    <!--<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
                </div><!-- /.box-footer -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->
<? require Path::PATH_TO_INC . 'addCategoryModal.inc.php' ?>
<? require_once Path::PATH_TO_INC . 'addSubCategoryModal.inc.php' ?>

<script>
    function readURL(input, evt, box) {
        var files = evt.target.files;

        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*'))
                continue;
            var reader = new FileReader();
            reader.onload = function (e) {
                $('<img/>').attr('src', e.target.result).addClass('thumb').appendTo(box);
            };
            reader.readAsDataURL(f);
            box.fadeIn();
        }
    }
    $(".cleanImg").on('click', function (e) {
        $(this).next('.files').empty().hide();
    });
    $("#mainimage").change(function (e) {
        $('#files').empty().hide();
        readURL($(this), e, $('#files'));
    });
    $("#images").change(function (e) {
        $('#files2').empty().hide();
        readURL($(this), e, $('#files2'));
    });
    $(function () {
        $(".cleanImg").hide();
        $('#files').add('#files2').hide();
        CKEDITOR.replace('desc');
        CKEDITOR.replace('spec');
    });
</script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>