<?php
 
 namespace app\services;

 class Cookie {

     public static function set($key, $value, $time = 3600 * 24 * 7 * 12, $path = '/') {
         setcookie($key, $value, time() + $time, $path);
     }

     public static function get($key) {
         if (isset($_COOKIE[$key]))
             return $_COOKIE[$key];
         return FALSE;
     }

     public static function delete($key, $path = '/') {
         setcookie($key, '', -3600, $path);
     }
     
     public static function has($key){
         return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
     }
 }
 