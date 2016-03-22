<?
 $cfg  = $this->getData()[1]['siteConfig'];
 $cats = $this->getData()[1]['siteCategories'];
?>
<section class="content">
    <div class="box box-primary">
        <form id="siteconfig" action="siteconfig" method="post" role="form">
            <div class="box-body">
                <h3>Основные настройки</h3>
                <div class="form-group">
                    <label for="siteName">Имя сайта</label>
                    <input type="text" name="siteName" class="form-control" value="<?= $cfg->general->siteName ?>"/>
                </div>
                <h3>Контактная информация</h3>
                <div class="form-group">
                    <label for="sitePhoneIcon">Иконка для телефона</label>
                    <input type="text" name="sitePhoneIcon" class="form-control" value="<?= $cfg->contactinfo->sitePhone->icon ?>"/>
                </div>
                <div class="form-group">
                    <label for="sitePhone">Телефон</label>
                    <input type="text" name="sitePhone" class="form-control" value="<?= $cfg->contactinfo->sitePhone->value ?>"/>
                </div>
                <div class="form-group">
                    <label for="siteEmailIcon">Иконка для Email</label>
                    <input type="text" name="siteEmailIcon" class="form-control" value="<?= $cfg->contactinfo->siteMail->icon ?>"/>
                </div>
                <div class="form-group">
                    <label for="siteEmail">Email</label>
                    <input type="text" name="siteEmail" class="form-control" value="<?= $cfg->contactinfo->siteMail->value ?>"/>
                </div>
                <? if (is_array($cfg->social) && !empty($cfg->social)): ?>
                     <h3>Социальные сети</h3>
                     <? foreach ($cfg->social as $s): ?>
                     <h4 class="bg-info"><?= ucfirst($s->value) ?></h4>
                         <div class="form-group">
                             <label for="social">Название</label>
                             <input type="text" name="social[<?= $s->value ?>][value]" class="form-control" value="<?= $s->value ?>"/>
                         </div>
                         <div class="form-group">
                             <label for="social>">Иконка</label>
                             <input type="text" name="social[<?= $s->value ?>][icon]" class="form-control" value="<?= $s->icon ?>"/>
                         </div>
                         <div class="form-group">
                             <label for="social">Ссылка</label>
                             <input type="text" name="social[<?= $s->value ?>][link]" class="form-control" value="<?= $s->link ?>"/>
                         </div>
                     <? endforeach; ?>
                 <? endif; ?>
                <? if (is_array($cfg->topmenu) && !empty($cfg->topmenu)): ?>
                     <h3>Верхнее меню</h3>
                     <? foreach ($cfg->topmenu as $key => $top): ?>
                         <h4 class="bg-warning"><?= ucfirst($top->value) ?></h4>
                         <div class="form-group">
                             <label for="topmenu">Название</label>
                             <input type="text" name="topmenu[<?= $top->value ?>][value]" class="form-control" value="<?= $top->value ?>"/>
                         </div>
                         <div class="form-group">
                             <label for="topmenu">Иконка</label>
                             <input type="text" name="topmenu[<?= $top->value ?>][icon]" class="form-control" value="<?= $top->icon ?>"/>
                         </div>
                         <div class="form-group">
                             <label for="topmenu">Ссылка</label>
                             <input type="text" name="topmenu[<?= $top->value ?>][link]" class="form-control" value="<?= $top->link ?>"/>
                         </div>
                     <? endforeach; ?>
                 <? endif; ?>
                <h3>Категория товаров для виджета "Текущая категория"</h3>
                <? if (is_array($cfg->topmenu) && !empty($cfg->topmenu)): ?>
                     <select class="form-control" id="siteconfigCurrentCategoryWidget" name="currentCategoryWidget">
                         <? foreach ($cats as $cat): ?>
                             <? if ($cat['published'] > 0): ?>
                                 <? $selected = ($cat['id'] == $cfg->currentCategoryWidget) ? 'selected' : '' ?>
                                 <option <?= $selected ?> value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                             <? endif; ?>
                         <? endforeach; ?>
                     </select>
                 <? endif; ?>
            </div>
            <div class="box-footer">
                <input type="submit" value="Отравить" class="btn btn-primary"/>
            </div>
        </form>
    </div>
</section>

