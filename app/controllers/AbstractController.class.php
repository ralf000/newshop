<?php

 namespace app\controllers;

use app\models\CategoryTableModel;
use app\models\SubCategoryTableModel;
use app\models\UserTableModel;
use app\services\DB;
use app\services\PrivilegedUser;
use app\services\Session;

 abstract class AbstractController implements IController {

     abstract protected function requiredRoles();

     public function beforeEvent($action) {
         if ($userId = $this->rememberMeChecker())
             (new UserTableModel)->auth($userId);
         return $this->checkRolesForAction($action);
     }

     protected function checkRolesForAction($action) {
         $reqRoles      = $this->requiredRoles();
         $alterRegRoles = [];
         if ($reqRoles) {
             foreach ($reqRoles as $key => $value) {
                 $alterRegRoles[strtolower($key . 'Action')] = $value;
             }
             if (array_key_exists($action = strtolower($action), $alterRegRoles)) {
                 $roles = $alterRegRoles[$action];
                 if (Session::get('user_id'))
                     $user  = PrivilegedUser::getUserRoleById(DB::init()->connect(), Session::get('user_id'));
                 else
                     $user  = [
                         'role_id'   => 5,
                         'role_name' => 'Guest',
                     ];
                 return in_array($user['role_id'], $roles);
             }
         }
         return TRUE;
     }

     protected function rememberMeChecker() {
         if (filter_has_var(INPUT_COOKIE, 'remember')) {
             $remember  = filter_input(INPUT_COOKIE, 'remember');
             $user_id   = (int) substr($remember, 0, strpos($remember, '-'));
             $userModel = new UserTableModel;
             $userModel->setId($user_id);
             $userModel->setTable('user');
             $userModel->readRecordsById('id', 'password_hash');
             $password  = $userModel->getRecordsById()[0]['password_hash'];
             $joinStr   = $user_id . '-' . md5($user_id . $_SERVER['REMOTE_ADDR'] . $password);
             return ($remember === $joinStr) ? $user_id : FALSE;
         }
     }

     protected function getCatsAndSubCats($flag = FALSE) {
         $condition = '';
         $categoryModel    = new CategoryTableModel();
         $categoryModel->setTable('category');
         $categoryModel->readAllRecords();
         $subCategoryModel = new SubCategoryTableModel();
         $subCategoryModel->setTable('subcategory');
         if (!$flag)
             $condition .= "WHERE subcategory.category_id = " . end($categoryModel->getAllRecords())['id'];
         $subCategoryModel->readAllRecords('*', $condition);
         return [
             'cats'    => array_reverse($categoryModel->getAllRecords()),
             'subcats' => array_reverse($subCategoryModel->getAllRecords())
         ];
     }

     /**
      * Метод делегирует полномочия класса другим классам
      * Работает на подобии __call. Но его применить не удалось 
      * из-за использования ReflectionClass в FrontController
      * Если в FrontController::route не удается найти вызываемый action
      * данный метод пытается вызвать этот метод у классов, 
      * добавленных в делегирование в конструкторе
      * @param string $method имя вызываемого метода (action)
      * @param array $arguments массив аргументов для метода
      */
//     public function delegator($method, array $arguments = []) {
//         if (!empty($this->delegatedObjects)) {
//             foreach ($this->delegatedObjects as $object) {
//                 if (method_exists($object, $method))
//                     return call_user_method_array($method, $object, $arguments);
//             }
//             throw new Exception('Action not found');
//         }
//     }
     
 }
 