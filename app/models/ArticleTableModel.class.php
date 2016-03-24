<?php

 namespace app\models;

 use app\dataContainers\Article;
 use app\helpers\Validate;
 use Exception;

 class ArticleTableModel extends TableModelAbstract {

     private $article;

     public function addRecord() {
         try {
             if (!is_object($this->article) && empty($this->article->getData()))
                 throw new Exception('Не корректная статья');
             $st = $this->db->prepare("INSERT INTO article (title, description, main_image, content, author, created_time, updated_time) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
             $st->execute([
                 $this->article->getData()['title'],
                 $this->article->getData()['description'],
                 $this->article->getData()['mainimage'],
                 $this->article->getData()['content'],
                 $this->article->getData()['author']
             ]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         try {
             if (!is_object($this->article) && empty($this->article))
                 throw new Exception('Не корректная статья');
             $st = $this->db->prepare("UPDATE article SET title = ?, description = ?, main_image = ?, content =?, author = ?, updated_time = NOW()");
             $st->execute([
                 $this->article->getData()['title'],
                 $this->article->getData()['description'],
                 $this->article->getData()['mainimage'],
                 $this->article->getData()['content'],
                 $this->article->getData()['author']
             ]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         $arr = [];
         foreach ($_POST as $key => $val) {
             $arr[$key] = ($key === 'content') ? Validate::validateInputVar($key, 'INPUT_POST', 'html') : Validate::validateInputVar($key, 'INPUT_POST', 'str');
         }
         $this->article = new Article($arr);
     }

 }
 