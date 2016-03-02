<? use app\services\Session; ?>

<? $msg = Session::get('msg'); ?>

<? if ($msg): ?>
     <?
     switch ($msg['type']) {
         case 'danger' :
         case 'warning' : $t = 'Ошибка!';
             break;
         case 'info' : $t = 'Внимание';
             break;
         case 'danger' : $t = 'Успешно!';
             break;
         default : $t = '';
             break;
     }
     ?>
     <div class="box" id="msg">
         <div class="alert alert-<?= $msg['type'] ?>">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
             <h4><?= $t ?></h4>
     <?= $msg['body'] ?>
         </div>
     </div>
     <? Session::delete('msg'); ?>
 <? endif; ?>
<script type="text/javascript">
    var msg = $('#msg');
    $('.close').click('on', function () {
        msg.slideUp();
    });
//    $(function () {
//        msg.hide();
//        msg.slideDown();
//    });
</script>