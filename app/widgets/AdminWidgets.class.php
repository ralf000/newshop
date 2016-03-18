<?php

 namespace app\widgets;

use app\models\ProductTableModel;
use Exception;
use PDO;

 class AdminWidgets extends WidgetAbstract {

     public function getCntWidgets() {
         $products = $this->getNum('product');
         $orders   = $this->getNum('order');
         $clients  = $this->getNum('user', 'INNER JOIN user_role ON user.id = user_role.user_id WHERE role_id = 4');
         $comments = $this->getNum('comment');

         $productsPerMonts = $this->getNum('product', 'where created_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND created_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         $ordersPerMonth   = $this->getNum('order', 'where create_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND create_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         $clientsPerMonth  = $this->getNum('user', 'INNER JOIN user_role ON user.id = user_role.user_id where role_id = 4 AND user.create_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND user.create_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         $commentsPerMonth = $this->getNum('comment', 'where create_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND create_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         return [
             'products'         => $products,
             'orders'           => $orders,
             'clients'          => $clients,
             'comments'         => $comments,
             'productsPerMonts' => $productsPerMonts,
             'ordersPerMonth'   => $ordersPerMonth,
             'clientsPerMonth'  => $clientsPerMonth,
             'commentsPerMonth' => $commentsPerMonth,
             'persentsProds'    => ($productsPerMonts) ? 100 / ($products / $productsPerMonts) : 0,
             'persentsOrders'   => ($ordersPerMonth) ? 100 / ($orders / $ordersPerMonth) : 0,
             'persentsClients'  => ($clientsPerMonth) ? 100 / ($clients / $clientsPerMonth) : 0,
             'persentsComm'     => ($commentsPerMonth) ? 100 / ($comments / $commentsPerMonth) : 0,
         ];
     }

     public function getUsersForRoleWidget($roleId, $condition, $limit) {
         try {
             $st = $this->db->prepare("SELECT * FROM user JOIN user_role ON user.id = user_role.user_id $condition ORDER BY user.create_time DESC LIMIT $limit");
             $st->execute([$roleId]);
             return $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function getAllProductsWidget($fields = '*', $condition = '') {
         $model = new ProductTableModel();
         return $model->getAllProducts($fields, $condition);
     }

 }
 