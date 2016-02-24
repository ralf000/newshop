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

     public function updateRecord() {}
     
     public function getAllProducts($fields = '*', $condition = '') {
         try {
             $st = $this->db->prepare("SELECT $fields FROM product JOIN category ON product.category_id = category.id JOIN subcategory ON  product.subcategory_id = subcategory.id JOIN image ON product.id = image.product_id $condition");
             $st->execute();
             return $this->allRecords = $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
     
     public function updateProduct() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её отображения');
         try {
             $st = $this->db->prepare("UPDATE $this->table SET `category_id` = :cat, `subcategory_id` = :subcat, `title` = :title, `description` = :description, `spec` = :spec, `price` = :price, `quantity` = quantity, `published` = :published;");
             $st->execute([
                 ':title'       => $this->title,
                 ':description' => $this->description,
                 ':spec'        => $this->spec,
                 ':price'       => $this->price,
                 ':quantity'    => $this->quantity,
                 ':published'   => $this->published,
                 ':subcat'      => $this->subcat,
                 ':cat'         => $this->cat,
             ]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         $method            = 'INPUT_POST';
         $this->cat         = Validate::validateInputVar('cat', $method);
         $this->subcat      = Validate::validateInputVar('subcat', $method);
         $this->title       = Validate::validateInputVar('title', $method, 'str');
         $this->description = Validate::validateInputVar('desc', $method, 'html');
         $this->spec        = Validate::validateInputVar('spec', $method, 'html');
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
 