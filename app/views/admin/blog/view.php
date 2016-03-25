<? $article = $this->getData()[1]['article'][0] ?>
<? $author  = $this->getData()[1]['author'][0] ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $article['title'] ?>
            </h3>
            <a href="/admin/editArticle/id/<?= $article['id'] ?>" class="btn btn-warning pull-right">Редактировать</a>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-body">
            <p><b>Автор</b>: <a href="<?= $author['id'] ?>"><?= $author['username'] ?></a></p>
            <p><b>Дата создания</b>: <?= app\helpers\Helper::dateConverter($article['created_time']) ?></p>
            <p><b>Дата обновления</b>: <?= app\helpers\Helper::dateConverter($article['updated_time']) ?></p>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Описание</h3>
        </div>
        <div class="box-body">
            <?= $article['description'] ?>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Содержание</h3>
        </div>
        <div class="box-body">
            <?= $article['content'] ?>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <a href="/admin/editArticle/id/<?= $article['id'] ?>" class="btn btn-warning pull-right">Редактировать</a>
        </div>
    </div>
</section>
<script type="text/javascript" src="/app/template/backend/js/blog/articles.js"></script>