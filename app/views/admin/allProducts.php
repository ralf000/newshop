<? $products = $this->getData()[1]['products']?>
<? $limit = $this->getData()[1]['limit']?>
<? $page = $this->getData()[1]['page']?>
<? $numProducts = $this->getData()[1]['num']?>
<? $offset = $this->getData()[1]['offset']?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="products" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr role="row">
                                            <th>ID</th>
                                            <th>Изображение</th>
                                            <th>Заголовок</th>
                                            <th>Количество</th>
                                            <th>Цена</th>
                                            <th>Опубликован</th>
                                            <th>Категория</th>
                                            <th>Подкатегория</th>
                                            <th>Создан</th>
                                            <th>Обновлён</th>
                                            <th>Управление</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($products as $product):?>
                                        <tr role="row">
                                            <td><?=$product['id']?></td>
                                            <td><img src="/<?=$product['image']?>" alt="<?=$product['title']?>" class="product"/></td>
                                            <td><?=$product['title']?></td>
                                            <td><?=$product['quantity']?></td>
                                            <td><?=$product['price']?></td>
                                            <td><?=$product['published'] ? 'Да' : 'Нет'?></td>
                                            <td><?=$product['category_name']?></td>
                                            <td><?=$product['subcategory_name']?></td>
                                            <td><?=  date('d-m-Y H:i:s', strtotime($product['created_time']))?></td>
                                            <td><?=  date('d-m-Y H:i:s', strtotime($product['updated_time']))?></td>
                                            <td>
                                                <a href="#" class="admin-data-control"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                <a href="#" class="admin-data-control"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="#" class="admin-data-control"><span class="glyphicon glyphicon-minus"></span></a>
                                            </td>
                                        </tr>
                                        <? endforeach;?>
                                       </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                    Showing 1 to 10 of 57 entries
                                    На странице: <?=$offset + 1?> - <?=($offset + $limit > $numProducts) ? ($offset + $limit) - 1 : $offset + $limit?> из <?=$numProducts?> товаров
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <?= Helper::pagination($limit, $page) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div><!-- /.col -->
    </div><!-- /.row -->
</section>