<?php

 class AjaxController extends AbstractController {
     
     protected function requiredRoles() {}

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
             return TRUE;
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

 }
 