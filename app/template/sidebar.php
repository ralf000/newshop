<?

 use app\helpers\Path; ?>
<? $sideBarMenu = $this->getData()[0]['sideBarData']['catsAndSubCats']; ?>
<? $brands      = $this->getData()[0]['sideBarData']['brands']; ?>
<? $colors      = $this->getData()[0]['sideBarData']['colors']; ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Категории</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <? if (!empty($sideBarMenu) && is_array($sideBarMenu)): ?>
                             <? foreach ($sideBarMenu as $c): ?>
                                 <? if (isset($c['subcategories']) && is_array($c['subcategories']) && count($c['subcategories']) > 0): ?>
                                     <div class="panel panel-default">
                                         <div class="panel-heading">
                                             <h4 class="panel-title">
                                                 <a data-toggle="collapse" data-parent="#accordian" href="#<?= $c['id'] ?>">
                                                     <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                     <?= $c['category_name'] ?>
                                                 </a>
                                             </h4>
                                         </div>
                                         <div id="<?= $c['id'] ?>" class="panel-collapse collapse">
                                             <div class="panel-body">
                                                 <ul>
                                                     <? foreach ($c['subcategories'] as $s): ?>
                                                         <li><a href="/product/all?subcategory_id=<?= $s['id'] ?>"><?= $s['subcategory_name'] ?> </a></li>
                                                     <? endforeach; ?>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>
                                 <? else: ?>
                                     <div class="panel panel-default">
                                         <div class="panel-heading">
                                             <h4 class="panel-title"><a href="<?= $c['id'] ?>"><?= $c['category_name'] ?></a></h4>
                                         </div>
                                     </div>
                                 <? endif; ?>
                             <? endforeach; ?>
                         <? endif; ?>

                    </div><!--/category-products-->

                    <? if (!empty($brands) && is_array($brands)): ?>
                         <div class="brands_products"><!--brands_products-->
                             <h2>Бренды</h2>
                             <div class="brands-name">
                                 <ul class="nav nav-pills nav-stacked">
                                     <? foreach ($brands as $key => $b): ?>
                                         <li><a href="/product/all?brand=<?= $key ?>"> <span class="pull-right">(<?= $b['num'] ?>)</span><?= $key ?></a></li>
                                     <? endforeach; ?>
                                 </ul>
                             </div>
                         </div><!--/brands_products-->
                     <? endif; ?>
                         
                    <? if (!empty($colors) && is_array($colors)): ?>
                         <div class="brands_products"><!--brands_products-->
                             <h2>Цвета</h2>
                             <div class="brands-name">
                                 <ul class="nav nav-pills nav-stacked">
                                     <? foreach ($colors as $key => $c): ?>
                                         <li><a href="/product/all?color=<?= $key ?>"> <span class="pull-right">(<?= $c['num'] ?>)</span><?= $key ?></a></li>
                                     <? endforeach; ?>
                                 </ul>
                             </div>
                         </div><!--/brands_products-->
                     <? endif; ?>

<!--                    <div class="price-range">price-range
                        <h2>Сортировать по цене</h2>
                        <div class="well text-center">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                            <b class="pull-left">0 <i class="fa fa-rub"></i></b> <b class="pull-right">600 <i class="fa fa-rub"></i></b>
                        </div>
                    </div>/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="https://im2-tub-ru.yandex.net/i?id=1f9f20a65759b50dad6ab26782f48ea8&n=33&h=215&w=324" alt="" />
                    </div><!--/shipping-->

                </div>
            </div>