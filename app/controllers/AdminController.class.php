<?php

 class AdminController implements IController {

     public function indexAction() {
         $fc     = FrontController::getInstance();
         $model  = new AdminTableModel();
         $model->setTable('product');
         $model->readAllRecords();
         $output = $model->render('../views/admin/admin.php');
         $fc->setPage($output);
     }

     public function addAction() {
         $fc    = FrontController::getInstance();
         $model = new AdminTableModel();
         $model->setTable('product');
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $model->setData();
             Helper::moveFile('mainimage');
//             $model->addRecord();
         } else {
             $output = $model->render('../views/admin/add.php');
             $fc->setPage($output);
         }
     }

 }

 