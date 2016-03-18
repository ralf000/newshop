<? use app\helpers\Path; ?>

<link rel="stylesheet" href="/app/template/css/jquery.fileupload.css">
<link rel="stylesheet" href="/app/template/css/jquery.fileupload-ui.css">

<section class="content">
    <div class="box box-primary">
        <form id="addslide" action="addslide" method="post" enctype="multipart/form-data" role="form">
            <div class="box-body">
                <div class="form-group">
                    <label for="title_h1">Заголовок</label>
                    <input type="text" name="title_h1" id="title_h1" class="form-control" placeholder="Заголовок"/>
                </div>
                <div class="form-group">
                    <label for="title_h2">Подзаголовок</label>
                    <input type="text" name="title_h2" id="title_h2"  class="form-control" placeholder="Подзаголовок"/>
                </div>
                <div class="form-group">
                    <label for="content">Содержание</label>
                    <textarea name="content" id="content" class="ckeditor form-control" rows="10" cols="80"></textarea>
                </div>
                <span class="btn btn-warning fileinput-button" style="margin-bottom: 10px;">
                    <i class="fa fa-image"></i>
                    <span>Главное изображение</span>
                    <input id="mainimage" type="file" name="mainimage" accept="image/png,image/jpeg,image/gif">
                </span>
                <div id="files" class="files" style="margin-bottom: 10px;"></div>
                <div class="form-group">
                    <label for="link">Ссылка со слайда</label>
                    <input type="text" name="link" id="link" class="form-control" placeholder="Ссылка со слайда"/>
                </div>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="published" value="1">
                        Опубликовать?
                    </label>
                </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="addslide">Отправить</button>
            </div>
        </form>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript" src="/app/template/backend/js/addDelSubAndCategories.js"></script>

