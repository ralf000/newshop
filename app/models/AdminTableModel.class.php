<?php

 class AdminTableModel extends TableModelAbstract {

     public $cat, $subcat, $title, $description, $spec, $price, $quantity, $published, $mainImage, $images;

     public function addRecord() {
         try {
             $query = $this->db->prepare("INSERT INTO $this->table (`cat`, `subcat`, `title`, `description`, `spec`, `price`, `quantity`, `published`, ) VALUES (:cat, :subcat, :title, :description, :spec, :price, :quantity, :published)");
             $query->execute([
                 ':cat'       => $this->cat,
                 ':subcat'       => $this->subcat,
                 ':title'       => $this->title,
                 ':description' => $this->description,
                 ':spec'        => $this->spec,
                 ':price'       => $this->price,
                 ':quantity'    => $this->quantity,
                 ':published'   => $this->published
             ]);
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

     public function setData() {
         $method            = 'INPUT_POST';
         $int               = 'FILTER_SANITIZE_NUMBER_INT';
         $str               = 'FILTER_SANITIZE_STRING';
         $this->cat         = Validate::validateVar('cat', $method);
         $this->subcat      = Validate::validateVar('subcat', $method);
         $this->title       = Validate::validateVar('title', $method, $str);
         $this->description = Validate::validateVar('description', $method);
         $this->spec        = Validate::validateVar('spec', $method);
         $this->price       = Validate::validateVar('price', $method, $int);
         $this->quantity    = Validate::validateVar('quantity', $method, $int);
         $this->published   = Validate::validateVar('published', $method, $int);
         if (empty($this->published))
             $this->published   = 0;
     }

 }
 