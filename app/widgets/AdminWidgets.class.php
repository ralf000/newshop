<?php

 namespace app\widgets;

 use app\models\ArticleTableModel;
 use app\models\ProductTableModel;
 use app\models\UserTableModel;
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

     public function getAllArticlesWidget($fields = '*', $condition = '') {
         $model     = new ArticleTableModel();
         $model->setTable('article');
         $model->readAllRecords($fields, $condition);
         $records = $model->getAllRecords();
         $userModel = new UserTableModel;
         foreach ($records as $key => $record) {
             $userModel->setId($record['author']);
             $userModel->setTable('user');
             $records[$key]['author_name'] = $userModel->readRecordsById('id', 'username')[0]['username'];
         }
         return $records;
     }

     public function getUserActivity($limit = FALSE) {
         $output       = [];
         if ($limit)
             $limit = 'LIMIT ' . $limit;
         $model        = new UserTableModel();
         $model->setTable('operation_log');
         $model->readAllRecords('*', 'ORDER BY time DESC LIMIT 30');
         $records      = $model->getAllRecords();
         $model->readAllRecords("DISTINCT DATE_FORMAT(`time`, '%Y-%m-%d') as time", "GROUP BY time ORDER BY time DESC $limit");
         $groupRecords = $model->getAllRecords();
         foreach ($groupRecords as $key => $record) {
             $date    = explode(' ', $record['time'])[0];
             $model->readAllRecords("*", "WHERE DATE_FORMAT(`time`, '%Y-%m-%d') = '$date'");
             $records = $model->getAllRecords();
             foreach ($records as $key2 => $record) {
                 if (!empty($record['manager'])) {
                     $model->setTable('user');
                     $model->setId($record['manager']);
                     $records[$key2]['manager_name'] = $model->readRecordsById('id', 'username')[0]['username'];
                 }
             }
             $model->setTable('operation_log');
             $groupRecords[$key]['records'] = $records;
         }
         return $groupRecords;
     }

 }
 