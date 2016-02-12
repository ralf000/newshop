<?php
 class AdminWidgets{

     protected $db;

     public function __construct() {
         $this->db = DB::init()->connect();
     }

     public function getDataForWidget($table, $condition = '') {
         try {
             $st = $this->db->prepare("SELECT COUNT(`id`) as num FROM `$table` $condition");
             $st->execute();
             return $st->fetch(PDO::FETCH_ASSOC)['num'];
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
 }

