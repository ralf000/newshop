<? use app\helpers\Helper; ?>
<? use app\helpers\Path; ?>

<? $product = $this->getData()[1]['products'][0] ?>
<? $images  = $this->getData()[1]['images'] ?>

<? require Path::PATH_TO_INC . 'addCategoryModal.inc.php' ?>
<? require Path::PATH_TO_INC . 'addSubCategoryModal.inc.php' ?>

<link rel="stylesheet" href="/app/template/css/jquery.fileupload.css">
<link rel="stylesheet" href="/app/template/css/jquery.fileupload-ui.css">
<script type="text/javascript" src="/app/template/backend/js/addDelSubAndCategories.js"></script>

<section class="content">
    <form action="/admin/editProduct" method="post" enctype="multipart/form-data">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <? foreach ($images as $image): ?>
                             <? if (isset($image['image']) && $image['main'] == 1): ?>
                        <div class="prodImage">
                            <a href="/<?= $image['image'] ?>"><img src="/<?= $image['image'] ?>" style="width: 100%"/></a><a href="#" data-id="<?= $image['id'] ?>" class="delImageClick"><span class="main glyphicon glyphicon-remove"></span></a>
                        </div>
                             <? endif; ?>
                         <? endforeach; ?>
                        <div id="imageList" >
                            <? foreach ($images as $image): ?>
                                 <? if (isset($image['image']) && $image['main'] != 1): ?>
                            <div class="prodImage">
                                <a href="/<?= $image['image'] ?>"><img src="/<?= $image['image'] ?>" style="width:50%; float: left;"/></a><a href="#" data-id="<?= $image['id'] ?>" class="delImageClick"><span class="glyphicon glyphicon-remove"></span></a>
                            </div>
                                 <? endif; ?>
                             <? endforeach; ?>
                        </div>
                        
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <span class="btn btn-default fileinput-button btn-block">
                                <i class="fa fa-image"></i>
                                <span>Заменить главное изображение</span>
                                <input id="mainimage" type="file" name="mainimage" accept="image/png,image/jpeg,image/gif">
                            </span>
                            <div id="files" class="files"></div>
                        </div>

                        <div class="form-group">
                            <span class="btn btn-default fileinput-button second btn-block">
                                <i class="fa fa-image"></i>
                                <span>Добавить ещё изображений</span>
                                <input id="images" type="file" name="images[]" accept="image/png,image/jpeg,image/gif" multiple>
                            </span>
                            <div id="files2" class="files"></div>
                        </div>
                    </div>
                </div>
                <div class="box box-success">
                    <div class="box-body box-profile">
                        <div class="form-group">
                            <label for="title">Наименование</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= $product['title'] ?>"/>
                        </div>
                        <input type="hidden" name="product_id" id="product_id" value="<?= $product['product_id'] ?>"/>
                        <div class="form-group">
                            <label for="cat">Категория</label>
                            <div class="input-group">
                                <select id="cat" class="form-control" name="cat">
                                    <? foreach ($this->categoryList as $c): ?>
                                    <? $selected = ($c['id'] === $product['category_id']) ? 'selected' : ''?>
                                         <option value="<?= $c['id'] ?>" <?= $selected?>><?= $c['category_name'] ?></option>
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
                                    <? $selected = ($product['subcategory_id'] === $s['id']) ? 'selected' : '111'?>
                                         <option value="<?= $s['id'] ?>" <?= $selected ?>><?= $s['subcategory_name'] ?></option>
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
                            <select id="published" class="form-control" name="published">
                                <option value="1">Да</option>
                                <option value="0" <?=$selected?>>Нет</option>
                            </select>
                        </div>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Дата публикации</b> <span class="pull-right"><?= Helper::dateConverter($product['created_time']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Дата обновления</b> <span class="pull-right"><?= Helper::dateConverter($product['updated_time']) ?></span>
                            </li>
                        </ul>
<!--                        <div class="form-group">
                            <label for="title">Дата публикации</label>
                            <input type="text" name="created_time" id="created_time" class="form-control" value="<?= Helper::dateConverter($product['created_time']) ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="title">Дата обновления</label>
                            <input type="text" name="updated_time" id="updated_time" class="form-control" value="<?= Helper::dateConverter($product['updated_time']) ?>"/>
                        </div>-->
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
                        <div class="form-group">
                            <label for="brand">Бренд</label>
                            <input type="text" name="brand" id="brand" class="form-control" value="<?= $product['brand'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="color">Цвет</label>
                            <input type="text" name="color" id="color" class="form-control" value="<?= $product['color'] ?>"/>
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
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>