<? use app\helpers\Helper; ?>
<? use app\helpers\Path; ?>

<? $slide = $this->getData()[1]['slide'][0] ?>
<? $checked = ($slide['published'] == 1) ? 'checked' : '' ?>

<link rel="stylesheet" href="/app/template/css/jquery.fileupload.css">
<link rel="stylesheet" href="/app/template/css/jquery.fileupload-ui.css">
<script type="text/javascript" src="/app/template/backend/js/slider/editslide.js"></script>

<section class="content">
    <div class="box box-primary">
        <form id="addslide" action="addslide" method="post" enctype="multipart/form-data" role="form">
            <div class="box-body">
                <input type="hidden" name="id" value="<?= $slide['id']?>"/>
                <div class="form-group">
                    <label for="title_h1">Заголовок</label>
                    <input type="text" name="title_h1" id="title_h1" class="form-control" value="<?= $slide['title_h1']?>"/>
                </div>
                <div class="form-group">
                    <label for="title_h2">Подзаголовок</label>
                    <input type="text" name="title_h2" id="title_h2"  class="form-control" value="<?= $slide['title_h2']?>"/>
                </div>
                <div class="form-group">
                    <label for="content">Содержание</label>
                    <textarea name="content" id="content" class="ckeditor form-control" rows="10" cols="80"><?= $slide['content']?></textarea>
                </div>
                <div id="oldimage" style="border: 1px solid #D8D8D8;padding: 10px;">
                    <p><strong>Текущее изображение</strong></p>
                    <img style="width: 10%;" src="/<?= $slide['image']?>" alt=""/>
                </div>
                <span class="btn btn-success fileinput-button" style="margin: 10px 0;">
                    <i class="fa fa-image"></i>
                    <span>Заменить изображение</span>
                    <input id="mainimage" type="file" name="mainimage" accept="image/png,image/jpeg,image/gif">
                </span>
                <div id="files" class="files" style="margin-bottom: 10px;"></div>
                <div class="form-group">
                    <label for="link">Ссылка со слайда</label>
                    <input type="text" name="link" id="link" class="form-control" value="<?= $slide['link']?>"/>
                </div>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="published" value="1" <?= $checked ?>>
                        Опубликован
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