<? $product = $this->getData()[1]['products'][0] ?>
<? $images  = $this->getData()[1]['images'] ?>

<? require Path::PATH_TO_INC . 'addCategoryModal.inc.php' ?>
<? require Path::PATH_TO_INC . 'addSubCategoryModal.inc.php' ?>

<script type="text/javascript" src="/app/template/backend/js/addDelSubAndCategories.js"></script>
<section class="content">
    <form action="/admin/editProduct" method="post">

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

                        <div class="form-group">
                            <label for="price">Цена руб.</label>
                            <input type="text" name="price" id="price" class="form-control" value="<?= $product['price'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="quant">Количество</label>
                            <input type="text" name="quant" id="quant" class="form-control" value="<?= $product['quantity'] ?>"/>
                        </div>

                        <input type="submit" class="btn btn-success btn-block" value="Сохранить">
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Дополнительно</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <? $selected = ($product['published'] != 1) ?  'selected' : '' ?>
                            <label for="published">Опубликован</label>
                            <select id="published" class="form-control" name="cat">
                                <option value="1">Да</option>
                                <option value="0" <?=$selected?>>Нет</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Дата публикации</label>
                            <input type="text" name="created_time" id="created_time" class="form-control" value="<?= Helper::dateConverter($product['created_time']) ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="title">Дата обновления</label>
                            <input type="text" name="updated_time" id="updated_time" class="form-control" value="<?= Helper::dateConverter($product['updated_time']) ?>"/>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="box box-warning">
                    <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                        <h3 class="box-title">Полное описание</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="desc">Описание</label>
                            <textarea name="desc" id="desc"  class="ckeditor form-control" rows="10" cols="80"><?= $product['description'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="spec">Характеристики</label>
                            <textarea name="spec" id="spec" class="ckeditor form-control" rows="10" cols="80"><?= $product['spec'] ?></textarea>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <!--<a href="javascript::;" class="btn btn-sm btn-primary btn-flat pull-right">Редактировать</a>-->
                        <!--<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
                    </div><!-- /.box-footer -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </form>

</section><!-- /.content -->

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
        CKEDITOR.config.height="400px";
    });
</script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>