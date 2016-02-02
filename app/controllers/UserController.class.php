<?php

 class UserController implements IController {

     public function indexAction() {
         $fc     = FrontController::getInstance();
         $output = $model->render('../views/user/admin.php');
         $fc->setPage($output);
     }

 }
 