<?

use app\helpers\Helper;
use app\helpers\Path;

$user                    = $this->getData()[1]['userProfile'][0];
 $userAddress             = $this->getData()[1]['userContacts']['address'];
 $userActivity            = $this->getData()[1]['userActivity'];
 $userActivityGroupByDate = $this->getData()[1]['userActivityGroupByDate'];
 array_pop($userActivity); //deleted value rowCount from array
 array_pop($userActivityGroupByDate);
 $userActivityGroupByDate = array_reverse($userActivityGroupByDate);
 $userActivityGroupByDate = array_slice($userActivityGroupByDate, 0, 7);
 $userPhones              = $this->getData()[1]['userContacts']['phones'];
 $user['photo']           = ($user['photo']) ? $user['photo'] : Path::DEFAULT_USER_AVATAR;
 $username                = ($user['full_name']) ? $user['full_name'] : $user['username'];
 $translate               = [
     'insert'      => 'добавил',
     'update'      => 'обновил',
     'delete'      => 'удалил',
     'product'     => [
         'name' => 'товар',
         'link' => '/admin/view/product/'
     ],
     'user'     => [
         'name' => 'пользователя',
         'link' => '/admin/profile/id/'
     ],
     'comment'     => [
         'name' => 'комментарий',
         'link' => '/admin/comment/id/'
     ],
     'category'    => 'категорию',
     'subcategory' => 'подкатегорию',
 ];
?>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <a href="#changePhotoPopup" id="changePhoto" data-toggle="modal" data-target="#changePhotoPopUp"><img class="profile-user-img img-responsive img-circle" src="/<?= $user['photo'] ?>" alt="change photo"></a>
                    <h3 class="profile-username text-center"><?= $username ?></h3>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Информация</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i>  Адреса:</strong>
                    <? if ($userAddress): ?>
                         <? foreach ($userAddress as $adr): ?>
                             <p class="text-muted">
                                 <?= $adr['address'] . '<br>' . $adr['postal_code'] ?>
                             </p>
                         <? endforeach; ?>
                     <? endif; ?>
                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Телефоны:</strong>
                    <? if ($userPhones): ?>
                         <? foreach ($userPhones as $phn): ?>
                             <p class="text-muted">
                                 <?= $phn['number_type'] . ': ' . $phn['number'] ?>
                             </p>
                         <? endforeach; ?>
                     <? endif; ?>
                    <hr>

                    <strong><i class="fa fa-envelope margin-r-5"></i> Электронная почта:</strong>
                    <p class="text-muted">
                        <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
                    </p>
                    <hr>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <!--                        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                                            <li><a href="#timeline" data-toggle="tab">Timeline</a></li>-->
                    <li class="active"><a href="#settings" data-toggle="tab">Активность <?= $username ?></a></li>
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="timeline">
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            <!-- timeline time label -->
                            <? foreach ($userActivityGroupByDate as $d): ?>
                                 <li class="time-label">
                                     <span class="bg-red">
                                         <? $dat = $d['dat'] ?>
                                         <? list($y, $m, $d) = explode('-', $dat) ?>
                                         <?= "$d-$m-$y" ?>
                                     </span>
                                 </li>
                                 <!-- /.timeline-label -->

                                 <? foreach ($userActivity as $activ): ?>
                                     <? if ($activ['dat'] === $dat): ?>
                                         <? list($activDate, $ativTime) = explode(' ', $activ['time']) ?>
                                         <!-- timeline item -->
                                         <li>
                                             <i class="<?= Helper::getIconForUserProfileBYAdmin($activ['operation']) ?>"></i>
                                             <div class="timeline-item">
                                                 <span class="time"><i class="fa fa-clock-o"></i> <?= $ativTime ?></span>
                                                 <? $link   = "" ?>
                                                 <? $string = "{$translate[$activ['operation']]} {$translate[$activ['table_name']]['name']} <a href='{$translate[$activ['table_name']]['link']}{$activ['object_id']}'>«{$activ['object_title']}»</a>" ?>
                                                 <h3 class="timeline-header"><a href="#"><?= $username ?></a> <?= $string ?></h3>
                                             </div>
                                         </li>
                                     <? endif; ?>
                                 <? endforeach; ?>
                             <? endforeach; ?>
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->
<? require_once Path::PATH_TO_INC . 'imageUploadModal.inc.php'; ?>