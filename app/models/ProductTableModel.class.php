<?php

 class ProductTableModel extends TableModelAbstract {

     private $cat, $subcat, $title, $description, $spec, $price, $quantity, $published, $lastId;

     public function addRecord() {
         try {
             $query = $this->db->prepare("INSERT INTO $this->table (`category_id`, `subcategory_id`, `title`, `description`, `spec`, `price`, `quantity`, `published`, created_time) VALUES (:cat, :subcat, :title, :description, :spec, :price, :quantity, :published, :created_time)");
             $query->execute([
                 ':title'       => $this->title,
                 ':description' => $this->description,
                 ':spec'        => $this->spec,
                 ':price'       => $this->price,
                 ':quantity'    => $this->quantity,
                 ':published'   => $this->published,
                 ':subcat'      => $this->subcat,
                 ':cat'         => $this->cat,
                 ':created_time' => date('Y-m-d H:i:s')
             ]);
             $this->lastId = $this->db->lastInsertId();
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function updateRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её обновления');
         try {
             $query = $this->db->prepare("UPDATE $this->table SET `title` = :title, `article` = :article WHERE `id` = :id");
             $query->execute([':table' => $this->table, ':title' => $this->article->title, ':article' => $this->article->article, ':id' => $this->id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function setData($formType = '', $method = '') {
         $method            = 'INPUT_POST';
         $this->cat         = Validate::validateInputVar('cat', $method);
         $this->subcat      = Validate::validateInputVar('subcat', $method);
         $this->title       = Validate::validateInputVar('title', $method, 'str');
         $this->description = Validate::validateInputVar('desc', $method);
         $this->spec        = Validate::validateInputVar('spec', $method);
         $this->price       = Validate::validateInputVar('price', $method, 'int');
         $this->quantity    = Validate::validateInputVar('quant', $method, 'int');
         $this->published   = Validate::validateInputVar('published', $method, 'int');
         if (empty($this->published))
             $this->published   = 0;
     }
     
     function getLastId() {
         return $this->lastId;
     }

 }
 