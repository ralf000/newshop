<?php

 namespace app\helpers;

 use app\dataContainers\Product;
 use app\models\ImageTableModel;
 use app\models\ProductTableModel;
 use app\services\Cookie;
 use Exception;

 class Basket {

     static $basket = [];

     static function init() {
         if (!Cookie::has('basket') || !self::get()['id'])
             self::setBucketId();
         if (empty(self::$basket))
             self::$basket = self::get();
         if (!is_array(self::$basket) || count(self::$basket) === 0)
             throw new Exception('Корзина не инициализирована');
     }

     static function get() {
         if (Cookie::has('basket')) {
             $basket = unserialize(Cookie::get('basket'));
             if (is_array($basket))
                 asort($basket);
             return $basket;
         } else {
             return FALSE;
         }
     }

     private static function setBucketId() {
         $basketId     = uniqid('basket_');
         self::$basket = ['id' => $basketId];
         self::set();
     }

     static function set() {
         Cookie::set('basket', serialize(self::$basket));
     }

     static function addProduct(Product $product) {
         try {
             if (empty($product->getId() || $product->getQuantity()))
                 throw new Exception('Объект типа product не инициализирован');
             self::init();
             if (array_key_exists($product->getId(), self::$basket))
                 self::$basket[$product->getId()] = self::$basket[$product->getId()] + $product->getQuantity();
             else
                 self::$basket[$product->getId()] = $product->getQuantity();
             self::set(self::$basket);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     static function redusProduct(Product $product) {
         try {
             if (empty($product->getId() || $product->getQuantity()))
                 throw new Exception('Объект типа product не инициализирован');
             self::init();
             if (array_key_exists($product->getId(), self::$basket))
                 self::$basket[$product->getId()] -= 1;
             if (self::$basket[$product->getId()] === 0)
                 self::deleteProduct($product);
             else
                 self::set();
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     static function deleteProduct(Product $product) {
         try {
             if (empty($product->getId() || $product->getQuantity()))
                 throw new Exception('Объект типа product не инициализирован');
             self::init();
             unset(self::$basket[$product->getId()]);
             self::set();
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     static function cleanBasket() {
         self::init();
         foreach (self::$basket as $id => $quantity) {
             if ($id !== 'id')
                 unset(self::$basket[$id]);
         }
         self::set();
     }

     static function deleteBasket() {
         Cookie::delete('basket');
     }

     static function getProductsFromBasket($image = FALSE) {
         try {
             self::init();
             $products     = [];
             $productModel = new ProductTableModel();
             $productModel->setTable('product as p');
             $imageModel   = new ImageTableModel();
             foreach (self::$basket as $id => $quantity) {
                 if ($id !== 'id' && is_int($id)) {
                     $productModel->setId($id);
                     $product = $productModel->readRecordsById('id', 'p.title, p.price')[0];
                     if ($image) {
                         $imageModel->setId($id);
                         $imageModel->setTable('image');
                         $product['image'] = $imageModel->readRecordsById('product_id', 'image', 'AND main = 1')[0]['image'];
                     }
                     $product['total'] = (int) $product['price'] * $quantity;
                     if (is_array($product)) {
                         $products[$id] = new Product($id, $quantity);
                         $products[$id]->setData($product);
                     }
                 }
             }
             return $products;
         } catch (Exception $ex) {
             Basket::cleanBasket();
             Basket::init();
             header('Location: /');
             exit;
         }
     }

     static function getNumProducts() {
         self::init();
         $total = 0;
         foreach (self::$basket as $key => $item) {
             if ($key !== 'id')
                 $total += $item;
         }
         return $total;
     }
     
     static function getBasketId($serializedList){
         return unserialize($serializedList)['id'];
     }

     static function getProductsList($serializedList) {
         $list = unserialize($serializedList);
         $result = [];
         foreach ($list as $key => $item) {
             if ($key !== 'id') {
                 $model = new ProductTableModel();
                 $model->setTable('product');
                 $model->setId($key);
                 $result[$key] = [
                     'title' => $model->readRecordsById()[0]['title'],
                     'quantity' => $item
                 ];
             }
         }
         return $result;
     }

 }
 