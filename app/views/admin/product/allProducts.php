<? $products    = $this->getData()[1]['products'] ?>
<? $limit       = $this->getData()[1]['limit'] ?>
<? $page        = $this->getData()[1]['page'] ?>
<? $numProducts = $this->getData()[1]['num'] ?>
<? $offset      = $this->getData()[1]['offset'] ?>
<?
 $opt         = [
     'limit'     => $limit,
//     'offset'    => $offset,
     'orderBy'   => $this->getData()[1]['orderBy'],
     'direction' => $this->getData()[1]['direction'],
         ]
?>
<script type="text/javascript" src="/app/template/backend/js/products/allproducts.js"></script>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="products" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="dataTables_length" id="showNumProducts">
                                                <label>Отображать по 
                                                    <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select> 
                                                    товаров
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="example1_filter" class="dataTables_filter pull-right">
                                                <label>
                                                    Поиск
                                                    <input type="search" class="form-control input-sm" placeholder="" aria-controls="example1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr role="row">
                                            <th><a href="" data-name="id" class="sorting">ID</a></th>
                                            <th>Изображение</th>
                                            <th><a href="" data-name="title" class="sorting">Заголовок</a></th>
                                            <th><a href="" data-name="quantity" class="sorting">Количество</a></th>
                                            <th><a href="" data-name="price" class="sorting">Цена</a></th>
                                            <th><a href="" data-name="published" class="sorting">Опубликован</a></th>
                                            <th><a href="" data-name="category_id" class="sorting">Категория</a></th>
                                            <th><a href="" data-name="subcategory_id" class="sorting">Подкатегория</a></th>
                                            <th><a href="" data-name="created_time" class="sorting">Создан</a></th>
                                            <th><a href="" data-name="updated_time" class="sorting">Обновлён</a></th>
                                            <th>Управление</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($products as $product): ?>
                                             <tr role="row">
                                                 <td><?= $product['id'] ?></td>
                                                 <td><img src="/<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="product"/></td>
                                                 <td><?= $product['title'] ?></td>
                                                 <td><?= $product['quantity'] ?></td>
                                                 <td><?= $product['price'] ?></td>
                                                 <td><?= $product['published'] ? 'Да' : 'Нет' ?></td>
                                                 <td><?= $product['category_name'] ?></td>
                                                 <td><?= $product['subcategory_name'] ?></td>
                                                 <td><?= Helper::dateConverter($product['created_time']) ?></td>
                                                 <td><?= Helper::dateConverter($product['updated_time']) ?></td>
                                                 <td>
                                                     <a href="/admin/view/product/<?= $product['id'] ?>" class="admin-data-control"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                     <a href="/admin/editProduct/product/<?=$product['id']?>" class="admin-data-control"><span class="glyphicon glyphicon-pencil"></span></a>
                                                     <a href="<?=$product['id']?>" class="deleteProduct admin-data-control"><span class="glyphicon glyphicon-minus"></span></a>
                                                 </td>
                                             </tr>
                                         <? endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                    <? $start = $offset + 1 ?>
                                    <? $end   = ($limit * $page < $numProducts) ? $limit * $page : $numProducts ?>
                                    На странице: <b><?= $start ?> - <?= $end ?></b> из <b><?= $numProducts ?></b> товаров
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <? if ($limit < $numProducts): ?>
                                         <?= Helper::pagination($limit, $page, $opt) ?>
                                     <? endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div><!-- /.col -->
    </div><!-- /.row -->
</section>