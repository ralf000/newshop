<?

use app\helpers\Basket;
use app\helpers\Generator;
use app\helpers\Helper;
use app\helpers\Path;
use app\helpers\User;
use app\services\Session;

$numFromBasket = (Basket::getNumProducts() > 0) ? Basket::getNumProducts() : false;
 $cfg           = Helper::getSiteConfig();
 $user          = (User::checkUser()) ? Session::get('username') : FALSE;
?>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <? if (isset($cfg->contactinfo) && !empty($cfg->contactinfo)): ?>
                                 <? foreach ($cfg->contactinfo as $v): ?>
                                     <li><a href="#"><i class="<?= $v->icon ?>"></i> <?= $v->value ?></a></li>
                                 <? endforeach; ?>
                             <? endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <? if (isset($cfg->social) && !empty($cfg->social)): ?>
                                 <? foreach ($cfg->social as $v): ?>
                                     <li><a href="<?= $v->link ?>"><i class="<?= $v->icon ?>"></i></a></li>
                                 <? endforeach; ?>
                             <? endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="pull-right">
                        <button class="showBasket btn btn-default"><i class="fa fa-shopping-cart"></i> Корзина <span>(<?= $numFromBasket ?>)</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="/"><img src="<?= Path::PATH_TO_TEMPLATE ?>images/home/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <?= Generator::topMenu($cfg->topmenu, $user) ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Меню</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="/" class="active">Главная</a></li>
<!--                            <li class="dropdown"><a href="#">Магазин<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="shop.html">Products</a></li>
                                    <li><a href="product-details.html">Product Details</a></li> 
                                    <li><a href="checkout.html">Checkout</a></li> 
                                    <li><a href="cart.html">Cart</a></li> 
                                    <li><a href="login.html">Login</a></li> 
                                </ul>
                            </li> -->
                            <li class="dropdown"><a href="/blog">Статьи</a>
                            </li> 
                            <!--<li><a href="404.html">404</a></li>-->
                            <li><a href="/contacts">Контакты</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <input type="text" placeholder="Поиск..."/>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->