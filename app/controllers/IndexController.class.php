<?php

 class IndexController extends AbstractController {
     
     protected function requiredRoles() {}

     function indexAction() {
         $fc = FrontController::getInstance();
         $model       = new UserTableModel();
         $model->name = $fc->getParams();
         $output      = $model->render('../views/index.php');
         $fc->setPage($output);
     }

 }
 