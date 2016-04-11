<?

 use app\helpers\Basket;
 use app\helpers\Helper;
 use app\helpers\Path;
?>
<? $cntWidgets     = $this->getWidgetsData()['cntWidgets']; ?>
<? $clientsWidget  = $this->getWidgetsData()['clientsWidget']; ?>
<? $managersWidget = $this->getWidgetsData()['managersWidget']; ?>
<? $productsWidget = $this->getWidgetsData()['productsWidget']; ?>
<? $usersActivity  = $this->getWidgetsData()['usersActivityLine'] ?>
<? $articles       = $this->getWidgetsData()['articles'] ?>
<? $orders         = $this->getWidgetsData()['orders']; ?>
<? Helper::g($orders)?>
<?
 $translate      = [
     'insert'      => 'добавил',
     'update'      => 'обновил',
     'delete'      => 'удалил',
     'product'     => [
         'name' => 'товар',
         'link' => '/admin/view/product/'
     ],
     'user'        => [
         'name' => 'пользователя',
         'link' => '/admin/profile/id/'
     ],
     'comment'     => [
         'name' => 'комментарий',
         'link' => '/admin/comment/id/'
     ],
     'category'    => [
         'name' => 'категорию',
         'link' => ''
     ],
     'subcategory' => [
         'name' => 'подкатегорию',
         'link' => ''
     ]
 ];
?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Товары</span>
                    <span class="info-box-number"><?= $cntWidgets['products'] ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $cntWidgets['persentsProds'] ?>%"></div>
                    </div>
                    <span class="progress-description">
                        Новых товаров в текущем месяце: <?= $cntWidgets['productsPerMonts'] ?>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Заказы</span>
                    <span class="info-box-number"><?= $cntWidgets['orders'] ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $cntWidgets['persentsOrders'] ?>%"></div>
                    </div>
                    <span class="progress-description">
                        Новых заказов в текущем месяце: <?= $cntWidgets['ordersPerMonth'] ?>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Клиенты</span>
                    <span class="info-box-number"><?= $cntWidgets['clients'] ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $cntWidgets['persentsClients'] ?>%"></div>
                    </div>
                    <span class="progress-description">
                        Новых клиентов в текущем месяце: <?= $cntWidgets['clientsPerMonth'] ?>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Комментарии</span>
                    <span class="info-box-number"><?= $cntWidgets['comments'] ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $cntWidgets['persentsComm'] ?>%"></div>
                    </div>
                    <span class="progress-description">
                        Новых комментариев в текущем месяце: <?= $cntWidgets['commentsPerMonth'] ?>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
    </div>
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Активность</h3>
                    <div class="box-tools pull-right">
                        <!--<span class="label label-danger">8 New Members</span>-->
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <? if (is_array($usersActivity) && !empty($usersActivity)): ?>
                             <? foreach ($usersActivity as $ua): ?>
                                 <li class="time-label">
                                     <span class="bg-red">
                                         <?= explode(' ', Helper::dateConverter($ua['time']))[0] ?>
                                     </span>
                                 </li>
                                 <!-- /.timeline-label -->
                                 <? if (is_array($ua['records']) && !empty($ua['records'])): ?>
                                     <? foreach ($ua['records'] as $r): ?>
                                         <? list($activDate, $ativTime) = explode(' ', $r['time']) ?>
                                         <!-- timeline item -->
                                         <li>
                                             <i class="<?= Helper::getIconForUserProfileBYAdmin($r['operation']) ?>"></i>
                                             <div class="timeline-item">
                                                 <span class="time"><i class="fa fa-clock-o"></i> <?= $ativTime ?></span>
                                                 <? $link   = "" ?>
                                                 <? $string = "{$translate[$r['operation']]} {$translate[$r['table_name']]['name']} <a href='{$translate[$r['table_name']]['link']}{$r['object_id']}'>«{$r['object_title']}»</a>" ?>
                                                 <h3 class="timeline-header"><a href="/admin/profile/id/<?= $r['manager'] ?>"><?= $r['manager_name'] ?></a> <?= $string ?></h3>
                                             </div>
                                         </li>
                                     <? endforeach; ?>
                                 <? endif; ?>
                             <? endforeach; ?>
                         <? endif; ?>
                        <!-- END timeline item -->
                        <!--                            <li>
                                                        <i class="fa fa-clock-o bg-gray"></i>
                                                    </li>-->
                    </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="/admin/activity" class="uppercase">Вся активность</a>
                </div><!-- /.box-footer -->
            </div>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Новые заказы</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>ID заказа</th>
                                    <th>ID корзины</th>
                                    <th>Содержание</th>
                                    <th>Тип доставки</th>
                                    <th>Заказчик</th>
                                    <th>Желаемая дата доставки</th>
                                    <th>Статус</th>
                                    <th>Добавлен</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? if ($orders && is_array($orders)): ?>
                                     <? foreach ($orders as $order): ?>
                                         <tr>
                                             <td><?= $order['id'] ?></td>
                                             <td><?= Basket::getBasketId($order['body']) ?></td>
                                             <td>
                                                 <table class="table table-bordered table-striped">
                                                     <tr>
                                                         <th>Название</th>
                                                         <th>Количество</th>
                                                     </tr>
                                                 <? $prodList = Basket::getProductsList($order['body']) ?>
                                                 <? if ($prodList && is_array($prodList)): ?>
                                                 <? foreach ($prodList as $key => $p):?>
                                                 <tr>
                                                     <td><a href="/admin/view/product/<?=$key?>"><?= $p['title']?></a></td>
                                                     <td><?= $p['quantity']?></td>
                                                 </tr>
                                                 <? endforeach;?>
                                                 <? endif; ?>
                                                 </table>
                                             </td>
                                             <td><?= $order['delivery'] ?></td>
                                             <td><?= $order['user_name'] ?></td>
                                             <? $delDate = (!empty($order['delivery_date']) ? $order['delivery_date'] : 'Дата не указана')?>
                                             <td><?=$delDate ?><br><?= $order['delivery_time'] ?></td>
                                             <td><?= $order['status']['type']?><br><span class="text-muted"><?= $order['status']['status']?></span></td>
                                             <td><?= Helper::dateConverter($order['created_time']) ?></td>
                                         </tr>
                                     <? endforeach; ?>
                                 <? endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Все заказы</a>
                    <!--<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
                </div><!-- /.box-footer -->
            </div>

        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Новые товары</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <? foreach ($productsWidget as $product): ?>
                             <li class="item">
                                 <div class="product-img">
                                     <img src="/<?= $product['image'] ?>" alt="Product Image">
                                 </div>
                                 <div class="product-info">
                                     <a href="/admin/view/product/<?= $product['product_id'] ?>" class="product-title"><?= $product['title'] ?> <span class="label label-success pull-right"><?= $product['price'] ?> руб.</span> </a>
                                     <span class="product-description">
                                         На складе: <?= $product['quantity'] ?>
                                     </span>
                                 </div>
                             </li><!-- /.item -->
                         <? endforeach; ?>
                    </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="/admin/allProducts" class="uppercase">Все товары</a>
                </div><!-- /.box-footer -->
            </div>


            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Новые статьи</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <? foreach ($articles as $a): ?>
                             <li class="item">
                                 <div class="product-img">
                                     <img src="/<?= $a['main_image'] ?>" alt="Article Image">
                                 </div>
                                 <div class="product-info">
                                     <a href="/admin/viewArticle/id/<?= $a['id'] ?>" class="product-title"><?= $a['title'] ?> <a href="/admin/profile/id/<?= $a['author'] ?>"><span class="label label-primary pull-right"> Автор: <?= $a['author_name'] ?></span></a>
                                         <span class="product-description">
                                             Создана: <?= Helper::dateConverter($a['created_time']) ?><br>
                                             Обновлена: <?= Helper::dateConverter($a['updated_time']) ?>
                                         </span>
                                 </div>
                             </li><!-- /.item -->
                         <? endforeach; ?>
                    </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="/admin/blog" class="uppercase">Все статьи</a>
                </div><!-- /.box-footer -->
            </div>

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Менеджеры</h3>
                    <div class="box-tools pull-right">
                        <!--<span class="label label-danger">8 New Members</span>-->
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <? foreach ($managersWidget as $manager): ?>
                             <?
                             $manager['photo'] = ($manager['photo']) ? $manager['photo'] : Path::DEFAULT_USER_AVATAR
                             ?>
                             <li>
                                 <img src="/<?= $manager['photo'] ?>" alt="User Image">
                                 <?= $manager['full_name'] ?>
                                 <span class="users-list-date"><?= $manager['create_time'] ?></span>
                             </li>
                         <? endforeach; ?>
                        <!--                        <li>
                                                    <img src="dist/img/user1-128x128.jpg" alt="User Image">
                                                    <a class="users-list-name" href="#">Alexander Pierce</a>
                                                    <span class="users-list-date">Today</span>
                                                </li>-->
                    </ul><!-- /.users-list -->
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="/admin/allUsers" class="uppercase">Все менеджеры</a>
                </div><!-- /.box-footer -->
            </div>
            
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Новые клиенты</h3>
                    <div class="box-tools">
                        <div class="input-group" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                                <th>ID</th>
                                <th>Логин</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Дата</th>
                            </tr>
                            <? foreach ($clientsWidget as $client): ?>
                                 <tr>
                                     <td><?= $client['id'] ?></td>
                                     <td><?= $client['username'] ?></td>
                                     <td><?= $client['full_name'] ?></td>
                                     <td><?= $client['email'] ?></td>
                                     <td><?= date('d-m-Y H:i:s', strtotime($client['create_time'])) ?></td>
                                 </tr>
                             <? endforeach; ?>
                        </tbody></table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="/admin/allUsers" class="btn btn-sm btn-warning btn-flat pull-left">Все клиенты</a>
                    <!--<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
                </div><!-- /.box-footer -->
            </div>
        </section><!-- right col -->
    </div><!-- /.row (main row) -->

</section><!-- /.content -->