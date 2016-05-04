<?php

 namespace app\models;

use app\helpers\Helper;
use app\widgets\IndexWidgets;

 class FrontModel extends Model {

     protected $widgetsData = [], $data        = [];

     function __construct() {
         parent::__construct();
         $this->setData([
             'sideBarData' => IndexWidgets::sideBarMenuWidget(),
             'footerData' => IndexWidgets::footerWidget()
         ]);
         Helper::redirectChecker();
     }

     function getWidgetsData() {
         return $this->widgetsData;
     }

     function setWidgetsData(array $widgetsData) {
         $this->widgetsData = $widgetsData;
     }

     function setData(array $data) {
         array_push($this->data, $data);
     }

     function getData() {
         return $this->data;
     }

 }
 