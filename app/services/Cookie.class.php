<?php
 
 namespace app\services;

 class Cookie {

     public static function set($key, $value, $time = 3600, $path = '/') {
         setcookie($key, $value, time() + $time, $path);
     }

     public static function get($key) {
         if (isset($_COOKIE[$key]))
             return $_COOKIE[$key];
         return FALSE;
     }

     public static function delete($key) {
         setcookie($key, '');
     }
     
     public static function has($key){
         return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
     }
 }
 