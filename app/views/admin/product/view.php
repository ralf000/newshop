<? $product = $this->getData()[1]['products'][0] ?>
<? $images  = $this->getData()[1]['images'] ?>
<link rel="stylesheet" type="text/css" media="all" href="/app/template/css/lightslider/lightslider.css" />
<script type="text/javascript" src="/app/template/js/lightslider/lightslider.js"></script>
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <ul id="imageGallery">
                        <? foreach ($images as $image): ?>
                             <? if (isset($image['image'])): ?>
                                 <li data-thumb="/<?= $image['image'] ?>" data-src="/<?= $image['image'] ?>">
                                     <a href="/<?= $image['image'] ?>"><img src="/<?= $image['image'] ?>" style="width: 60%"/></a>
                                 </li>
                             <? endif; ?>
                         <? endforeach; ?>
                    </ul>
                    <script type="text/javascript">
                        $(function () {
                            $('#imageGallery').lightSlider({
                                gallery: true,
                                item: 1,
                                thumbItem: 5,
                                slideMargin: 0,
                                enableDrag: false,
                                currentPagerPosition: 'left',
                                autoWidth: true,
                                onSliderLoad: function (el) {
                                    el.lightGallery({
                                        selector: '#imageGallery .lslide'
                                    });
                                }
                            });
                        });
                    </script>
                    <h3 class="profile-username text-center"><?= $product['title'] ?></h3>
                    <p class="text-muted text-center"><?= $product['category_name'] ?> / <?= $product['subcategory_name'] ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Цена (руб.)</b> <span class="pull-right"><b><?= $product['price'] ?></b></span>
                        </li>
                        <li class="list-group-item">
                            <b>Количество</b> <span class="pull-right"><?= $product['quantity'] ?></span>
                        </li>
                    </ul>

                    <a href="/admin/editProduct/product/<?= $product['product_id'] ?>" class="btn btn-primary btn-block"><b>Редактировать</b></a>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Дополнительно</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Опубликован</b> <span class="pull-right"><?= ($product['published'] == 1) ? 'Да' : 'Нет' ?></span>
                        </li>
                        <li class="list-group-item">
                            <b>Дата публикации</b> <span class="pull-right"><?= Helper::dateConverter($product['created_time']) ?></span>
                        </li>
                        <li class="list-group-item">
                            <b>Дата обновления</b> <span class="pull-right"><?= Helper::dateConverter($product['updated_time']) ?></span>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="box box-warning">
                <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                    <h3 class="box-title">Полное описание</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?= $product['description'] ?>
                    <hr>
                    <?= Helper::tableToBootstrap($product['spec']) ?>                    
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <!--<a href="javascript::;" class="btn btn-sm btn-primary btn-flat pull-right">Редактировать</a>-->
                    <!--<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
                </div><!-- /.box-footer -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->