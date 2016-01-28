<?php

 class UserController implements IController {

     function helloAction() {
         $fc          = FrontController::getInstance();
         $model       = new UserModel;
         $model->name = $fc->getParams()['name'];
         $output      = $model->render('../views/index.php');
         $fc->setBody($output);
     }

     function listAction() {
         $fc = FrontController::getInstance();
         $model = new UserModel;
         $model->getUsersList();
         $output = $model->render('../views/usersList.php');
         $fc->setBody($output);
     }
     
     function getAction() {
         $fc = FrontController::getInstance();
         $model = new UserModel;
         $model->user = $fc->getParams();
         $model->userRole = $model->getUserRole();
         $output = $model->render('../views/userRole.php');
         $fc->setBody($output);
     }

 }
 