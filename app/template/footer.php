<?
use app\helpers\Helper;
use app\helpers\Path;
$articles = $this->getData()[0]['footerData'] ?>
<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>N</span>ewShop</h2>
                        <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>-->
                    </div>
                </div>
                <div class="col-sm-7">
                    <? if(!empty($articles) && is_array($articles)):?>
                    <? foreach ($articles as $a):?>
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="/blog/view/id/<?= $a['id']?>">
                                <div class="iframe-img">
                                    <img src="/<?= $a['main_image']?>" alt="<?= $a['title']?>" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p style="min-height: 50px;"><a style="color: #333" href="/blog/view/id/<?= $a['id']?>"><?= $a['title']?></a></p>
                            <small><?= Helper::dateConverter($a['created_time'])?></small>
                        </div>
                    </div>
                    <? endforeach;?>
                    <? endif;?>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="<?= Path::PATH_TO_TEMPLATE ?>images/home/map.png" alt="" />
                        <p>Химки, ул. Пролетарская д. 23</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Меню</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/blog">Статьи</a></li>
                            <li><a href="/contacts">Контакты</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <? if(!empty($sideBarMenu) && is_array($sideBarMenu)):?>
                    <div class="single-widget">
                        <h2>Товары</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <? foreach ($sideBarMenu as $c):?>
                            <li><a href="/product/all?category_id=<?= $c['id']?>"><?= $c['category_name']?></a></li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                    <? endif; ?>
                </div>
                <div class="col-sm-2">
<!--                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privecy Policy</a></li>
                            <li><a href="#">Refund Policy</a></li>
                            <li><a href="#">Billing System</a></li>
                            <li><a href="#">Ticket System</a></li>
                        </ul>
                    </div>-->
                </div>
                <div class="col-sm-2">
<!--                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Company Information</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>
                            <li><a href="#">Affillate Program</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>-->
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>Подпишитесь на наши скидки и акции</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Ваш email адрес" />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <p>Получайте наши самые свежие <br />скидки и акции быстрее остальных</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">© <?= date('Y')?> NEWSHOP. Все права защищены.</p>
                <!--<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>-->
            </div>
        </div>
    </div>

</footer><!--/Footer-->


<script src="<?= Path::PATH_TO_TEMPLATE ?>js/bootstrap.min.js"></script>
<script src="<?= Path::PATH_TO_TEMPLATE ?>js/jquery.scrollUp.min.js"></script>
<script src="<?= Path::PATH_TO_TEMPLATE ?>js/price-range.js"></script>
<script src="<?= Path::PATH_TO_TEMPLATE ?>js/jquery.prettyPhoto.js"></script>
<script src="<?= Path::PATH_TO_TEMPLATE ?>js/main.js"></script>
</body>
</html>