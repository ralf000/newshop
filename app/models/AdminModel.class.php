<?php

 class AdminModel extends Model {

     private $db, $widgetsData = [], $data = [];

     public function __construct() {
         $this->db = DB::init()->connect();
     }
     
     function getWidgetsData() {
         return $this->widgetsData;
     }

     function setWidgetsData(array $widgetsData) {
         $this->widgetsData = $widgetsData;
     }

     function setData(array $data) {
         $this->data = $data;
     }
     
     function getData() {
         return $this->data;
     }


  
 }
 