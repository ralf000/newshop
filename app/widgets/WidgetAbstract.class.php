<?php

 namespace app\widgets;

use app\services\DB;
use PDO;
use Exception;

 class WidgetAbstract {

     protected $db;

     function __construct() {
         $this->db = DB::init()->connect();
     }
     
     public function getNum($table, $condition = '') {
         try {
             $st = $this->db->prepare("SELECT COUNT(`id`) as num FROM `$table` $condition");
             $st->execute();
             return $st->fetch(PDO::FETCH_ASSOC)['num'];
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

 }
 