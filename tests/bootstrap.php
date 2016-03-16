<?php

 /*
  * To change this license header, choose License Headers in Project Properties.
  * To change this template file, choose Tools | Templates
  * and open the template in the editor.
  */

 /**
  * @author kudinov
  */
// TODO: check include path
 ini_set('include_path', 
         ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__)
         .'/../app/extensions/vendor/bin'.PATH_SEPARATOR.dirname(__FILE__)
         .'/../app/extensions/vendor/phpunit/phpunit'.PATH_SEPARATOR.dirname(__FILE__)
         .'/../app/extensions/vendor/phpunit'
         .'/app/extensions/vendor/bin/'
         .'/app/extensions/vendor/'
         );

// put your code here
?>
