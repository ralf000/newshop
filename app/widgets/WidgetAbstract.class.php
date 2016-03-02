<?php

 namespace app\widgets;

use app\services\DB;

 class WidgetAbstract {

     protected $db;

     function __construct() {
         $this->db = DB::init()->connect();
     }

 }
 