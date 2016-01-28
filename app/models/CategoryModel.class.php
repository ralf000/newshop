<?php

class CategoryModel extends TableModelAbstract{
    
    private $category_name, $published;


    public function addRecord() {
         try {
             $query = $this->db->prepare("INSERT INTO $this->table (`category_name`,`published`) VALUES (:category_name, :published)");
             $query->execute([':category_name' => $this->category_name, ':published' => $this->published]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function updateRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её обновления');
         try {
             $query = $this->db->prepare("UPDATE $this->table SET `category_name` = :category_name, `published` = :published WHERE `id` = :id");
             $query->execute([':category_name' => $this->category_name, ':published' => $this->published, ':id' => $this->id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }
 }

