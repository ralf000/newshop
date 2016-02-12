<?php

 class WidgetsModel extends Model {

     protected $db;

     public function __construct() {
         $this->db = DB::init()->connect();
     }

     public function getQuantity($param) {
         
     }

 }
 