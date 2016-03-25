<? use app\helpers\Path; ?>
<? $slider = $this->getData()[1]['slides']; ?>
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?= $slider ?>
            </div>
        </div>
    </div>
</section><!--/slider-->