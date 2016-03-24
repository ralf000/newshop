<?php

 namespace app\controllers;

use app\helpers\SiteConfigurator;
use app\models\AdminModel;
use app\models\ArticleTableModel;
use app\models\CategoryTableModel;
use app\models\ImageTableModel;
use app\models\ProductTableModel;
use app\models\SliderTableModel;
use app\models\SubCategoryTableModel;
use app\models\UserTableModel;
use app\models\UserUpdateTableModel;
use app\services\DB;
use app\services\PrivilegedUser;
use app\services\Role;
use app\services\Session;
use app\widgets\AdminWidgets;

 class AdminController extends AbstractController {

     protected function requiredRoles() {
         return [
             'index'       => [1, 2, 3],
             'add'         => [1, 2],
             'slider'      => [1, 2, 3],
             'addSlide'    => [1, 2],
             'editSlide'   => [1, 2],
             'allProduct'  => [1, 2, 3],
             'addProduct'  => [1, 2],
             'editProduct' => [1, 2],
             'view'        => [1, 2, 3],
             'allUsers'    => [1, 2, 3],
             'editUser'    => [1],
             'profile'     => [1, 2, 3],
             'logout'      => [1, 2, 3, 4],
             'newCat'      => [1, 2],
             'newSubCat'   => [1, 2]
         ];
     }

     public function indexAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Административная панель', 'управление сайтом');
         $adminWidgets = new AdminWidgets();
         $model->setWidgetsData([
             'cntWidgets'     => $adminWidgets->getCntWidgets(),
             'clientsWidget'  => $adminWidgets->getUsersForRoleWidget(4, 'WHERE user_role.role_id = ? AND deleted != 1', 10),
             'managersWidget' => $adminWidgets->getUsersForRoleWidget(4, 'WHERE user_role.role_id < ? AND deleted != 1', 8),
             'productsWidget' => $adminWidgets->getAllProductsWidget($fields          = '*', 'WHERE image.main = 1 ORDER BY product.created_time DESC LIMIT 5')
         ]);
         $output       = $model->render('../views/admin/index.php', 'admin');
         $fc->setPage($output);
     }

     public function addAction() {
         $fc = FrontController::getInstance();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (empty($_FILES['mainimage']['name'])) {
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

     public function addSlideAction() {
         $fc    = FrontController::getInstance();
         $model = new AdminModel('Новый слайд');
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $sliderModel = new SliderTableModel();
             $sliderModel->setData('slider');
             $sliderModel->addRecord();
             Session::setMsg('Новый слайд успешно добавлен', 'success');
             header('Location: /admin/slider');
             exit;
         } else {
             $output = $model->render('../views/admin/slider/addslide.php', 'admin');
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
         $productModel->setId($id);
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
                 'history'  => $productModel->getHistory()
             ]);
         }
         $output = $model->render('../views/admin/product/view.php', 'admin');
         $fc->setPage($output);
     }

     public function viewArticleAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Просмотр статьи');
         $articleModel = new ArticleTableModel();
         $userModel = new UserTableModel;
         $id           = filter_var($fc->getParams()['id'], FILTER_SANITIZE_NUMBER_INT);
         if (!$id) {
             header('Location: /admin/notFound');
             exit;
         }
         $articleModel->setId($id);
         $articleModel->setTable('article');
         
         $article = $articleModel->readRecordsById();
         
         $userModel->setId($article[0]['author']);
         $userModel->setTable('user');

         $model->setData([
             'article' => $article,
             'author' => $userModel->readRecordsById('id', 'id, username')
         ]);
         $output = $model->render('../views/admin/blog/view.php', 'admin');
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
                 exit;
             }
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

     public function siteConfigAction() {
         $fc      = FrontController::getInstance();
         $model   = new AdminModel('Настройки сайта');
         $siteCng = new SiteConfigurator();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $siteCng->setPostData($_POST);
             $siteCng->setSiteConfig();
             Session::setMsg('Настройки сайта успешно обновлены', 'success');
             header('Location: ' . $_SERVER['REQUEST_URI']);
             exit;
         } else {
             $categoryModel = new CategoryTableModel();
             $categoryModel->setTable('category');
             $categoryModel->readAllRecords();
             $model->setData([
                 'siteConfig'     => $siteCng->getSiteConfig(),
                 'siteCategories' => $categoryModel->getAllRecords()
             ]);
             $output        = $model->render('../views/admin/siteconfig/siteconfig.php', 'admin');
             $fc->setPage($output);
         }
     }

     public function profileAction() {
         $fc    = FrontController::getInstance();
         $model = new AdminModel('Профиль пользователя');
//         $model->setWidgetsData((new AdminWidgets)->getCntWidgets());

         $id = filter_var($fc->getParams()['id'], FILTER_SANITIZE_NUMBER_INT);

         if ($id) {
             $userModel               = new UserTableModel();
             $userModel->setId($id);
             $userModel->setTable('user');
             $userProfile             = $userModel->readRecordsById('id', '`id`,`username`, `full_name`, `photo`, `email`');
             $userModel->setTable('operation_log');
             $userActivity            = $userModel->readRecordsById('manager', "*, DATE_FORMAT(`time`, '%Y-%m-%d') as dat", 'ORDER BY `time` DESC');
             $userActivityGroupByDate = $userModel->readRecordsById('manager', "DATE_FORMAT(`time`, '%Y-%m-%d') as dat", 'GROUP BY dat');
             $userModel->readUserAddress();
             $userModel->readUserPhones();
             $model->setData([
                 'userProfile'             => $userProfile, 'userContacts'            => $userModel->getUserContacts(),
                 'userActivity'            => $userActivity,
                 'userActivityGroupByDate' => $userActivityGroupByDate
             ]);
         }
         $output = $model->render('../views/admin/user/profile.php', 'admin');
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
             'direction' => $direction,
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

     public function allUsersAction() {
         $fc        = FrontController::getInstance();
         $model     = new AdminModel('Все пользователи', 'управление пользователями');
         $userModel = new UserTableModel();

         $page      = $fc->getParams()['page'] ? filter_var($fc->getParams()['page'], FILTER_SANITIZE_NUMBER_INT) : 1;
         $limit     = $fc->getParams()['limit'] ? filter_var($fc->getParams()['limit'], FILTER_SANITIZE_NUMBER_INT) : 10;
         $orderBy   = $fc->getParams()['orderBy'] ? filter_var($fc->getParams()['orderBy'], FILTER_SANITIZE_STRING) : 'id';
         $direction = $fc->getParams()['direction'] ? filter_var($fc->getParams()['direction'], FILTER_SANITIZE_STRING) : 'asc';
         $offset    = $limit * $page - $limit;

         $model->setData([
             'users'     => $userModel->getAllUsers('user.id, user.username, user.full_name, user.photo, user.email, user.validated, user.create_time, user.update_time, address.address, address.postal_code, phone.number, phone.number_type', "WHERE deleted != 1 GROUP BY user.id ORDER BY user.$orderBy " . strtoupper($direction) . " LIMIT $limit OFFSET $offset"),
             'limit'     => $limit,
             'orderBy'   => $orderBy,
             'direction' => $direction,
             'page'      => $page,
             'num'       => (new AdminWidgets)->getNum('user'),
             'offset'    => $offset
         ]);
         $output = $model->render('../views/admin/user/allUsers.php', 'admin');
         $fc->setPage($output);
     }

     public function editUserAction() {
         $fc        = FrontController::getInstance();
         $model     = new AdminModel('Редактирование пользователя');
         $userModel = new UserUpdateTableModel();
         $userModel->setTable('user');

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $userModel->setData('userUpdate');
             $userModel->updateRecord();
             header('Location: /admin/profile/id/' . $userModel->getId());
             exit;
         } else {
             $id = filter_var($fc->getParams()['id'], FILTER_SANITIZE_NUMBER_INT);
             if (!$id) {
                 header('Location: /admin/notFound');
                 exit;
             }
             $userModel->setId($id);

             $user  = [];
             $db    = DB::init()->connect();
             $userModel->readRecordsById();
             $userModel->readUserAddress();
             $userModel->readUserPhones();
             $roles = PrivilegedUser::getUserRoleById($db, $id);
             $model->setData([
                 'profile'  => $userModel->getRecordsById(),
                 'contacts' => $userModel->getUserContacts(),
                 'role'     => $roles,
                 'allRoles' => Role::getRoles($db),
                 'perms'    => Role::getRolePerms($db, $roles['role_id'])->getPermissions(),
             ]);
         }

         $output = $model->render('../views/admin/user/editUser.php', 'admin');
         $fc->setPage($output);
     }

     public function sliderAction() {
         $fc          = FrontController::getInstance();
         $model       = new AdminModel('Слайдер', 'управление слайдами');
         $sliderModel = new SliderTableModel();
         $sliderModel->setTable('slider');

         $page      = $fc->getParams()['page'] ? filter_var($fc->getParams()['page'], FILTER_SANITIZE_NUMBER_INT) : 1;
         $limit     = $fc->getParams()['limit'] ? filter_var($fc->getParams()['limit'], FILTER_SANITIZE_NUMBER_INT) : 10;
         $orderBy   = $fc->getParams()['orderBy'] ? filter_var($fc->getParams()['orderBy'], FILTER_SANITIZE_STRING) : 'id';
         $direction = $fc->getParams()['direction'] ? filter_var($fc->getParams()['direction'], FILTER_SANITIZE_STRING) : 'asc';
         $offset    = $limit * $page - $limit;

         $sliderModel->readAllRecords('*', "ORDER BY $orderBy " . strtoupper($direction) . " LIMIT $limit OFFSET $offset");
         $model->setData([
             'slider'    => $sliderModel->getAllRecords(),
             'limit'     => $limit,
             'orderBy'   => $orderBy,
             'direction' => $direction,
             'page'      => $page,
             'num'       => (new AdminWidgets)->getNum('slider'),
             'offset'    => $offset
         ]);
         $output = $model->render('../views/admin/slider/slider.php', 'admin');
         $fc->setPage($output);
     }

     public function editSlideAction() {
         $fc          = FrontController::getInstance();
         $model       = new AdminModel('Редактирование слайда', 'управление слайдами');
         $sliderModel = new SliderTableModel();

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $sliderModel->setData('slider');
             $sliderModel->updateRecord();
             Session::setMsg('Слайд успешно обновлен', 'success');
             header('Location: /admin/slider');
             exit;
         } else {
             $id = filter_var($fc->getParams()['id'], FILTER_SANITIZE_NUMBER_INT);
             if (!$id) {
                 header('Location: /admin/notFound');
                 exit;
             }
             $sliderModel->setId($id);
             $sliderModel->setTable('slider');
             $sliderModel->readRecordsById();
             $model->setData([
                 'slide' => $sliderModel->getRecordsById()
             ]);
             $output = $model->render('../views/admin/slider/editslide.php', 'admin');
             $fc->setPage($output);
         }
     }

     public function blogAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Блог', 'просмотр всех записей');
         $articleModel = new ArticleTableModel();

         $page      = $fc->getParams()['page'] ? filter_var($fc->getParams()['page'], FILTER_SANITIZE_NUMBER_INT) : 1;
         $limit     = $fc->getParams()['limit'] ? filter_var($fc->getParams()['limit'], FILTER_SANITIZE_NUMBER_INT) : 10;
         $orderBy   = $fc->getParams()['orderBy'] ? filter_var($fc->getParams()['orderBy'], FILTER_SANITIZE_STRING) : 'id';
         $direction = $fc->getParams()['direction'] ? filter_var($fc->getParams()['direction'], FILTER_SANITIZE_STRING) : 'asc';
         $offset    = $limit * $page - $limit;

         $articleModel->setTable('article AS a');
         $articleModel->readAllRecords('a.id, a.title, a.description, a.main_image, a.author, a.created_time, a.updated_time, u.id as user_id, u.username', "INNER JOIN user AS u GROUP BY a.id ORDER BY a.$orderBy " . strtoupper($direction) . " LIMIT $limit OFFSET $offset");

         $model->setData([
             'articles'  => $articleModel->getAllRecords(),
             'limit'     => $limit,
             'orderBy'   => $orderBy,
             'direction' => $direction,
             'page'      => $page,
             'num'       => (new AdminWidgets)->getNum('article'),
             'offset'    => $offset
         ]);
         $output = $model->render('../views/admin/blog/blog.php', 'admin');
         $fc->setPage($output);
     }

     public function addArticleAction() {
         $fc           = FrontController::getInstance();
         $model        = new AdminModel('Блог', 'Новая статья');
         $articleModel = new ArticleTableModel();
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $articleModel->setData();
             $articleModel->addRecord();
             Session::setMsg('Статья успешно добавлена', 'success');
             header('Location: /admin/blog');
             exit;
         } else {
             $output = $model->render('../views/admin/blog/addarticle.php', 'admin');
             $fc->setPage($output);
         }
     }

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

 }
 