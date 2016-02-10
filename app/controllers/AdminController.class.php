<?php

 class AdminController extends AbstractController {
     
     protected function requiredRoles() {
         return [
             'index' => [1,2,3],
             'add' => [1,2,5],
             'newCat' => [1,2],
             'newSubCat' => [1,2]
         ];
     }

     public function indexAction() {
         $fc     = FrontController::getInstance();
         $model  = new ProductTableModel();
         $model->setTable('product');
         $model->readAllRecords();
         $output = $model->render('../views/admin/index.php', 'admin');
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
             $catsAndSub             = [];
             $catsAndSub             = $this->getCatsAndSubCats();
             $model->categoryList    = $catsAndSub['cats']; //used magic __set
             $model->subCategoryList = $catsAndSub['subcats']; //used magic __set
             $output                 = $model->render('../views/admin/add.php', 'admin');
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
 