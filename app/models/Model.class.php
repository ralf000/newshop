<?php

 namespace app\models;

 use app\helpers\Path;
 use app\services\DB;
 use Exception;

 class Model {

     protected $db;

     public function __construct() {
         try {
             $this->db = DB::init()->connect();
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     function render($file, $template = '') {
         ob_start();
         switch ($template) {
             case 'admin':
                 require(Path::PATH_TO_ADMIN_TEMPLATE . 'head.php');
                 require(Path::PATH_TO_INC . 'message.inc.php');
                 require(Path::PATH_TO_ADMIN_TEMPLATE . 'header.php');
                 require(Path::PATH_TO_ADMIN_TEMPLATE . 'sidebar.php');
                 require(dirname(__FILE__)
                         . DIRECTORY_SEPARATOR
                         . $file);
                 require(Path::PATH_TO_ADMIN_TEMPLATE . 'footer.php');
                 break;
             case 'status':
             case 'other':
                 require(Path::PATH_TO_ADMIN_TEMPLATE . 'head.php');
                 require(Path::PATH_TO_INC . 'message.inc.php');
                 require(dirname(__FILE__)
                         . DIRECTORY_SEPARATOR
                         . $file);
                 break;
             case 'main':
                 require Path::PATH_TO_TEMPLATE . 'head.php';
                 require(Path::PATH_TO_INC . 'message.inc.php');
                 require Path::PATH_TO_TEMPLATE . 'header.php';
                 require Path::PATH_TO_TEMPLATE . 'slider.php';
                 require Path::PATH_TO_TEMPLATE . 'sidebar.php';
                 require(dirname(__FILE__)
                         . DIRECTORY_SEPARATOR
                         . $file);
                 require Path::PATH_TO_TEMPLATE . 'footer.php';
                 break;
             case 'withoutSlider':
                 require Path::PATH_TO_TEMPLATE . 'head.php';
                 require(Path::PATH_TO_INC . 'message.inc.php');
                 require Path::PATH_TO_TEMPLATE . 'header.php';
                 require Path::PATH_TO_TEMPLATE . 'sidebar.php';
                 require(dirname(__FILE__)
                         . DIRECTORY_SEPARATOR
                         . $file);
                 require Path::PATH_TO_TEMPLATE . 'footer.php';
                 break;
             default :
                 require(dirname(__FILE__)
                         . DIRECTORY_SEPARATOR
                         . $file);
         }
         return ob_get_clean();
     }

 }
 