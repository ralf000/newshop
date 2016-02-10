<?
 $allRecords = $this->getAllRecords();
 if (is_array($allRecords) && empty($allRecords))
     $allRecords = 'Нет товаров для отображения';
?>
<h3><?= $allRecords ?></h3>
