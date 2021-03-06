<?php

 namespace app\models;

 use app\helpers\Helper;
 use app\helpers\Validate;
 use Exception;
 use PDO;
 use PDOException;

 class ProductTableModel extends TableModelAbstract {

     private $cat, $subcat, $title, $description, $spec, $brand, $color, $price, $quantity, $published, $lastId;

     public function addRecord() {
         try {
             $this->setUserIdForDB();
             $query        = $this->db->prepare("INSERT INTO $this->table (`category_id`, `subcategory_id`, `title`, `description`, `spec`, `brand`, `color`, `price`, `quantity`, `published`, created_time) VALUES (:cat, :subcat, :title, :description, :spec, :brand, :color, :price, :quantity, :published, :created_time)");
             $query->execute([
                 ':title'        => $this->title,
                 ':description'  => $this->description,
                 ':spec'         => $this->spec,
                 ':brand'        => $this->brand,
                 ':color'        => $this->color,
                 ':price'        => $this->price,
                 ':quantity'     => $this->quantity,
                 ':published'    => $this->published,
                 ':subcat'       => $this->subcat,
                 ':cat'          => $this->cat,
                 ':created_time' => date('Y-m-d H:i:s')
             ]);
             $this->lastId = $this->db->lastInsertId();
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     public function updateRecord() {
         
     }

     public function getAllProducts($fields = '*', $condition = '') {
         try {
             $st               = $this->db->prepare("SELECT $fields FROM product JOIN category ON product.category_id = category.id JOIN subcategory ON  product.subcategory_id = subcategory.id JOIN image ON product.id = image.product_id $condition");
             $st->execute();
             return $this->allRecords = $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateProduct() {
         try {
             $this->setUserIdForDB();
             $st = $this->db->prepare("UPDATE $this->table SET `category_id` = :cat, `subcategory_id` = :subcat, `title` = :title, `description` = :description, `spec` = :spec, `brand` = :brand, `color` = :color, `price` = :price, `quantity` = :quantity, `published` = :published WHERE `id` = :id");
             $st->execute([
                 ':cat'         => $this->cat,
                 ':subcat'      => $this->subcat,
                 ':title'       => $this->title,
                 ':description' => $this->description,
                 ':spec'        => $this->spec,
                 ':brand'       => $this->brand,
                 ':color'       => $this->color,
                 ':price'       => $this->price,
                 ':quantity'    => $this->quantity,
                 ':published'   => $this->published,
                 ':id'          => $this->id
             ]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setPopularOrRecommended($field, $value) {
         if (empty($this->id))
             throw new Exception('Не задан id товара для удаления');
         try {
             $st = $this->db->prepare("UPDATE product SET $field = ? WHERE id = ?");
             $st->execute([$value, $this->id]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function deleteProduct() {
         try {
             if (empty($this->id))
                 throw new Exception('Не задан id товара для удаления');
             $this->setUserIdForDB();
             $st = $this->db->prepare("DELETE FROM image WHERE product_id = ?");
             $st->execute([$this->id]);
             $st = $this->db->prepare("DELETE FROM product WHERE id = ?");
             $st->execute([$this->id]);
             Helper::deleteDir($this->id);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function getBrandsOrColors($field) {
         try {
             $fieldMap = ['brand', 'color'];
             if (!in_array($field, $fieldMap))
                 throw new \Exception('Недопустимое поле');
             $fetch   = $this->db->query("SELECT DISTINCT $field FROM product")->fetchAll(\PDO::FETCH_ASSOC);
             if (!empty($fetch) && is_array($fetch)) {
                 foreach ($fetch as $item) {
                     $st                  = $this->db->prepare("SELECT COUNT(*) as num FROM product WHERE $field = ?");
                     $st->execute([$item[$field]]);
                     $result[$item[$field]] = $st->fetchAll(\PDO::FETCH_ASSOC)[0];
                 }
                 return $result;
             }
             return NULL;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         $method            = 'INPUT_POST';
         $this->cat         = Validate::validateInputVar('cat', $method, 'int');
         $this->subcat      = Validate::validateInputVar('subcat', $method, 'int');
         $this->title       = Validate::validateInputVar('title', $method, 'str');
         $this->description = Validate::validateInputVar('desc', $method, 'html');
         $this->spec        = Validate::validateInputVar('spec', $method, 'html');
         $this->setBrand(Validate::validateInputVar('brand', $method, 'str'));
         $this->setColor(Validate::validateInputVar('color', $method, 'str'));
         $this->price       = Validate::validateInputVar('price', $method, 'int');
         $this->quantity    = Validate::validateInputVar('quant', $method, 'int');
         $this->published   = Validate::validateInputVar('published', $method, 'int');
         $this->id          = Validate::validateInputVar('product_id', $method, 'int');
         if (empty($this->published))
             $this->published   = 0;
     }

     public function getHistory() {
         if (empty($this->id))
             throw new Exception('Не задан id товара');
         try {
             $st = $this->db->prepare('SELECT * FROM product_history WHERE product_id = ?');
             $st->execute([$this->id]);
             return $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     function getLastId() {
         return $this->lastId;
     }

     function setBrand($brand) {
         $brand       = Helper::mb_ucfirst(mb_strtolower($brand));
         $brand       = str_replace('ё', 'е', $brand);
         $this->brand = $brand;
     }

     function setColor($color) {
         $color       = Helper::mb_ucfirst(mb_strtolower($color));
         $color       = str_replace('ё', 'е', $color);
         $this->color = $color;
     }

 }
 