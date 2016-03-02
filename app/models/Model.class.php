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
         if ($template === 'admin') {
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'backend'
                     . DIRECTORY_SEPARATOR
                     . 'head.php');
             require(Path::PATH_TO_INC. 'message.inc.php');
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'backend'
                     . DIRECTORY_SEPARATOR
                     . 'header.php');
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'backend'
                     . DIRECTORY_SEPARATOR
                     . 'sidebar.php');
             require(dirname(__FILE__)
                     . DIRECTORY_SEPARATOR
                     . $file);
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'backend'
                     . DIRECTORY_SEPARATOR
                     . 'footer.php');
         } elseif ($template === 'status' || $template === 'other') {
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'backend'
                     . DIRECTORY_SEPARATOR
                     . 'head.php');
             require(Path::PATH_TO_INC. 'message.inc.php');
             require(dirname(__FILE__)
                     . DIRECTORY_SEPARATOR
                     . $file);
         } else {
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'head.php');
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'head.php');
             require(Path::PATH_TO_INC. 'message.inc.php');
             require(dirname(__FILE__)
                     . DIRECTORY_SEPARATOR
                     . $file);
             require(dirname(__DIR__)
                     . DIRECTORY_SEPARATOR
                     . 'template'
                     . DIRECTORY_SEPARATOR
                     . 'footer.php');
         }
         return ob_get_clean();
     }
     
  }
 