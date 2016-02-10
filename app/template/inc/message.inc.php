<? // require (dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . 'Session.class.php');?>
<? $msg = Session::get('msg');?>
<? if ($msg):?>
<div class="box">
    <div class="alert alert-<?= $msg['type'] ?>" role="alert">
        <?= $msg['body'] ?>
    </div>
</div>
<? Session::delete('msg');?>
<? endif;?>