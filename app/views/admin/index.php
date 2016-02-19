<? $cntWidgets     = $this->getWidgetsData()['cntWidgets']; ?>
<? $clientsWidget  = $this->getWidgetsData()['clientsWidget']; ?>
<? $managersWidget = $this->getWidgetsData()['managersWidget']; ?>
<? $productsWidget = $this->getWidgetsData()['productsWidget']; ?>
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
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Popularity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="label label-success">Shipped</span></td>
                                    <td><div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td><div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="label label-danger">Delivered</span></td>
                                    <td><div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-info">Processing</span></td>
                                    <td><div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td><div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="label label-danger">Delivered</span></td>
                                    <td><div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="label label-success">Shipped</span></td>
                                    <td><div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Все заказы</a>
                    <!--<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
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
                    <a href="javascript::;" class="btn btn-sm btn-warning btn-flat pull-left">Все клиенты</a>
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
                        <? foreach ($productsWidget as $product):?>
                        <li class="item">
                            <div class="product-img">
                                <img src="/<?=$product['image']?>" alt="Product Image">
                            </div>
                            <div class="product-info">
                                <a href="javascript::;" class="product-title"><?=$product['title']?> <span class="label label-success pull-right"><?=$product['price']?> руб.</span> </a>
                                <span class="product-description">
                                    На складе: <?=  $product['quantity']?>
                                </span>
                            </div>
                        </li><!-- /.item -->
                        <? endforeach;?>
                    </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="javascript::;" class="uppercase">Все товары</a>
                </div><!-- /.box-footer -->
            </div>

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Недавние посетители</h3>
                    <div class="box-tools pull-right">
                        <!--<span class="label label-danger">8 New Members</span>-->
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <? foreach ($managersWidget as $manager): ?>
                             <li>
                                 <img src="/<?=$manager['photo']?>" alt="User Image">
                                 <?=$manager['full_name']?>
                                 <span class="users-list-date"><?=$manager['create_time']?></span>
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
                    <a href="javascript::" class="uppercase">Все посетители</a>
                </div><!-- /.box-footer -->
            </div>
        </section><!-- right col -->
    </div><!-- /.row (main row) -->

</section><!-- /.content -->