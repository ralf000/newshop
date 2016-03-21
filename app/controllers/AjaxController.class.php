<?php

 namespace app\controllers;

use app\helpers\Helper;
use app\helpers\Path;
use app\helpers\Validate;
use app\models\AddressTableModel;
use app\models\CategoryTableModel;
use app\models\ImageTableModel;
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

         $userId = Validate::validateInputVar('userid', 'INPUT_POST', 'int');
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

         $userId = Validate::validateInputVar('userid', 'INPUT_POST', 'int');
         $number = Validate::validateInputVar('number', 'INPUT_POST', 'int');
         $numtype  = Validate::validateInputVar('numtype', 'INPUT_POST', 'str');
         if (!(empty($number) && $userId)) {
             $model = new PhoneTableModel($userId, [$number], [$numtype]);
             echo $model->addRecord();
         }
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

     public function getProductsBySubcategoryIdAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));
         
         $id = Validate::validateInputVar('id', 'INPUT_GET', 'int');
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
         
         $id = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         $model = new AddressTableModel();
         $model->setId($id);
         $model->setTable('address');
         echo $model->deleteRecord();
     }
     
     public function deleteUserPhoneAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));
         
         $id = Validate::validateInputVar('id', 'INPUT_GET', 'int');
         $model = new PhoneTableModel();
         $model->setId($id);
         $model->setTable('phone');
         echo $model->deleteRecord();
     }

     private function clearAvatarAction() {
         $dir = Path::USERIMG_UPLOAD_DIR . Session::get('user_id');
         Helper::clearDir($dir);
     }

 }
 