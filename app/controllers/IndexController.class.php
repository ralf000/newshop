<?php

 class IndexController extends AbstractController {
     
     protected function requiredRoles() {}

     function indexAction() {
         $fc = FrontController::getInstance();

         $model       = new UserTableModel();
         $model->name = $fc->getParams();
         $output      = $model->render('../views/index.php');
         echo date('d-m-Y', strtotime('now - 2 week'));
         $fc->setBody($output);
     }

 }
 