<?

 use app\helpers\Helper;

$product             = $this->getData()[1]['product'];
 $images              = $this->getData()[1]['images'];
 $recommendedProducts = $this->getData()[1]['recommendedProducts'];
?>
<link rel="stylesheet" type="text/css" media="all" href="/app/template/css/jgallery/jgallery.min.css" />
<script type="text/javascript" src="/app/template/js/jgallery/jgallery.min.js?v=1.5.5"></script>
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <? if (!empty($images) && is_array($images)): ?>
             <div id="gallery">
                 <? foreach ($images as $i): ?>
                     <? if ($i['image']): ?>
                         <a href="/<?= $i['image'] ?>"><img src="/<?= $i['image'] ?>" alt="" /></a>
                     <? endif; ?>
                 <? endforeach; ?>
             </div>
         <? endif; ?>
        <script type="text/javascript">
            $(function () {
                $('#gallery').jGallery();
            });
        </script>

    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <h2><?= $product['title'] ?></h2>
            <p><a href="/product/all?catid=<?= $product['category_id'] ?>"><?= $product['category'] ?></a> 
                / 
                <a href="/product/all?subcatid=<?= $product['subcategory_id'] ?>"><?= $product['subCategory'] ?></a></p>
            <span>
                <span><?= $product['price'] ?> <i class="fa fa-rub"></i></span>
                <a href="<?= $product['id']?>" class="btn btn-default add-to-cart cart"><i class="fa fa-shopping-cart"></i>Добавить в корзину</a>
            </span>
            <p><b>В наличии:</b> <?= Helper::getInStockForClients($product['quantity']) ?></p>
            <p><b>Бренд:</b> <?= $product['brand'] ?></p>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#description" data-toggle="tab">Описание</a></li>
            <li><a href="#spec" data-toggle="tab">Характеристики</a></li>
            <li><a href="#comments" data-toggle="tab">Отзывы</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="description">
            <?= $product['description'] ?>
        </div>

        <div class="tab-pane fade" id="spec" >
            <?= $product['spec'] ?>
        </div>

        <div class="tab-pane fade" id="comments" >
        </div>

    </div>
</div><!--/category-tab-->

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Рекомендуем</h2>
    <?= $recommendedProducts ?>
</div><!--/recommended_items-->
