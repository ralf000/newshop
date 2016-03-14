<?

 use app\helpers\Helper;
 use app\helpers\Path;

$userProfile          = $this->getData()[1]['profile'][0];
 $userContacts         = $this->getData()[1]['contacts'];
 $userRole             = $this->getData()[1]['role'];
 $userPerms            = $this->getData()[1]['perms'];
 $allRoles             = $this->getData()[1]['allRoles'];
 $userProfile['photo'] = ($userProfile['photo']) ? $userProfile['photo'] : Path::DEFAULT_USER_AVATAR;
?>
<!-- Main content -->
<section class="content">

    <div class="row">
        <form action="/admin/editUser" method="post" role="form">
            <input type="hidden" name="id" value="<?= $userProfile['id'] ?>"/>
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="/<?= $userProfile['photo'] ?>" alt="change photo">
                        <h3 class="profile-username text-center"><?= $userProfile['username'] ?></h3>
                        <div class="form-group">
                            <label for="fullName">ФИО</label>
                            <input type="text" class="form-control" name="fullName" id="fullName" value="<?= $userProfile['full_name'] ?>"/>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i>  Адреса:</strong>
                        <a href="#addAddressPopup" id="addAddress" data-toggle="modal" data-target="#addAddressPopup"><i class="fa fa-plus-circle margin-r-5 pull-right"></i></a>
                        <? if ($userContacts): ?>
                             <? foreach ($userContacts['address'] as $key => $adr): ?>
                                 <div class="form-group">
                                     <label for="address">Адрес <?= ++$key ?></label>
                                     <input type="text" class="form-control" name="address[<?= $adr['id'] ?>]" id="address" value="<?= $adr['address'] ?>"/>
                                 </div>
                                 <div class="form-group">
                                     <label for="postal">Индекс <?= $key ?></label>
                                     <input type="text" class="form-control" name="postal[<?= $adr['id'] ?>]" id="postal" value="<?= $adr['postal_code'] ?>"/>
                                 </div>
                             <? endforeach; ?>
                         <? endif; ?>
                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Телефоны:</strong>
                        <a href="#addAddressPopup" id="addPhone" data-toggle="modal" data-target="#addPhonePopup"><i class="fa fa-plus-circle margin-r-5 pull-right"></i></a>
                        <? if ($userContacts): ?>
                             <? foreach ($userContacts['phones'] as $key => $ph): ?>
                                 <div class="form-group">
                                     <label for="number">Номер <?= ++$key ?></label>
                                     <input type="text" class="form-control" name="number[<?= $ph['id'] ?>]" id="address" value="<?= $ph['number'] ?>"/>
                                 </div>
                                 <div class="form-group">
                                     <label for="numtype">Тип <?= $key ?></label>
                                     <input type="text" class="form-control" name="numtype[<?= $ph['id'] ?>]" id="numtype" value="<?= $ph['number_type'] ?>"/>
                                 </div>
                             <? endforeach; ?>
                         <? endif; ?>
                        <hr>

                        <strong><i class="fa fa-envelope margin-r-5"></i> Электронная почта:</strong>
                        <p class="text-muted">
                            <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
                        </p>
                        <hr>
                        <input type="submit" value="Сохранить" class="btn btn-block btn-primary"/>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <!--                        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                                                <li><a href="#timeline" data-toggle="tab">Timeline</a></li>-->
                        <li class="active"><a href="#settings" data-toggle="tab">Управление правами <?= $userProfile['username'] ?></a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="active tab-pane" id="role">
                            <div class="form-group">
                                <label for="roles">Роль пользователя</label>
                                <select name="roles" class="form-control" id="roles">
                                    <? if (!empty($allRoles)): ?>
                                         <? $selected = '' ?>
                                         <? foreach ($allRoles as $role): ?>
                                             <? $selected = ($role['role_id'] === $userRole['role_id']) ? 'selected' : '' ?>
                                             <option value="<?= $role['role_id'] ?>" <?= $selected ?>><?= $role['role_name'] ?></option>
                                         <? endforeach; ?>
                                     <? endif; ?>
                                </select>
                            </div>
                            <h3>Права пользователя</h3>
                            <div id="rolesList">
                                <? if ($userPerms): ?>
                                     <ul>
                                         <? foreach ($userPerms as $perm => $bool): ?>
                                             <li><?= $perm ?></li>
                                         <? endforeach; ?>
                                     </ul>
                                 <? endif; ?>
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </form>
    </div><!-- /.row -->

</section><!-- /.content -->

<? require_once Path::PATH_TO_INC . 'addAddress.inc.php'; ?>
<? require_once Path::PATH_TO_INC . 'addPhone.inc.php'; ?>

<script type="text/javascript" src="/app/template/backend/js/user/edituser.js"></script>