<?
 $products            = $this->getData()[1]['products'];
 $popularProducts     = $this->getData()[1]['popularProducts'];
 $recommendedProducts = $this->getData()[1]['recommendedProducts'];
 $limit = $this->getData()[1]['paginationOptions']['limit'];
 $num = $this->getData()[1]['paginationOptions']['num'];
 $page = $this->getData()[1]['page'];
 $start = $this->getData()[1]['start'];
 $end = $this->getData()[1]['end'];
 $opt = $this->getData()[1]['paginationOptions'];
?>

<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Список товаров</h2>
        <? if (!empty($products) && is_array($products)): ?>
             <? foreach ($products as $p): ?>
                 <div class="col-sm-4">
                     <div class="product-image-wrapper">
                         <div class="single-products">
                             <div class="productinfo text-center">
                                 <img src="/<?= $p['image'] ?>" alt="" />
                                 <h2><?= $p['price'] ?> <i class="fa fa-rub"></i></h2>
                                 <p><?= $p['title'] ?></p>
                                 <a href="<?= $p['product_id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Добавить в корзину</a>
                             </div>
                             <div class="product-overlay">
                                 <div class="overlay-content">
                                     <h2><?= $p['price'] ?> <i class="fa fa-rub"></i></h2>
                                     <p><?= $p['title'] ?></p>
                                     <p><a href="/product/view/id/<?= $p['product_id'] ?>" class="btn" style="color: #fff;"><i class="fa  fa-arrow-right"></i> Подробнее</a></p>
                                     <a href="<?= $p['product_id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Добавить в корзину</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             <? endforeach; ?>
         <? else: ?>
             <?= "<p align='center'>Товаров не найдено</p>" ?>
        <? endif; ?>

    </div><!--features_items-->
    <!--        <div class="row">
                <div class="col-md-12">
                    <ul class="pagination">
                        <li class="active"><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">&raquo;</a></li>
                    </ul>
                </div>
            </div>-->
    <div class="row">
        <div class="col-sm-5">
            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                На странице: <b><?= $start ?> - <?= $end ?></b> из <b><?= $num ?></b> товаров
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                <? if ($limit < $num): ?>
                     <?= \app\helpers\Generator::pagination($limit, $page, $opt) ?>
                 <? endif; ?>
            </div>
        </div>
    </div>
    <div class="features_items">
        <h2 class="title text-center">Популярные товары</h2>
        <?= $popularProducts ?>

    </div>

    <div class="recommended_items">
        <h2 class="title text-center">Рекомендуем</h2>

        <? echo $recommendedProducts ?>

    </div>

</div>
</div>
</div>
</section>