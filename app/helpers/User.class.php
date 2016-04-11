<?php

 namespace app\helpers;

 use app\models\UserTableModel;
 use app\services\Session;

 class User {

     public static function isAuth() {
         return Session::check('user_id');
     }

     public static function checkUser() {
         // Предотвращение перехвата сеанса
         $sessUserId = Session::get('user_id');
         if (!(isset($sessUserId))) {
             Session::destroy();
//             unset($this->user);
             Session::setMsg('Произошла ошибка. Пожалуйста авторизуйтесь заново', 'warning');
             return FALSE;
         }
         // Предотвращение фиксации сеанса (включая ini_set('session.use_only_cookies', true);)
         $sessGenerated = Session::get('generated');
         if (!isset($sessGenerated) || $sessGenerated < (time() - 30)) {
             session_regenerate_id();
             $_SESSION['generated'] = time();
         }
         if ($sessUserId) {
             $userModel = new UserTableModel;
             $userModel->setId($sessUserId);
             $userModel->setTable('user');
             $username  = $userModel->readRecordsById('id', 'username')[0]['username'];
             Session::set('username', $username);
             return TRUE;
         }
         return FALSE;
     }

     //Современный способ солить и хешировать пароль
     /*      * Функция солит и хеширует пароль
      * @param  string $password
      * @return string хеш пароля
      */
     public static function hs($password) {
         if (defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH) {
             $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22); //$2y$11$ - специальный ключ
             return crypt($password, $salt);
         }
     }

     public static function confirmPassword($hash, $password) {
         return crypt($password, $hash) === $hash;
     }

 }
 