<?

 use app\helpers\Generator;
 use app\helpers\Helper;
 use app\helpers\Path;

$currentCategory     = $this->getData()[1]['currentCategory'];
 $popularProducts = $this->getData()[1]['popularProducts'];
 $recommendedProducts = $this->getData()[1]['recommendedProducts'];
?>
<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Популярные товары</h2>
        <?= $popularProducts?>

    </div><!--features_items-->

    <div class="category-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <? if (!empty($currentCategory) && is_array($currentCategory)): ?>
                     <li class="subCatTitle pull-right"><i class="fa fa-arrow-left"></i> <?= $currentCategory[0]['category_name'] ?></li>
                     <? foreach ($currentCategory as $k => $c): ?>
                         <? $active   = ($k === 0) ? 'active' : '' ?>
                         <? $subToLat = Generator::strToLat($c['subcategory_name']) ?>
                         <? $sub      = Helper::strSplitter($c['subcategory_name']) ?>
                         <li class="<?= $active ?>"><a href="#<?= $subToLat ?>" class="showSubsProducts" data-toggle="tab" data-id="<?= $c['id'] ?>"><?= $sub ?></a></li>
                     <? endforeach; ?>
 <? endif; ?>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" >
                <div id="productsBySubcategory"></div>
            </div>
        </div>
    </div><!--/category-tab-->

    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Рекомендуем</h2>
        
        <? echo $recommendedProducts ?>

    </div><!--/recommended_items-->
    
</div>
</div>
</div>
</section>
<script type="text/javascript" src="/app/template/js/index/index.js"></script>