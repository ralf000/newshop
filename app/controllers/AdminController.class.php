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
             if (empty($_FILES['mainimage']['name'])){
                 Session::setMsg('Не задано главное изображение товара', 'danger');
                 header('Location: /admin/add');
                 exit;
             }
             $model      = new ProductTableModel();
             $model->setTable('product');
             $model->setData();
             $model->addRecord();
             $imageModel = new ImageTableModel($model->getLastId());
             $imageModel->setTable('image');
             $imageModel->setData();
             $imageModel->addAllImages();
             Session::setMsg('Товар успешно добавлен в базу', 'success');
             header('Location: /admin/allProducts');
             exit;
         } else {
             $adminModel                  = new AdminModel('Добавление новых товаров');
             $catsAndSub                  = [];
             $catsAndSub                  = $this->getCatsAndSubCats();
             $adminModel->categoryList    = $catsAndSub['cats']; //used magic __set
             $adminModel->subCategoryList = $catsAndSub['subcats']; //used magic __set
             $output                      = $adminModel->render('../views/admin/product/add.php', 'admin');
             $fc->setPage($output);
         }
     }

     public function viewAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Подробно о товаре');
         $productModel = new ProductTableModel();
         $id           = $fc->getParams()['product'];
         if (!$id) {
             header('Location: /admin/notFound');
             exit;
         }
         $product    = $productModel->getAllProducts('*', "WHERE product.id = $id GROUP BY product.id");
         $imageModel = new ImageTableModel();
         $imageModel->setTable('image');
         $imageModel->setId($id);
         $imageModel->readRecordsById('product_id');
         if (empty($product)) {
             header('Location: /admin/NotFound');
             exit;
         } else {
             $model->setData([
                 'products' => $productModel->getAllProducts('*', "WHERE product.id = $id GROUP BY product.id"),
                 'images'   => $imageModel->getRecordsById(),
             ]);
         }
         $output = $model->render('../views/admin/product/view.php', 'admin');
         $fc->setPage($output);
     }

     public function loginAction() {
         $fc    = FrontController::getInstance();
         $model = new UserTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('user');
             $model->setData();
             if ($model->login()) {
                 header('Location: /admin');
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

     public function NotFoundAction() {
         $fc     = FrontController::getInstance();
         $model  = new AdminModel();
         $output = $model->render('../views/status/404.php', 'other');
         $fc->setPage($output);
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
         $productModel = new ProductTableModel();
         $page         = $fc->getParams()['page'] ? filter_var($fc->getParams()['page'], FILTER_SANITIZE_NUMBER_INT) : 1;
         $limit        = $fc->getParams()['limit'] ? filter_var($fc->getParams()['limit'], FILTER_SANITIZE_NUMBER_INT) : 10;
         $orderBy      = $fc->getParams()['orderBy'] ? filter_var($fc->getParams()['orderBy'], FILTER_SANITIZE_STRING) : 'id';
         $direction    = $fc->getParams()['direction'] ? filter_var($fc->getParams()['direction'], FILTER_SANITIZE_STRING) : 'asc';
         $offset       = $limit * $page - $limit;
         $model->setData([
             'products'  => $productModel->getAllProducts('product.id, product.title, product.price, product.quantity, product.published, category.category_name, subcategory.subcategory_name, product.created_time, product.updated_time, image.image', "GROUP BY product.id ORDER BY product.$orderBy " . strtoupper($direction) . " LIMIT $limit OFFSET $offset"),
             'limit'     => $limit,
             'orderBy'   => $orderBy,
             'direction' => $orderDirection,
             'page'      => $page,
             'num'       => (new AdminWidgets)->getNum('product'),
             'offset'    => $offset
         ]);
         $output       = $model->render('../views/admin/product/allProducts.php', 'admin');
         $fc->setPage($output);
     }

     public function editProductAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Редактирование товара');
         $id           = filter_var($fc->getParams()['product'], FILTER_SANITIZE_STRING);
         $productModel = new ProductTableModel();
         $productModel->setId($id);
         $productModel->setTable('product');

         $imageModel = new ImageTableModel();
         $imageModel->setTable('image');
         $imageModel->setId($id);

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $productModel->setData();
             $productModel->updateProduct();
             $imageModel = new ImageTableModel($productModel->getId());
             $imageModel->setTable('image');
             $imageModel->setId($productModel->getId());
             $imageModel->setData();
             $imageModel->addAllImages();
             Session::setMsg('Товар успешно обновлен', 'success');
             header('Location: /admin/view/product/' . $productModel->getId());
             exit;
         } else {
             if (!$id) {
                 header('Location: /admin/notFound');
                 exit;
             }
             $product = $productModel->getAllProducts('*', "WHERE product.id = $id GROUP BY product.id");
             $imageModel->readRecordsById('product_id');
             if (empty($product)) {
                 header('Location: /admin/NotFound');
                 exit;
             } else {
                 $model->setData([
                     'products' => $productModel->getAllProducts('*', "WHERE product.id = $id GROUP BY product.id"),
                     'images'   => $imageModel->getRecordsById(),
                 ]);
             }

             $catsAndSub             = [];
             $catsAndSub             = $this->getCatsAndSubCats();
             $model->categoryList    = $catsAndSub['cats']; //used magic __set
             $model->subCategoryList = $catsAndSub['subcats']; //used magic __set

             $output = $model->render('../views/admin/product/edit.php', 'admin');
             $fc->setPage($output);
         }
     }

//     public function deleteProduct() {
//         $fc = FrontController::getInstance();
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $model = new ProductTableModel();
//             if (filter_has_var(INPUT_POST, 'id'))
//                 $id    = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
//             $model->setId($id);
//             $model->deleteRecord();
//         }else {
//             $output = $model->render('../views/admin/product/edit.php', 'admin');
//             $fc->setPage($output);
//         }
//     }

     public function newCatAction() {
         $fc    = FrontController::getInstance();
         $model = new CategoryTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('category');
             if ($model->setData())
                 $model->addRecord();
         }
//         header('Location: ' . $_SERVER['HTTP_REFERER']);
//         exit;
     }

     public function newSubCatAction() {
         $fc    = FrontController::getInstance();
         $model = new SubCategoryTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setTable('subcategory');
             $model->setData();
             $model->addRecord();
         }
//         header('Location: ' . $_SERVER['HTTP_REFERER']);
//         exit;
     }

     private function getCatsAndSubCats() {
         $categoryModel    = new CategoryTableModel();
         $categoryModel->setTable('category');
         $categoryModel->readAllRecords();
         $subCategoryModel = new SubCategoryTableModel();
         $subCategoryModel->setTable('subcategory');
         $subCategoryModel->readAllRecords('*', "WHERE subcategory.category_id = ".  end($categoryModel->getAllRecords())['id']);
         return [
             'cats'    => array_reverse($categoryModel->getAllRecords()),
             'subcats' => array_reverse($subCategoryModel->getAllRecords())
         ];
     }

 }
 