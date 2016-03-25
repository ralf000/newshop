<?php

 namespace app\controllers;

use app\helpers\Helper;
use app\models\FrontModel;
use app\widgets\IndexWidgets;

 class IndexController extends AbstractController {

     protected function requiredRoles() {
         
     }

     function indexAction() {
         $fc     = FrontController::getInstance();
         $model  = new FrontModel();
         $model->setData([
             'slides' => IndexWidgets::getSliderWidget(),
//             'catsAndSubCats' => IndexWidgets::sideBarMenuWidget($this->getCatsAndSubCats(TRUE)),
             'currentCategory' => (new IndexWidgets)->currentCategoryWidget(Helper::getSiteConfig()->currentCategoryWidget)
         ]);
         $output = $model->render('../views/index.php', 'main');
         $fc->setPage($output);
     }

 }
 