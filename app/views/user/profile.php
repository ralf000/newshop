<?

 use app\helpers\Helper;
 use app\helpers\Path;

$profile = $this->getData()[1]['profile'];
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="title text-center">Личный кабинет</h2>
            <div class="row">
                <div class="col-md-4">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <a href="#changePhotoPopup" id="changePhoto" data-toggle="modal" data-target="#changePhotoPopUp"><img class="profile-user-img img-responsive img-circle center-block" src="/<?= $profile['profile']['photo'] ?>" alt="change photo"></a>
                            <h3 class="profile-username text-center"><?= $profile['profile'][0]['username'] ?></h3>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Информация</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i>  Адреса:</strong>
                            <? if (!empty($profile['contacts']['address'])): ?>
                                 <? foreach ($profile['contacts']['address'] as $adr): ?>
                                     <p class="text-muted">
                                         <?= $adr['address'] . '<br>' . $adr['postal_code'] ?>
                                     </p>
                                 <? endforeach; ?>
                             <? endif; ?>
                            <hr>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> Телефоны:</strong>
                            <? if (!empty($profile['contacts']['phones'])): ?>
                                 <? foreach ($profile['contacts']['phones'] as $phn): ?>
                                     <p class="text-muted">
                                         <?= $phn['number_type'] . ': ' . $phn['number'] ?>
                                     </p>
                                 <? endforeach; ?>
                             <? endif; ?>
                            <hr>

                            <strong><i class="fa fa-envelope margin-r-5"></i> Электронная почта:</strong>
                            <p class="text-muted">
                                <a href="mailto:<?= $profile['profile'][0]['email'] ?>"><?= $profile['profile'][0]['email'] ?></a>
                            </p>
                            <hr>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
                <div class="col-md-8">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <!--                                            <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                                                                        <li><a href="#timeline" data-toggle="tab">Timeline</a></li>-->
                            <li class="active"><a href="#settings" data-toggle="tab">Мои заказы</a></li>
                        </ul>
                        <div class="tab-content">

                            <div class="active tab-pane" id="timeline">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>Содержание</th>
                                                    <th>Тип доставки</th>
                                                    <th>Статус</th>
                                                    <th>Добавлен</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? if ($profile['orders'] && is_array($profile['orders'])): ?>
                                                     <? foreach ($profile['orders'] as $key => $order): ?>
                                                         <? if ($key !== 'rowCount'): ?>
                                                             <tr>
                                                                 <td>
                                                                     <table class="table table-bordered table-striped prodList">
                                                                         <tr>
                                                                             <th>Название</th>
                                                                             <th>Количество</th>
                                                                         </tr>
                                                                         <? if ($order['body'] && is_array($order['body'])): ?>
                                                                             <? foreach ($order['body'] as $key => $p): ?>
                                                                                 <tr>
                                                                                     <td><a href="/product/view/id/<?= $key ?>"><?= $p['title'] ?></a></td>
                                                                                     <td><?= $p['quantity'] ?></td>
                                                                                 </tr>
                                                                             <? endforeach; ?>
                                                                         <? endif; ?>
                                                                     </table>
                                                                 </td>
                                                                 <td><?= $order['delivery'] ?></td>
                                                                 <td><?= $order['type'] ?><br><span class="text-muted"><?= $order['status'] ?></span></td>
                                                                 <td><?= Helper::dateConverter($order['created_time']) ?></td>
                                                             </tr>
                                                         <? endif; ?>
                                                     <? endforeach; ?>
                                                 <? endif; ?>
                                            </tbody>
                                        </table>
                                    </div><!-- /.table-responsive -->
                                </div><!-- /.box-body -->
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>
</div>
</div>
</section>
<? require_once Path::PATH_TO_INC . 'imageUploadModal.inc.php'; ?>