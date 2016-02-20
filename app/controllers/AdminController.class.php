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
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Административная панель', 'управление сайтом');
         $adminWidgets = new AdminWidgets();
         $model->setWidgetsData([
             'cntWidgets'     => $adminWidgets->getCntWidgets(),
             'clientsWidget'  => $adminWidgets->getUsersForRoleWidget(4, 'WHERE user_role.role_id = ?', 10),
             'managersWidget' => $adminWidgets->getUsersForRoleWidget(4, 'WHERE user_role.role_id < ?', 8),
             'productsWidget' => $adminWidgets->getAllProductsWidget($fields          = '*', 'WHERE image.main = 1 ORDER BY product.created_time DESC LIMIT 5')
         ]);
         $output       = $model->render('../views/admin/index.php', 'admin');
         $fc->setPage($output);
     }

     public function addAction() {
         $fc = FrontController::getInstance();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model      = new ProductTableModel();
             $model->setTable('product');
             $model->setData();
             $model->addRecord();
             $imageModel = new ImageTableModel($model->getLastId());
             $imageModel->setTable('image');
             $imageModel->setData();
             $imageModel->addAllImages();
             Session::setMsg('Товар успешно добавлен в базу', 'success');
             header('Location: /admin/');
             exit;
         } else {
             $adminModel                  = new AdminModel('Добавление новых товаров');
             $catsAndSub                  = [];
             $catsAndSub                  = $this->getCatsAndSubCats();
             $adminModel->categoryList    = $catsAndSub['cats']; //used magic __set
             $adminModel->subCategoryList = $catsAndSub['subcats']; //used magic __set
             $output                      = $adminModel->render('../views/admin/add.php', 'admin');
             $fc->setPage($output);
             $adminModel->breadCrumbs();
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
         $fc     = FrontController::getInstance();
         $model  = new AdminModel('Профиль пользователя');
         $model->setWidgetsData((new AdminWidgets)->getCntWidgets());
         $output = $model->render('../views/admin/profile.php', 'admin');
         $fc->setPage($output);
     }

     public function allProductsAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Все товары', 'управление товарами');
         $ProductModel = new ProductTableModel();
         $page         = $fc->getParams()['page'] ? $fc->getParams()['page'] : 1;
         $limit        = $fc->getParams()['limit'] ? $fc->getParams()['limit'] : 3;
         $offset       = $limit * $page - $limit;
         $model->setData([
             'products' => $ProductModel->getAllProducts('product.id, product.title, product.price, product.quantity, product.published, category.category_name, subcategory.subcategory_name, product.created_time, product.updated_time, image.image', "WHERE image.main = 1 LIMIT $limit OFFSET $offset"),
             'limit'    => $limit,
             'page'     => $page,
             'num' => (new AdminWidgets)->getNum('product'),
             'offset' => $offset
         ]);
         $output       = $model->render('../views/admin/allProducts.php', 'admin');
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

 }
 