<?php
 
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

         $model  = new UserTableModel();
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

     public function mainImageAction() {
         
     }

     public function getProductsByNumAction() {
         header('Content-Type: application/json; charset=utf-8');
         header('Cache-Control: no-store, no-cache');
         header('Expires: ' . date('r'));
         $limit = Validate::validateInputVar('limit', 'INPUT_GET', 'FILTER_SANITIZE_NUMBER_INT');
         header('Location: /admin/allProducts/limit/' . $limit);
         exit;
     }

     private function clearAvatarAction() {
         $dir = Path::USERIMG_UPLOAD_DIR . Session::get('user_id');
         Helper::clearDir($dir);
     }

 }
 