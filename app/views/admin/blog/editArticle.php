<?

 use app\services\Session; ?>
<? $article = $this->getData()[1]['article'][0] ?>
<? $author  = $this->getData()[1]['author'][0] ?>
<? // app\helpers\Helper::g($article)  ?>
<section class="content">
    <div class="box">
        <form action="editArticle" method="post" role="form">
            <div class="box-body">
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $article['title'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control" id="description" rows="3"><?= $article['description'] ?></textarea>
                </div>   
                <div class="form-group">
                    <label for="content">Статья</label>
                    <textarea name="content" id="ckeditorAddAtricle" class="form-control" rows="20"><?= $article['content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="mainimage">Главное изображение</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#fileManager">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>

                        <div class="modal fade" id="fileManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="width: 80%; height: auto;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Файловый менеджер</h4>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="/app/extensions/filemanager/dialog.php?akey=<?= Session::get('generated') ?>&upload_dir=/images/articles&type=1&field_id=mainimage" style="width: 100%; height: 70vh" frameborder="0" allowtransparency="true"></iframe>  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <input type="text" id="mainimage" name="mainimage" class="form-control" value="/<?= $article['main_image'] ?>"/>
                        
                    </div>
                </div>
                <p><b>Автор</b>: <?= $author['username'] ?></p>
                <input type="hidden" name="id" value="<?=$article['id']?>"/>
                <input type="hidden" name="author" value="<?=$author['id']?>"/>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary pull-right" value="Обновить"/>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript" src="/app/template/backend/js/blog/articles.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('ckeditorAddAtricle', {
        height: 350,
        filebrowserBrowseUrl: '/app/extensions/filemanager/dialog.php?akey=<?= Session::get('generated') ?>&type=2&editor=ckeditor',
//        filebrowserUploadUrl: '/app/extensions/filemanager/dialog.php?akey=<? //= Session::get('generated')  ?>&type=2&editor=ckeditor',
//        filebrowserImageBrowseUrl: '/app/extensions/filemanager/dialog.php?akey=<? //= Session::get('generated')  ?>&type=2&editor=ckeditor'
    });
</script>