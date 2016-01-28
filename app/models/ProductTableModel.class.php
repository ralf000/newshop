<?php

 Class ProductTableModel implements CRUDInterface {

     private $id;
     private $db;
     private $article;

     function __construct(PDO $db, $id = NULL) {
         $this->db = $db;
         $this->id = $id;
         
     }

     public function setId($id) {
         $this->id = $id;
     }

     public function getId() {
         return $this->id;
     }

     public function setArticle(Article $article) {
         $this->article = $article;
     }

     public function readAllRecords() {
         try {
             $query = $this->db->prepare('SELECT * FROM articles');
             $query->execute();
             while ($row   = $query->fetch(PDO::FETCH_ASSOC)) {
                 $result[] = $row;
             }
             return $result;
         } catch (PDOException $e) {
             $e->getMessage();
         }
     }

     public function readOneRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её отображения');
         try {
             $query  = $this->db->prepare('SELECT * FROM articles WHERE `id` = :id');
             $query->execute([':id' => $this->id]);
             return $result = $query->fetch(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             $e->getMessage();
         }
     }

     public function addRecord() {
         try {
             $query = $this->db->prepare("INSERT INTO articles (`title`,`article`, `created`) VALUES (:title, :article, :created)");
             $query->execute([':title' => $this->article->title, ':article' => $this->article->article, ':created' => $this->article->created]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function updateRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её обновления');
         try {
             $query = $this->db->prepare('UPDATE `articles` SET `title` = :title, `article` = :article WHERE `id` = :id');
             $query->execute([':title' => $this->article->title, ':article' => $this->article->article, ':id' => $this->id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function deleteRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её удаления');
         try {
             $query = $this->db->prepare('DELETE FROM articles WHERE id = :id');
             $query->execute([':id' => $this->id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

 }
 