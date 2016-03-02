<?php
 
 class UserController extends AbstractController {

     protected function requiredRoles() {
         return [
             'index'        => [1, 2, 3, 4],
             'registration' => [5],
             'login'        => [5],
             'validate'     => [5]
         ];
     }

     public function indexAction() {
         
     }

     public function registrationAction() {
         $fc    = FrontController::getInstance();
         $model = new UserTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('user');
             if ($model->setData('reg')) {
                 $model->registration();
//                 if ($model->login()) {
                 Session::setMsg('На ваш электронный ящик отправлено письмо, содержащее ссылку для активации аккаунта', 'info');
                 header('Location: /');
                 exit;
//                 }
//                 else
//                     header('Location: /user/login');
             }
         } else {
             if ($_SESSION['user_id'])
                 header('Location: /');
             $output = $model->render('../views/user/registration.php');
             $fc->setPage($output);
         }
     }

     public function loginAction() {
         $fc    = FrontController::getInstance();
         $model = new UserTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('user');
             $model->setData();
             if ($model->login()) {
                 $ref = Session::get('referer');
                 Session::delete('referer');
                 header('Location: ' . $ref ? $ref : '/admin');
             } else {
                 header('Location: ' . $_SERVER['REQUEST_URI']);
             }
             exit;
         } else {
             if ($_SESSION['user_id'])
                 header('Location: /');
             $output = $model->render('../views/user/login.php');
             $fc->setPage($output);
         }
     }

     public function logoutAction() {
         $fc    = FrontController::getInstance();
         $model = new UserTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->logout();
             header('Location: /user');
             exit;
         } else {
             $output = $model->render('../views/user/index.php');
             $fc->setPage($output);
         }
     }

     public function validateAction() {
         $fc     = FrontController::getInstance();
         $model  = new UserTableModel();
         $model->setTable('user');
         $model->setValidateUserData($fc->getParams());
         $model->checkValidKey();
         $output = $model->render('../views/user/validate.php');
         $fc->setPage($output);
     }

 }
 