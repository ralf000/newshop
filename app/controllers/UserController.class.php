<?php

 namespace app\controllers;

 use app\helpers\Helper;
 use app\models\FrontModel;
 use app\models\UserTableModel;
 use app\services\Session;

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
                 if ($model->registration()) {
                     Session::setMsg('На ваш электронный ящик отправлено письмо, содержащее ссылку для активации аккаунта', 'info');
                     header('Location: /');
                 } else {
                     header('Location: /user/login');
                 }
                 exit;
             }
         } else {
             if ($_SESSION['user_id'])
                 header('Location: /');
             $output = $model->render('../views/user/registration.php');
             $fc->setPage($output);
         }
     }

     public function loginAction() {
         $fc        = FrontController::getInstance();
         $model     = new FrontModel();
         $userModel = new UserTableModel();

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $userModel->setTable('user');
             $userModel->setData();
             $userModel->login();

             $redirect = Helper::getRedirect();
             if (is_array($redirect) && !empty($redirect['url'])) {
                 $redirect = implode('#', $redirect);
                 header('Location: ' . $redirect);
                 exit;
             }

             if ($fc->getAction() !== 'loginAction')
                 header('Location: ' . $_SERVER['REQUEST_URI']);
             else
                 header('Location: ' . '/');
             exit;
         } else {
             if ($_SESSION['user_id'])
                 header('Location: /');
             $output = $model->render('../views/user/login.php', 'withoutSliderAndSidebar');
             $fc->setPage($output);
         }
     }

     public function logoutAction() {
         $model = new UserTableModel();
         $model->logout();
         header('Location: ' . '/');
         exit;
     }

     public function validateAction() {
         $fc     = FrontController::getInstance();
         $model  = new UserTableModel();
//         $model->setTable('user');
//         if (empty($fc->getParams()['email']) && empty($fc->getParams()['key'])){
//             header('Location: /');
//             exit;
//         }
//         $model->setValidateUserData($fc->getParams());
//         if ($model->checkValidKey()) {
         $output = $model->render('../views/user/validate.php', 'withoutSliderAndSidebar');
         $fc->setPage($output);
//         } else {
//             Session::setMsg('Невозможно активировать данный аккаунт. Пожалуйста зарегистрируйтесь заново', 'warning');
//             header('Location: user/registration');
//             exit;
//         }
     }

 }
 