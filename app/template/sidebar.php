<? use app\helpers\Path; ?>
<? $sideBarMenu = $this->getData()[0]['catsAndSubCats']; ?>
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
                                                             <li><a href="<?= $s['id']?>"><?= $s['subcategory_name']?> </a></li>
                                                         <? endforeach; ?>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>
                                 <? else: ?>
                                     <div class="panel panel-default">
                                         <div class="panel-heading">
                                             <h4 class="panel-title"><a href="<?= $c['id']?>"><?= $c['category_name']?></a></h4>
                                         </div>
                                     </div>
                                 <? endif; ?>
                             <? endforeach; ?>
                         <? endif; ?>
                        
                    </div><!--/category-products-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Бренды</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
                                <li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                <li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
                                <li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
                                <li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                <li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                <li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                            </ul>
                        </div>
                    </div><!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Сортировать по цене</h2>
                        <div class="well text-center">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                            <b class="pull-left">0 <i class="fa fa-rub"></i></b> <b class="pull-right">600 <i class="fa fa-rub"></i></b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="<?= Path::PATH_TO_TEMPLATE ?>images/home/shipping.jpg" alt="" />
                    </div><!--/shipping-->

                </div>
            </div>