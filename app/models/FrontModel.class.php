<?php

 namespace app\models;

use app\widgets\IndexWidgets;
use app\helpers\Helper;

 class FrontModel extends Model {

     protected $widgetsData = [], $data        = [];

     function __construct() {
         parent::__construct();
         $this->setData([
             'catsAndSubCats' => IndexWidgets::sideBarMenuWidget(),
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
 