<?php

 namespace app\controllers;

use app\dataContainers\Product;
use app\helpers\Basket;
use app\helpers\Helper;
use app\helpers\Path;
use app\helpers\User;
use app\helpers\Validate;
use app\models\AddressTableModel;
use app\models\ArticleTableModel;
use app\models\CategoryTableModel;
use app\models\ImageTableModel;
use app\models\OrderTableModel;
use app\models\PhoneTableModel;
use app\models\ProductTableModel;
use app\models\SliderTableModel;
use app\models\SubCategoryTableModel;
use app\models\UserTableModel;
use app\models\UserUpdateTableModel;
use app\services\DB;
use app\services\Role;
use app\services\Session;
use app\services\UploadHandler;
use Exception;

 class AjaxController extends AbstractController {

     protected function requiredRoles() {
         return [
             'SearchProduct' => [1,2,3],
             'addCategory' => [1,2],
             'addSubCategory' => [1,2],
             'addProduct' => [1,2],
             'addUserAddress' => [1],
             'addUserPhone' => [1],
             'changePhoto' => [1,2,3],
             'deleteArticle' => [1,2,3],
             'deleteCategory' => [1,2],
             'deleteImage' => [1,2],
             'deleteProduct' => [1,2],
             'deleteProductFromOrder' => [1,2],
             'deleteProducts' => [1,2],
             'deleteSlide' => [1,2],
             'deleteSubCategory' => [1,2],
             'deleteUser' => [1],
             'deleteUserAddress' => [1],
             'deleteUserPhone' => [1],
             'deleteCategories' => [1,2],
             'getOrderStatus' => [1,2,3],
             'getPermsByRoleId' => [1,2,3],
             'getUserAddresses' => [1,2,3],
             'getUserPhones' => [1,2,3],
             'setDeliveryType' => [1,2],
             'setOrderStatus' => [1,2],
             'setPopularOrRecommended' => [1,2]
         ];
     }

     public function addCategoryAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $model = new AdminController();
         $model->newCatAction();
         $this->getCategoriesAction();
     }

     public function addSubCategoryAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $model = new AdminController();
         $model->newSubCatAction();
         $this->getSubCategoriesAction();
     }

     public function addUserAddressAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $userId  = Validate::validateInputVar('userid', 'INPUT_POST', 'int');
         $address = Validate::validateInputVar('address', 'INPUT_POST', 'str');
         $postal  = Validate::validateInputVar('postal', 'INPUT_POST', 'str');
         if (!(empty($address) && $userId)) {
             $model = new AddressTableModel($userId, [$address], [$postal]);
             echo $model->addRecord();
         }
     }

     public function addUserPhoneAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $userId  = Validate::validateInputVar('userid', 'INPUT_POST', 'int');
         $number  = Validate::validateInputVar('number', 'INPUT_POST', 'int');
         $numtype = Validate::validateInputVar('numtype', 'INPUT_POST', 'str');
         if (!(empty($number) && $userId)) {
             $model = new PhoneTableModel($userId, [$number], [$numtype]);
             echo $model->addRecord();
         }
     }

     public function addToBasketAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         if (empty($id))
             die('Не задан id товара');
         Basket::addProduct(new Product($id));
     }
     
     public function addProductInOrderAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $orderId = Validate::validateInputVar('orderId', 'INPUT_GET', 'int');
         $productId = Validate::validateInputVar('productId', 'INPUT_GET', 'int');
         if (empty($orderId) || empty($productId))
             die('Не задан id');

         $orderBodyManager = (new OrderTableModel())->getOrderBodyManager();
         echo $orderBodyManager->addProduct($orderId, $productId);
     }

     public function getCategoriesAction() {
         // Передаем заголовки
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $model = new CategoryTableModel();
         $model->setTable('category');
         $model->readAllRecords();
         echo json_encode($model->getAllRecords());
     }

     public function getSubCategoriesAction() {
         // Передаем заголовки
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $catId = Validate::validateInputVar('catid', 'INPUT_GET', 'int');

         $model = new SubCategoryTableModel();
         $model->setTable('subcategory');
         $model->setId($catId);
         $model->readRecordsById('category_id');
         echo json_encode($model->getRecordsById());
     }

//     public function getPhonesTypesAction() {
//         // Передаем заголовки
//         header('Content-type: application/json; charset=utf-8');
//         header('Cache-Control: no-store, no-cache');
//         header('Expires: ' . date('r'));
//
//         $model = new PhoneTableModel();
//         $model->setTable('phone');
//         $model->readAllRecords();
//         echo json_encode($model->getAllRecords());
//     }

     public function getImagesForProductAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id'))
             $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
         else
             return FALSE;

         $model = new ImageTableModel();
         $model->setTable('image');
         $model->setId($id);
         $model->readRecordsById();
         echo json_encode($model->getRecordsById());
     }

     public function getPermsByRoleIdAction() {
         header('Content-type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id'))
             $id    = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
         else
             throw new Exception('Не удалось получить id роли');
         $perms = Role::getRolePerms(DB::init()->connect(), $id)->getPermissions();
         echo json_encode($perms);
     }

     public function getOrderStatusListAction() {
         header('Content-type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $model = new OrderTableModel();
         $list  = $model->getOrderStatusList();

         echo json_encode($list);
     }
     
     public function getDeliveryTypesAction() {
         header('Content-type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $model = new OrderTableModel();
         $list  = $model->getDeliveryTypes();

         echo json_encode($list);
     }

     public function deleteCategoryAction($id = NULL) {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id = Validate::validateInputVar('catid', 'INPUT_GET', 'int');

         $this->deleteSubCategoryAction('category_id', $id);

         $model = new CategoryTableModel();
         $model->setTable('category');
         $model->setId($id);
         if ($model->deleteRecord())
             $this->getCategoriesAction();
     }

     public function getUserAddressesAction() {
         header('Content-type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id = Validate::validateInputVar('id', 'INPUT_GET', 'int');

         $model = new UserTableModel();
         $model->setId($id);
         echo json_encode($model->readUserAddress());
     }

     public function getUserPhonesAction() {
         header('Content-type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id = Validate::validateInputVar('id', 'INPUT_GET', 'int');

         $model = new UserTableModel();
         $model->setId($id);
         echo json_encode($model->readUserPhones());
     }

     public function deleteSubCategoryAction($field = 'category_id', $id = NULL) {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (isset($_GET['subcatid']) && !empty($_GET['subcatid'])) {
             $id    = Validate::validateInputVar('subcatid', 'INPUT_GET', 'int');
             $this->deleteProductsAction('subcategory_id', $id);
             $field = 'id';
         } else {
             $this->deleteProductsAction($field = 'category_id', $id);
         }

         $model = new SubCategoryTableModel();
         $model->setTable('subcategory');
         $model->setId($id);
         if ($model->deleteRecord($field))
             return TRUE;
     }

     public function deleteProductsAction($field = 'category_id', $id = NULL) {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $model = new ProductTableModel();
         $model->setTable('product');
         $model->setId($id);
         if ($model->deleteRecord($field))
             return TRUE;
     }

     public function deleteProductAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_POST, 'id'))
             $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

         $model = new ProductTableModel();
         $model->setId($id);
         echo $model->deleteProduct();
     }

     public function deleteSlideAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_POST, 'id'))
             $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

         $model = new SliderTableModel();
         $model->setId($id);
         $model->setTable('slider');
         $model->deleteRecord();
         echo Helper::deleteDir($id, 'slider');
     }

     public function deleteImageAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id') && filter_has_var(INPUT_GET, 'image')) {
             $id    = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
             $image = json_decode(filter_input(INPUT_GET, 'image'));
         } else {
             return FALSE;
         }
         $model = new ImageTableModel();
         $model->setId($id);
         $model->setTable('image');
         $model->deleteRecord();
         Helper::deleteFile($image);
         echo TRUE;
     }

     public function changePhotoAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));
         $this->clearAvatarAction();

         $model  = new UserUpdateTableModel();
         $model->setTable('user');
         $userId = Session::get('user_id');
         $model->setId($userId);
         $model->setPath(Path::USERIMG_UPLOAD_DIR);
         $model->setPhoto($_FILES['files']['name'][0]);
         $model->updateAvatar();

         $upload_handler = new UploadHandler([
             'upload_dir'          => Path::USERIMG_UPLOAD_DIR,
             'max_number_of_files' => 1,
             'user_dirs'           => true,
             'isAvatar'            => true,
         ]);
     }

     public function getProductsFromBasketAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $mode = FALSE;
         if (filter_has_var(INPUT_GET, 'mode'))
             $mode = (bool) filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_NUMBER_INT);

         echo json_encode(Basket::getProductsFromBasket($mode));
     }

     public function getProductsBySubcategoryIdAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id    = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         $model = new ProductTableModel();
         $model->setTable('product AS p, image AS i');
         $model->setId($id);
         echo json_encode($model->readRecordsById('subcategory_id', '*', 'AND i.product_id IN (p.id) AND i.main =1 LIMIT 4'));
     }

     public function getProductsByNumAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));
         $limit = Validate::validateInputVar('limit', 'INPUT_GET', 'FILTER_SANITIZE_NUMBER_INT');
         header('Location: /admin/allProducts/limit/' . $limit);
         exit;
     }

     public function getNumProductsFromBasketAction() {
         header('Content-Type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         echo Basket::getNumProducts();
     }

     public function deleteUserAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id'))
             $id        = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
         if (!$id)
             throw new Exception('не задан id пользователя для удаления!');
         $userModel = new UserTableModel;
         $userModel->deleteUser($id);
         echo TRUE;
     }

     public function deleteUserAddressAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id    = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         $model = new AddressTableModel();
         $model->setId($id);
         $model->setTable('address');
         echo $model->deleteRecord();
     }

     public function deleteUserPhoneAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id    = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         $model = new PhoneTableModel();
         $model->setId($id);
         $model->setTable('phone');
         echo $model->deleteRecord();
     }

     public function deleteArticleAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_POST, 'id'))
             $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

         $model = new ArticleTableModel();
         $model->setId($id);
         $model->setTable('article');
         echo $model->deleteRecord();
     }

     public function deleteProductFromBasketAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id'))
             $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

         echo Basket::deleteProduct(new Product($id));
     }
     
     public function deleteProductFromOrderAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $orderId   = Validate::validateInputVar('orderId', 'INPUT_GET', 'int');
         $productId = Validate::validateInputVar('productId', 'INPUT_GET', 'int');
         if (empty($orderId) || empty($productId))
             die('Не задан id');

         $orderBodyManager = (new OrderTableModel())->getOrderBodyManager();
         echo $orderBodyManager->unsetProduct($orderId, $productId);
     }
     
     public function plusProductFromOrderAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $orderId   = Validate::validateInputVar('orderId', 'INPUT_GET', 'int');
         $productId = Validate::validateInputVar('productId', 'INPUT_GET', 'int');
         if (empty($orderId) || empty($productId))
             die('Не задан id');

         $orderBodyManager = (new OrderTableModel())->getOrderBodyManager();
         echo $orderBodyManager->plusProduct($orderId, $productId);
     }
     
     public function minusProductFromOrderAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $orderId   = Validate::validateInputVar('orderId', 'INPUT_GET', 'int');
         $productId = Validate::validateInputVar('productId', 'INPUT_GET', 'int');
         if (empty($orderId) || empty($productId))
             die('Не задан id');

         $orderBodyManager = (new OrderTableModel())->getOrderBodyManager();
         echo $orderBodyManager->minusProduct($orderId, $productId);
     }

     public function incrementProductFromBasketAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id'))
             $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

         echo Basket::addProduct(new Product($id));
     }

     public function reduseProductFromBasketAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         if (filter_has_var(INPUT_GET, 'id'))
             $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

         echo Basket::redusProduct(new Product($id));
     }

     public function cleanBasketAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         echo Basket::cleanBasket();
     }

     public function checkUserAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         echo User::checkUser();
     }

     public function setUserMsgAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $msg = Validate::validateInputVar('msg', 'INPUT_GET', 'str');

         if ($msg)
             Session::setMsg($msg);
         else
             echo FALSE;
     }

     public function setOrderStatusAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $orderId  = Validate::validateInputVar('orderId', 'INPUT_GET', 'int');
         $statusId = Validate::validateInputVar('statusId', 'INPUT_GET', 'int');
         
         if (!$orderId || !$statusId)
             throw new Exception('Неверный id для смены статуса заказа');

         $model = new OrderTableModel();
         echo $model->setOrderStatus($orderId, $statusId);
     }
     
     public function setDeliveryTypeAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $orderId  = Validate::validateInputVar('orderId', 'INPUT_GET', 'int');
         $typeId = Validate::validateInputVar('typeId', 'INPUT_GET', 'int');
         
         if (!$orderId || !$typeId)
             throw new Exception('Неверный id для смены типа доставки');

         $model = new OrderTableModel();
         echo $model->setDeliveryType($orderId, $typeId);
     }
     
     public function setPopularOrRecommendedAction() {
         header('Content-type: text/plain; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));

         $id  = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         $type = Validate::validateInputVar('type', 'INPUT_GET', 'str');
         $mode = Validate::validateInputVar('mode', 'INPUT_GET', 'int');
         
         if (!$id)
             throw new Exception('Неверный id товара');

         $model = new ProductTableModel();
         $model->setId($id);
         echo $model->setPopularOrRecommended($type, $mode);
     }
     
     public function SearchProductAction() {
         header('Content-type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));
         
         $text = Validate::validateInputVar('text', 'INPUT_GET', 'str');
         $model = new ProductTableModel();
         $model->setTable('product');
         $model->readAllRecords('id, title', "WHERE title LIKE '%{$text}%'");
         echo json_encode($model->getAllRecords());
     }

//     public function sessionGetAction() {
//         header('Content-type: text/plain; charset=utf-8');
//         header('Cache-Control: no-store, no-cache');
//         header('Expires: ' . date('r'));
//         
//         if (filter_has_var(INPUT_POST, 'key') && filter_has_var(INPUT_POST, 'value'))
//             $key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
//             $value = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_STRING);
//             
////             echo Session::set($key, $value);
//             echo $key;
//             echo $value;
//     }

     private function clearAvatarAction() {
         $dir = Path::USERIMG_UPLOAD_DIR . Session::get('user_id');
         Helper::clearDir($dir);
     }

 }
 