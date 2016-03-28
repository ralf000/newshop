<?php

 namespace app\helpers;

 use app\dataContainers\Product;
 use app\services\Cookie;
 use Exception;

 class Basket {

     static function init() {
         if (!Cookie::has('basket')) {
             $basketId = uniqid('basket_');
             $basket   = ['id' => $basketId];
             self::set($basket);
         }
     }

     static function get() {
         if (Cookie::has('basket')) {
             return unserialize(Cookie::get('basket'));
         } else {
             return FALSE;
         }
     }

     static function set(array $basket, $time = 3600 * 24 * 7 * 12) {
         Cookie::set('basket', serialize($basket), time() + $time);
     }

     static function addProduct(Product $product) {
         try {
             if (empty($product->getId() || $product->getQuantity()))
                 throw new Exception('Объект типа product не инициализирован');
             if (!Cookie::has('basket'))
                 self::init();
             $basket                    = self::get();
             if (array_key_exists($product->getId(), $basket))
             $basket[$product->getId()] = $basket[$product->getId()] + $product->getQuantity();
             self::set($basket);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

 }
 