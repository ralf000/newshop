<? use app\helpers\Helper; ?>

<? $articles = $this->getData()[1]['articles'] ?>
<div class="col-sm-9">
    <div class="blog-post-area">
        <h2 class="title text-center">Статьи</h2>
        <? if (is_array($articles) && !empty($articles)): ?>
     <? foreach ($articles as $a): ?>
         <? list($date, $time) = explode(' ', Helper::dateConverter($a['created_time']))?>
                 <div class="single-blog-post">
                     <h3><?= $a['title'] ?></h3>
                     <div class="post-meta">
                         <ul>
                             <li><i class="fa fa-user"></i> <?= $a['author_name'] ?></li>
                             <li><i class="fa fa-clock-o"></i> <?=  $time ?></li>
                             <li><i class="fa fa-calendar"></i> <?= $date ?></li>
                         </ul>
                     </div>
                     <a href="">
                         <img src="/<?= $a['main_image']?>" alt="">
                     </a>
                     <p><?= $a['description']?></p>
                     <a  class="btn btn-primary" href="/blog/view/id/<?= $a['id']?>">Подробнее</a>
                 </div>
     <? endforeach; ?>
 <? endif; ?>
        <div class="pagination-area">
            <ul class="pagination">
                <li><a href="" class="active">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
</section>
