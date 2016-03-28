<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/<?=$user['photo']?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?=$user['full_name']?></p>
                <a href="/admin/profile/id/<?= $user['id']?>"><i class="fa fa-circle text-success"></i> Онлайн</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Поиск...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Главное меню</li>
            <li>
                <a href="/admin/siteConfig">
                <i class="fa fa-dashboard"></i> <span>Настройки сайта</span>
            </a>
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Товары</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/allProducts"><i class="fa fa-circle-o"></i> Все товары</a></li>
                    <li><a href="/admin/add"><i class="fa fa-circle-o"></i> Добавить товар</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Заказы</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/allProducts"><i class="fa fa-circle-o"></i> Все заказы</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Пользователи</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/allUsers"><i class="fa fa-circle-o"></i> Все пользователи</a></li>
                </ul>
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Блог</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/blog"><i class="fa fa-circle-o"></i> Все статьи</a></li>
                    <li><a href="/admin/addArticle"><i class="fa fa-circle-o"></i> Добавить статью</a></li>
                </ul>
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Слайдер</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/slider"><i class="fa fa-circle-o"></i> Все слайды</a></li>
                    <li><a href="/admin/addSlide"><i class="fa fa-circle-o"></i> Добавить слайд</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>