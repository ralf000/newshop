<?php

 namespace app\widgets;

use app\helpers\Generator;
use app\models\SliderTableModel;
use Exception;
use PDO;

 class IndexWidgets extends WidgetAbstract {

     public static function getSliderWidget() {
         $model  = new SliderTableModel();
         $model->setTable('slider');
         $model->readAllRecords();
         $slides = $model->getAllRecords();
         return Generator::sliderGenerator($slides);
     }

     public static function sideBarMenuWidget(array $catsNsubs) {
         if (count($catsNsubs) !== 2)
             throw new Exception('Передан неверный массив категорий и подкатегорий');
         $cats = current($catsNsubs);
         $subs = end($catsNsubs);
         foreach ($cats as $key => $c){
             foreach ($subs as $s){
                 if ($c['id'] === $s['category_id'])
                     $cats[$key]['subcategories'][] = $s;
             }
         }
         return $cats;
     }
     
     public function currentCategoryWidget($id){
         try {
             $st = $this->db->prepare("SELECT * FROM category as c LEFT JOIN subcategory as s ON c.id = s.category_id WHERE c.id = ? ORDER BY c.id LIMIT 4");
             $st->execute([$id]);
             return $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
 }
 