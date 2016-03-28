<?php

 namespace app\services;

 use app\models\UserTableModel;

 class Session {

     public static function init() {
         ini_set('session.use_strict_mode', true);
         ini_set('session.use_only_cookies', true);
         session_start();
         if (self::get('user_id'))
             UserTableModel::checkUser();
     }

     public static function set($key, $value) {
         $_SESSION[$key] = $value;
     }

     public static function setMsg($body, $type = 'info') {
         Session::set('msg', [
             'type' => $type,
             'body' => $body
         ]);
     }

     public static function setUserMsg($body, $type = 'info') {
         Session::set('userMsg', [
             'type' => $type,
             'body' => $body
         ]);
     }

     public static function showUserMsg() {
         if (isset($_SESSION['userMsg']) && !empty($_SESSION['userMsg'])) {
             $userMsg = self::get('userMsg');
             self::delete('userMsg');
             return '<div class="status alert alert-' . $userMsg['type'] . '" style="display: block">' . $userMsg['body'] . '</div>';
         }
     }

     public static function get($key) {
         if (isset($_SESSION[$key]))
             return $_SESSION[$key];
         return FALSE;
     }

     public static function delete($key) {
         unset($_SESSION[$key]);
     }

     public static function destroy() {
//          unset($_SESSION);
         session_destroy();
     }

 }
 