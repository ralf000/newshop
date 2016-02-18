<?php

 class AdminController extends AbstractController {

     protected function requiredRoles() {
         return [
             'index'     => [1, 2, 3],
             'add'       => [1, 2,],
             'newCat'    => [1, 2],
             'newSubCat' => [1, 2]
         ];
     }

     public function indexAction() {
         $fc        = FrontController::getInstance();
         $model     = new AdminModel();
         $model->setWidgetsData($this->getAllWidgets());
         $userModel = new UserTableModel();
         $userModel->setId(Session::get('user_id'));
         $userModel->setTable('user');
         $userModel->readRecordsById('id', '`id`,`username`, `full_name`, `photo`, `email`');
         $model->setData(['user' => $userModel->getRecordsById()[0]]);
         $output    = $model->render('../views/admin/index.php', 'admin');
         $fc->setPage($output);
     }

     public function addAction() {
         $fc    = FrontController::getInstance();
         $model = new ProductTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('product');
             $model->setData();
             $model->addRecord();
             $imageModel = new ImageTableModel($model->getLastId());
             $imageModel->setTable('image');
             $imageModel->setData();
             $imageModel->addAllImages();
             header('Location: /admin/');
             exit;
         } else {
//             $adminModel             = new AdminModel();
             $catsAndSub             = [];
             $catsAndSub             = $this->getCatsAndSubCats();
             $model->categoryList    = $catsAndSub['cats']; //used magic __set
             $model->subCategoryList = $catsAndSub['subcats']; //used magic __set
             $output                 = (new AdminModel())->render('../views/admin/add.php', 'admin');
             $fc->setPage($output);
         }
     }

     public function loginAction() {
         $fc    = FrontController::getInstance();
         $model = new UserTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('user');
             $model->setData();
             if ($model->login()) {
                 $ref = Session::get('referer');
                 Session::delete('referer');
                 header('Location: /admin/index');
             } else {
                 header('Location: ' . $_SERVER['REQUEST_URI']);
             }
             exit;
         } else {
             if ($_SESSION['user_id'])
                 header('Location: /');
             $output = $model->render('../views/admin/login.php', 'other');
             $fc->setPage($output);
         }
     }

     public function logoutAction() {
         $fc    = FrontController::getInstance();
         $model = new UserTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->logout();
             header('Location: /admin/login');
             exit;
         } else {
             $output = $model->render('../views/admin/login.php');
             $fc->setPage($output);
         }
     }

     public function profileAction() {
         $fc        = FrontController::getInstance();
         $model     = new AdminModel();
         $model->setWidgetsData($this->getAllWidgets());
         $userModel = new UserTableModel();
         $userModel->setId(Session::get('user_id'));
         $userModel->setTable('user');
         $userModel->readRecordsById('id', '`id`,`username`, `full_name`, `photo`, `email`');
         $userModel->readUserAddress();
         $userModel->readUserPhones();
         $model->setData(['user' => $userModel->getRecordsById()[0], 'userContacts' => $userModel->getUserContacts()]);
         $output    = $model->render('../views/admin/profile.php', 'admin');
         $fc->setPage($output);
     }

     public function newCatAction() {
         $fc    = FrontController::getInstance();
         $model = new CategoryTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('category');
             if ($model->setData())
                 $model->addRecord();
         }
         header('Location: /admin/add');
         exit;
     }

     public function newSubCatAction() {
         $fc    = FrontController::getInstance();
         $model = new SubCategoryTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('subcategory');
             $model->setData();
             $model->addRecord();
         }
         header('Location: /admin/add');
         exit;
     }

     private function getCatsAndSubCats() {
         $categoryModel    = new CategoryTableModel();
         $categoryModel->setTable('category');
         $categoryModel->readAllRecords();
         $subCategoryModel = new SubCategoryTableModel();
         $subCategoryModel->setTable('subcategory');
         $subCategoryModel->readAllRecords();
         return [
             'cats'    => array_reverse($categoryModel->getAllRecords()),
             'subcats' => array_reverse($subCategoryModel->getAllRecords())
         ];
     }

     private function getAllWidgets() {
         $AdminWidgets = new AdminWidgets();
         $products     = $AdminWidgets->getDataForWidget('product');
         $orders       = $AdminWidgets->getDataForWidget('order');
         $clients      = $AdminWidgets->getDataForWidget('user', 'INNER JOIN user_role ON user.id = user_role.user_id WHERE role_id = 4');
         $comments     = $AdminWidgets->getDataForWidget('comment');

         $productsPerMonts = $AdminWidgets->getDataForWidget('product', 'where created_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND created_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         $ordersPerMonth   = $AdminWidgets->getDataForWidget('order', 'where create_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND create_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         $clientsPerMonth  = $AdminWidgets->getDataForWidget('user', 'INNER JOIN user_role ON user.id = user_role.user_id where role_id = 4 AND user.create_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND user.create_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
         $commentsPerMonth = $AdminWidgets->getDataForWidget('comment', 'where create_time > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND create_time < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)');
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

 }
 