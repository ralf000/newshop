<?php

 class Model {

     function render($file) {
         ob_start();
         require(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'head.php');
         require(dirname(__FILE__) . DIRECTORY_SEPARATOR . $file);
         require(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'footer.php');
         return ob_get_clean();
     }

 }
 