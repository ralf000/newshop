<?php

 class ImageTableModel extends TableModelAbstract {

     public $productId, $mainImage, $images, $path;

     public function __construct($lastInsertId = '') {
         parent::__construct();
         $this->productId = $lastInsertId;
         $this->path      = Path::IMG_UPLOAD_DIR . $this->productId . '/';
     }

     public function addRecord() {
         
     }

     private function addImage($image, $primary = FALSE) {
         if (empty($this->productId))
             throw new Exception('Не задан id связанного товара');
//         $primary = $primary ? 1 : 0;
         $st      = $this->db->prepare("INSERT INTO $this->table (`image`, `main`,`product_id`) VALUES (:image, :main, :product_id)");
         $st->execute([':image' => $image, ':main' => $primary, ':product_id' => $this->productId]);
     }

     function updateRecord() {
         
     }

     function setData($formType = '', $method = '') {
         $this->mainImage = $_FILES['mainimage']['name'];
         $this->images    = $_FILES['images']['name'];
     }

     function addAllImages() {
         if (!empty($this->mainImage)) {
             $this->addImage($this->path .'main_' . Helper::strToLat($this->mainImage), TRUE);
             Helper::moveFile('mainimage', TRUE, $this->productId);
         }
         if (!empty($this->images[0]) && is_array($this->images)) {
             foreach ($this->images as $img) {
                 $this->addImage($this->path . Helper::strToLat($img), FALSE);
             }
             Helper::moveFile('images', FALSE, $this->productId);
         }
     }

 }
 