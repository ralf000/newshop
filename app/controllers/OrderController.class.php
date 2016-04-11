<?php

 namespace app\controllers;

use app\helpers\Basket;
use app\helpers\Helper;
use app\models\FrontModel;
use app\models\OrderTableModel;

 class OrderController extends AbstractController {

     protected function requiredRoles() {
         
     }

     public function indexAction() {
         $fc    = FrontController::getInstance();
         $model = new FrontModel;

         $model->setData([
             'basket' => Basket::getProductsFromBasket(TRUE)
         ]);
         $output = $model->render('../views/order/order.php', 'withoutSliderAndSidebar');
         $fc->setPage($output);
     }

     public function checkoutAction() {
         $fc    = FrontController::getInstance();
         $model = new FrontModel;

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $orderModel = new OrderTableModel();
             $orderModel->setData();
             $orderModel->addRecord();
             Basket::deleteBasket();
             \app\services\Session::setMsg('Ваш заказ принят. Наш менеджер свяжется с вами в ближайшее время', 'success');
             header('Location: /');
             exit;
         } else {
             $output = $model->render('../views/order/order.php', 'withoutSliderAndSidebar');
             $fc->setPage($output);
         }
     }

 }
 