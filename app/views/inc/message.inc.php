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
     <div class="box">
         <div class="alert alert-<?= $msg['type'] ?>" style="position: absolute; width: 100%;">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
             <h4><?= $t ?></h4>
             <?= $msg['body'] ?>
         </div>
     </div>
     <? Session::delete('msg'); ?>
 <? endif; ?>