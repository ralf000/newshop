<? $user = $this->getData()['user']; ?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="/admin" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>New</b>Shop</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../<?= $user['photo'] ?>" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= $user['full_name'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= $user['photo'] ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?= $user['full_name'] ?>
        <!--                                <small>Member since Nov. 2012</small>-->
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--                        <li class="user-body">
                                                            <div class="col-xs-4 text-center">
                                                                <a href="#">Followers</a>
                                                            </div>
                                                            <div class="col-xs-4 text-center">
                                                                <a href="#">Sales</a>
                                                            </div>
                                                            <div class="col-xs-4 text-center">
                                                                <a href="#">Friends</a>
                                                            </div>
                                                        </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="/admin/profile" class="btn btn-default btn-flat">Профиль</a>
                                    </div>
                                    <div class="pull-right">
                                        <form action="logout" method="post">
                                            <button type="submit" class="btn btn-default btn-flat">Выйти</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--                 Control Sidebar Toggle Button 
                                        <li>
                                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                        </li>-->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">