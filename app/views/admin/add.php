<section class="content-header">
    <h1>
        Добавить новый товар
        <!--<small>Preview</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>
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
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span></button>
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
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span></button>
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
                    <label for="price">Цена руб.</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Цена в рублях"/>
                </div>
                <div class="form-group">
                    <label for="quant">Количество</label>
                    <input type="text" name="quant" id="quant" class="form-control" placeholder="Количество"/>
                </div>
                <div class="form-group">
                    <label for="mainimage">Главное изображение</label>
                    <input type="file" name="mainimage" id="mainimage" class="form-control"/>
                    <p class="help-block">Основное изображение товара</p>
                </div>
                <div class="form-group">
                    <label for="images">Остальные изображения</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple/>
                    <p class="help-block">Изображения для галереи товара</p>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="published" value="1">
                        Опубликовать?
                    </label>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-default" name="addprod">Отправить</button>
            </div>
        </form>

        <form id="newcarform" action="newCat" method="post">
            <input type="text" name="newcat" id="newcat" />
            <button type="submit" class="btn btn-default" name="newcarform">Добавить</button>
        </form>

        <form id="newsubcarform" action="newSubCat" method="post">
            <input type="hidden" name="categoryid" value="" id="categoryid"/>
            <input type="text" name="newsubcat" id="newsubcat" />
            <button type="submit" class="btn btn-default" name="newsubcarform">Добавить</button>
        </form>
    </div>
</section>





<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Quick Example</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form">
        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile">
                <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Check me out
                </label>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<script>
      $(function () {
        CKEDITOR.replace('desc');
        CKEDITOR.replace('spec');
      });
</script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

