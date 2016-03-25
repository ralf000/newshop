<? use app\helpers\Helper ?>
<? $usersActivity = $this->getWidgetsData()['activity'] ?>
<? Helper::g($this->getWidgetsData()['activity'])?>
<section class="content">
    <div class="box">
        <div class="box-body">
            <ul class="timeline timeline-inverse">
            <!-- timeline time label -->
            <? if (is_array($usersActivity) && !empty($usersActivity)): ?>
                 <? foreach ($usersActivity as $ua): ?>
                     <li class="time-label">
                         <span class="bg-red">
                             <?= explode(' ', Helper::dateConverter($ua['time']))[0] ?>
                         </span>
                     </li>
                     <!-- /.timeline-label -->
                     <? if (is_array($ua['records']) && !empty($ua['records'])): ?>
                         <? foreach ($ua['records'] as $r): ?>
                             <? list($activDate, $ativTime) = explode(' ', $r['time']) ?>
                             <!-- timeline item -->
                             <li>
                                 <i class="<?= Helper::getIconForUserProfileBYAdmin($r['operation']) ?>"></i>
                                 <div class="timeline-item">
                                     <span class="time"><i class="fa fa-clock-o"></i> <?= $ativTime ?></span>
                                     <? $link   = "" ?>
                                     <? $string = "{$translate[$r['operation']]} {$translate[$r['table_name']]['name']} <a href='{$translate[$r['table_name']]['link']}{$r['object_id']}'>«{$r['object_title']}»</a>" ?>
                                     <h3 class="timeline-header"><a href="/admin/profile/id/<?= $r['manager'] ?>"><?= $r['manager_name'] ?></a> <?= $string ?></h3>
                                 </div>
                             </li>
                         <? endforeach; ?>
                     <? endif; ?>
                 <? endforeach; ?>
             <? endif; ?>
            <!-- END timeline item -->
            <!--                            <li>
                                            <i class="fa fa-clock-o bg-gray"></i>
                                        </li>-->
        </ul>
        </div>
    </div>
</section>
<script type="text/javascript" src="/app/template/backend/js/activity.js"></script>