<?php

 namespace app\widgets;

use app\helpers\Generator;
use app\models\SliderTableModel;

 class IndexWidgets extends WidgetAbstract {

     public static function getSliderWidget() {
         $model = new SliderTableModel();
         $model->setTable('slider');
         $model->readAllRecords();
         $slides = $model->getAllRecords();
         return Generator::sliderGenerator($slides);
     }

 }
 