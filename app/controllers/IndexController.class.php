<?php

 namespace app\controllers;

 use app\models\IndexModel;
 use app\widgets\IndexWidgets;

 class IndexController extends AbstractController {

     protected function requiredRoles() {
         
     }

     function indexAction() {
         $fc     = FrontController::getInstance();
         $model  = new IndexModel();
         $model->setData([
             'slides' => IndexWidgets::getSliderWidget()
         ]);
         $output = $model->render('../views/index.php', 'main');
         $fc->setPage($output);
     }

 }
 