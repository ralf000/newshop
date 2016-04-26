<?php

 namespace app\controllers;

use app\helpers\Generator;
use app\helpers\Helper;
use app\models\FrontModel;
use app\widgets\IndexWidgets;

 class IndexController extends AbstractController {

     protected function requiredRoles() {
         
     }

     function indexAction() {
         $fc     = FrontController::getInstance();
         $model  = new FrontModel();
         $popProducts = (new IndexWidgets)->recAndPopProductsWidget('popular', 6);
         $recProducts = (new IndexWidgets)->recAndPopProductsWidget('recommended');
         $model->setData([
             'slides' => IndexWidgets::getSliderWidget(),
             'currentCategory' => (new IndexWidgets)->currentCategoryWidget(Helper::getSiteConfig()->currentCategoryWidget),
             'popularProducts' => Generator::popularProducts($popProducts, 6),
             'recommendedProducts' => Generator::recommendedProducts($recProducts),
         ]);
         $output = $model->render('../views/index.php', 'main');
         $fc->setPage($output);
     }
     
 }
 