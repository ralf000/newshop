<?php

 namespace app\models;

 class OrderBodyManagerModel extends Model {

     private $orderBody = [];

     public function get($orderId) {
         try {
             if (empty($this->orderBody)) {
                 $st              = $this->db->prepare("SELECT body FROM order_body WHERE id = ?");
                 $st->execute([$orderId]);
                 $this->orderBody = unserialize($st->fetchAll(\PDO::FETCH_ASSOC)[0]['body']);
             }
             return $this->orderBody;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function set(array $orderBody, $orderId) {
         try {
             if (!$orderBody['id'] || empty($orderBody['id']))
                 throw new Exception('Заказ должен содержать идентификатор');
             $st = $this->db->prepare("UPDATE order_body SET body = ? WHERE id = ?");
             $st->execute([serialize($orderBody), $orderId]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function addProduct($orderId, $productId, $quantity = 1) {
         $this->get($orderId);
         if (array_key_exists($productId, $this->orderBody))
             $this->plusProduct($orderId, $productId);
         else
             $this->orderBody[$productId] = $quantity;
         $this->set($this->orderBody, $orderId);
     }

     public function unsetProduct($orderId, $productId) {
         $this->get($orderId);
         if (isset($this->orderBody[$productId])) {
             unset($this->orderBody[$productId]);
             $this->set($this->orderBody, $orderId);
             return TRUE;
         } else {
             return FALSE;
         }
     }

     public function plusProduct($orderId, $productId) {
         $this->get($orderId);
         if (isset($this->orderBody[$productId])) {
             $this->orderBody[$productId] += 1;
             $this->set($this->orderBody, $orderId);
             return TRUE;
         } else {
             return FALSE;
         }
     }

     public function minusProduct($orderId, $productId) {
         $this->get($orderId);
         if (isset($this->orderBody[$productId]) && $this->orderBody[$productId] > 1) {
             $this->orderBody[$productId] -= 1;
             $this->set($this->orderBody, $orderId);
             return TRUE;
         } else {
             return FALSE;
         }
     }

 }
 