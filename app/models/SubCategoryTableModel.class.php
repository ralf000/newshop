<?php

 class SubCategoryTableModel extends TableModelAbstract {

     private $subCategory_name, $published, $category_id;

     public function addRecord() {
         try {
             $query = $this->db->prepare("INSERT INTO $this->table (`subcategory_name`,`published`, `category_id`) VALUES (:subcategory_name, :published, :category_id)");
             $query->execute([':subcategory_name' => $this->subCategory_name, ':published' => $this->published, ':category_id' => $this->category_id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function updateRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её обновления');
         try {
             $query = $this->db->prepare("UPDATE $this->table SET `subcategory_name` = :subcategory_name, `published` = :published WHERE `id` = :id");
             $query->execute([':subcategory_name' => $this->subCategory_name, ':published' => $this->published, ':id' => $this->id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function setData($formType = '', $method = '') {
         $this->subCategory_name = Validate::validateInputVar('newsubcat', 'INPUT_POST', 'str');
         $this->published        = Validate::validateInputVar('published', 'INPUT_POST', 'int');
         $this->category_id      = Validate::validateInputVar('categoryid', 'INPUT_POST', 'int');
         if (empty($this->published))
             $this->published        = 1;
     }

 }
 