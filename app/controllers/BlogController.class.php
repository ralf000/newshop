<?php

 namespace app\controllers;

 use app\models\ArticleTableModel;
 use app\models\FrontModel;
 use app\models\UserTableModel;

 class BlogController extends AbstractController {

     protected function requiredRoles() {
         
     }

     function indexAction() {
         $fc           = FrontController::getInstance();
         $model        = new FrontModel;
         $articleModel = new ArticleTableModel();
         $articleModel->setTable('article');
         $articleModel->readAllRecords();
         $articles     = $articleModel->getAllRecords();

         $userModel = new UserTableModel();
         $userModel->setTable('user');
         foreach ($articles as $key => $a) {
             $userModel->setId([$a['author']]);
             $articles[$key]['author_name'] = $userModel->readRecordsById('id', 'id, username')[0]['username'];
         }
         $model->setData([
             'articles' => $articles,
         ]);
         $output = $model->render('../views/blog/blog.php', 'withoutSlider');
         $fc->setPage($output);
     }
     
     public function viewAction() {
         $fc           = FrontController::getInstance();
         $model        = new FrontModel();
         $articleModel = new ArticleTableModel();
         $userModel    = new UserTableModel;
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
             'author'  => $userModel->readRecordsById('id', 'id, username')
         ]);
         $output = $model->render('../views/blog/view.php', 'withoutSlider');
         $fc->setPage($output);
     }

 }
 