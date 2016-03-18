<?php

 namespace app\models;

 class IndexPageModel extends Model {

     protected $widgetsData = [], $data        = [];

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
 