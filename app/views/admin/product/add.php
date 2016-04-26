<link rel="stylesheet" href="/app/template/css/jquery.fileupload.css">

<? use app\helpers\Path; ?>

<link rel="stylesheet" href="/app/template/css/jquery.fileupload-ui.css">
<script type="text/javascript" src="/app/template/backend/js/addDelSubAndCategories.js"></script>
<section class="content">
    <div class="box box-primary">
        <form id="addprod" action="add" method="post" enctype="multipart/form-data" role="form">
            <div class="box-body">
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
                    <label for="title">Наименование</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок"/>
                </div>
                <div class="form-group">
                    <label for="desc">Описание</label>
                    <textarea name="desc" id="desc"  class="ckeditor form-control" rows="10" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="spec">Характеристики</label>
                    <textarea name="spec" id="spec" class="ckeditor form-control" rows="10" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="brand">Бренд</label>
                    <input type="text" name="brand" id="brand" class="form-control" placeholder="Бренд"/>
                </div>
                <div class="form-group">
                    <label for="color">Цвет</label>
                    <input type="text" name="color" id="color" class="form-control" placeholder="Цвет"/>
                </div>
                <div class="form-group">
                    <label for="price">Цена руб.</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Цена в рублях"/>
                </div>
                <div class="form-group">
                    <label for="quant">Количество</label>
                    <input type="text" name="quant" id="quant" class="form-control" placeholder="Количество"/>
                </div>
                <div class="form-group">
                    <!--<label for="mainimage">Главное изображение</label>-->
<!--                                        <input type="file" name="mainimage" id="mainimage" class="form-control"/>
                    <p class="help-block">Основное изображение товара</p>-->

                    <span class="btn btn-default fileinput-button">
                        <i class="fa fa-image"></i>
                        <span>Главное изображение</span>
                        <input id="mainimage" type="file" name="mainimage" accept="image/png,image/jpeg,image/gif">
                    </span>
                    <div id="files" class="files"></div>
                </div>

                <div class="form-group">
                    <span class="btn btn-default fileinput-button second">
                        <i class="fa fa-image"></i>
                        <span>Остальные изображения</span>
                        <input id="images" type="file" name="images[]" accept="image/png,image/jpeg,image/gif" multiple>
                    </span>
                    <div id="files2" class="files"></div>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="published" value="1">
                        Опубликовать?
                    </label>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="addprod">Отправить</button>
            </div>
        </form>
        <? require Path::PATH_TO_INC . 'addCategoryModal.inc.php' ?>
        <? require_once Path::PATH_TO_INC . 'addSubCategoryModal.inc.php' ?>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

