<?php

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
                 $alterRegRoles[$key . 'Action'] = $value;
             }
             if (array_key_exists($action, $alterRegRoles)) {
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

 }
 