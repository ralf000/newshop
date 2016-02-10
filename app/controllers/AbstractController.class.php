<?php

 abstract class AbstractController implements IController {

     abstract protected function requiredRoles();

     public function beforeEvent($action) {
         return $this->checkRolesForAction($action);
     }
     
//     public function afterEvent(){
//         return $this->getMessage();
//     }

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
     
//     public function getMessage(){
//         return $this->message['msg'] ? $this->message : FALSE;
//     }
 }
 