<?php

 namespace app\controllers;

 use app\models\FrontModel;
 use app\services\Mailer;
 use app\services\Session;

 class ContactsController extends AbstractController {

     protected function requiredRoles() {
         
     }

     public function indexAction() {
         $fc    = FrontController::getInstance();
         $model = new FrontModel;
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             Mailer::setData($_POST);
             if (Mailer::emailHandler()) {
                 Session::setUserMsg('Ваше сообщение успешно отправлено. Мы свяжемся с вами в ближайшее время', 'success');
                 header('Location: ' . $_SERVER['REQUEST_URI']);
                 exit;
             }
         } else {
             $output = $model->render('../views/contacts/contacts.php', 'withoutSliderAndSidebar');
             $fc->setPage($output);
         }
     }

 }
 