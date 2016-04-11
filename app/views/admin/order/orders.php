<?

 use app\helpers\Generator;
 use app\helpers\Helper;
?>
<? $orders    = $this->getData()[1]['orders'] ?>
<? $limit     = $this->getData()[1]['limit'] ?>
<? $page      = $this->getData()[1]['page'] ?>
<? $numOrders = $this->getData()[1]['num'] ?>
<? $offset    = $this->getData()[1]['offset'] ?>
<?
 $opt       = [
     'limit'     => $limit,
//     'offset'    => $offset,
     'orderBy'   => $this->getData()[1]['orderBy'],
     'direction' => $this->getData()[1]['direction'],
     'table'     => 'product',
     'num'       => $numOrders
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
                                        <tr>
                                            <th>ID заказа</th>
                                            <th>ID корзины</th>
                                            <th>Содержание</th>
                                            <th>Комментарий</th>
                                            <th>Тип доставки</th>
                                            <th>Заказчик</th>
                                            <th>Желаемая дата доставки</th>
                                            <th>Желаемое время доставки</th>
                                            <th>Статус</th>
                                            <th>Добавлен</th>
                                            <th>Управление</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($products as $product): ?>
                                             <tr role="row">
                                                 <td><?= $orders['id'] ?></td>
                                                 <td><?= Basket::getBasketId($order['body']) ?></td>
                                                 <td>
                                                     <table class="table table-bordered table-striped">
                                                         <tr>
                                                             <th>Название</th>
                                                             <th>Количество</th>
                                                         </tr>
                                                         <? $prodList = Basket::getProductsList($order['body']) ?>
                                                         <? if ($prodList && is_array($prodList)): ?>
                                                             <? foreach ($prodList as $key => $p): ?>
                                                                 <tr>
                                                                     <td><a href="/admin/view/product/<?= $key ?>"><?= $p['title'] ?></a></td>
                                                                     <td><?= $p['quantity'] ?></td>
                                                                 </tr>
                                                             <? endforeach; ?>
                                                         <? endif; ?>
                                                     </table>
                                                 </td>
                                                 <td><?= $order['note']?></td>
                                                 <td><?= $order['delivery'] ?></td>
                                                 <td><?= $order['user_name'] ?></td>
                                                 <td><?= $order['delivery_date'] ?></td>
                                                 <td><?= $order['delivery_time'] ?></td>
                                                 <td><?= Helper::dateConverter($product['created_time']) ?></td>
                                                 <td><?= Helper::dateConverter($product['updated_time']) ?></td>
                                                 <td>
                                                     <a href="/admin/view/product/<?= $product['id'] ?>" class="admin-data-control"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                     <a href="/admin/editProduct/product/<?= $product['id'] ?>" class="admin-data-control"><span class="glyphicon glyphicon-pencil"></span></a>
                                                     <a href="<?= $product['id'] ?>" class="deleteProduct admin-data-control"><span class="glyphicon glyphicon-minus"></span></a>
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
                                         <?= Generator::pagination($limit, $page, $opt) ?>
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