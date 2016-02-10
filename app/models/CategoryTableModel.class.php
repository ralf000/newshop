<?php

 class CategoryTableModel extends TableModelAbstract {

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

     public function setData($formType = '', $method = '') {
         $newCat              = Validate::validateInputVar('newcat', 'INPUT_POST', 'str');
         if (Validate::validateValue($this->db, $this->table, 'category_name', $newCat))
             $this->category_name = $newCat;
         $this->published     = Validate::validateInputVar('published', 'INPUT_POST', 'int');
         if (empty($this->published))
             $this->published     = 1;
         return (!$this->category_name) ? FALSE : TRUE;
     }

 }
 