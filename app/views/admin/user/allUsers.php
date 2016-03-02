<? use app\helpers\Helper; ?>
<? use app\helpers\Path; ?>

<? $users    = $this->getData()[1]['users'] ?>
<? $limit    = $this->getData()[1]['limit'] ?>
<? $page     = $this->getData()[1]['page'] ?>
<? $numUsers = $this->getData()[1]['num'] ?>
<? $offset   = $this->getData()[1]['offset'] ?>
<?
 $opt      = [
     'limit'     => $limit,
//     'offset'    => $offset,
     'orderBy'   => $this->getData()[1]['orderBy'],
     'direction' => $this->getData()[1]['direction'],
         ]
?>
<? Helper::g($users) ?>
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
                                            <th>Аватар</th>
                                            <th><a href="" data-name="username" class="sorting">Ник</a></th>
                                            <th><a href="" data-name="fio" class="sorting">ФИО</a></th>
                                            <th><a href="" data-name="email" class="sorting">email</a></th>
                                            <th><a href="" data-name="validated" class="sorting">Активирован</a></th>
                                            <th><a href="" data-name="create_time" class="sorting">Создан</a></th>
                                            <th><a href="" data-name="update_time" class="sorting">Обновлён</a></th>
                                            <th>Управление</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($users as $user): ?>
                                             <tr role="row">
                                                 <td><?= $user['id'] ?></td>
                                                 <? $user['photo'] = ($user['photo']) ? $user['photo'] : Path::DEFAULT_USER_AVATAR ?>
                                                 <td><img src="/<?= $user['photo'] ?>" alt="<?= $user['username'] ?>" class="product"/></td>
                                                 <td><?= $user['username'] ?></td>
                                                 <td><?= $user['full_name'] ?></td>
                                                 <td><?= $user['email'] ?></td>
                                                 <td><?= $user['validated'] ?></td>
                                                 <td><?= Helper::dateConverter($user['create_time']) ?></td>
                                                 <td><?= Helper::dateConverter($user['update_time']) ?></td>
                                                 <td>
                                                     <a href="/admin/view/product/<?= $user['id'] ?>" class="admin-data-control"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                     <a href="/admin/editProduct/product/<?= $user['id'] ?>" class="admin-data-control"><span class="glyphicon glyphicon-pencil"></span></a>
                                                     <a href="<?= $user['id'] ?>" class="deleteProduct admin-data-control"><span class="glyphicon glyphicon-minus"></span></a>
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