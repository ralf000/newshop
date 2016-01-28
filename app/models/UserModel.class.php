<?php

 class UserModel {
     /* Имя пользователя */

     public $name = '';
     /* Список пользователей */
     public $list = array();
     /* Текущий пользователь: ассоциативный массив 
      * 	с элементами role и name для существующего пользователя
      * 	или только с элементом name для неизвестного пользователя
      */
     public $user = array();
     public $userRole = [];

     function getUsersList() {
         $usersList  = unserialize(file_get_contents(dirname(__DIR__) . '/../data/users.txt'));
         $this->list = $usersList;
         return $this->list;
     }

     function getUserRole() {
         $fc        = FrontController::getInstance();
         $usersList = $this->getUsersList();
         $userName  = key($this->user);
         if (array_key_exists($userName, $usersList)) {
             return [$userName => $usersList[$userName]];
         }
     }

     function render($file) {
         ob_start();
         include dirname(__FILE__) . DIRECTORY_SEPARATOR . $file;
         return ob_get_clean();
     }

 }
 