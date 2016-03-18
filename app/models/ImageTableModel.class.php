<?php
 
  namespace app\models;

use app\helpers\Generator;
use app\helpers\Helper;
use app\helpers\Path;
use Exception;

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
         if (strstr($image, 'main_'))
             $this->mainImageChecker($image);
         try {
             $st = $this->db->prepare("INSERT INTO $this->table (`image`, `main`,`product_id`) VALUES (:image, :main, :product_id)");
             $st->execute([':image' => $image, ':main' => $primary, ':product_id' => $this->productId]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     private function mainImageChecker($image) {
         if (is_dir($this->path) && strstr(implode('', scandir($this->path)), 'main_')) {
             foreach (scandir($this->path) as $file) {
                 if (strstr($file, 'main_')) {
                     unlink(str_replace('//', '/', $this->path . $file)) or die('Не могу удалить изображение');
                     $this->deleteRecord('product_id', 'AND main = 1');
                     return TRUE;
                 }
             }
         }
     }

     function updateRecord() {
         
     }

     function setData($formType = '', $method = '') {
         $this->mainImage = $_FILES['mainimage']['name'];
         $this->images    = $_FILES['images']['name'];
         if (filter_has_var(INPUT_POST, 'product_id'))
             $this->productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
     }

     function addAllImages() {
         if (!empty($this->mainImage)) {
             $mImage = str_replace('//', '/', $this->path . 'main_' . Generator::strToLat($this->mainImage));
             $this->addImage($mImage, TRUE);
             Helper::moveFile('mainimage', TRUE, $this->productId);
         }
         if (!empty($this->images[0]) && is_array($this->images)) {
             foreach ($this->images as $img) {
                 $image = str_replace('//', '/', $this->path . Generator::strToLat($img));
                 $this->addImage($image, FALSE);
             }
             Helper::moveFile('images', FALSE, $this->productId);
         }
     }

 }
 