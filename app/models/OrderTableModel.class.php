<?php
 
  namespace app\models;

use Exception;

 class OrderTableModel extends TableModelAbstract {

     private $order, $note, $statusId, $userId;
     //array product id => products quantity
     private $products = [];
     //array product id => products quantity
     private $productId = [];

     public function addRecord() {
         try {
             $st       = $this->db->prepare("INSERT INTO $this->table (`note`, `status_id`, `user_id`) VALUES (?, ?, ?)");
             $st->execute([$this->note, $this->statusId = 1, $this->userId]);
             $this->id = intval($this->db->lastInsertId());
             foreach ($this->products as $product => $quantity) {
                 $st = $this->db->prepare("INSERT INTO order_content (`order_id`, `product_id`, `product_quantity`) VALUES ?, ?, ?");
                 $st->execute([$this->id, $product, $quantity]);
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function addToOrder() {
         if (!$this->id || !$this->productId)
             throw new Exception('Не задан id заказа или товара');
         try {
             $st = $this->db->prepare("INSERT INTO order_content (`order_id`, `product_id`, `product_quantity`) VALUES ?, ?, ?");
             $st->execute([$this->id, key($this->productId), current($this->productId)]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         if (!$this->id)
             throw new Exception('Не задан id заказа');
         $this->readRecordsById()[0];
         if (!$this->content && $this->recordsById['content'])
             $this->content  = $this->recordsById['content'];
         if (!$this->statusId && $this->recordsById['status_id'])
             $this->statusId = $this->recordsById['status_id'];
         try {
             $st = $this->db->prepare("UPDATE SET $this->table SET `content` = ?, `status_id` = ? WHERE id = ?");
             $st->execute([$this->content, $this->statusId, $this->id]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function deleteOrder() {
         if (!$this->id)
             throw new Exception('Не задан id заказа');
         try {
             $st = $this->db->prepare("DELETE FROM $this->table INNER JOIN order_content ON $this->table.id = order_content.order_id WHERE $this->table.id = ?");
             $st->execute([$this->id]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function deleteFromOrder() {
         if (!$this->id || !$this->productId)
             throw new Exception('Не задан id заказа или товара');
         try {
             $st = $this->db->prepare("DELETE FROM order_content WHERE order_id = ? AND product_id = ?");
             $st->execute([$this->id, key($this->productId)]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         
     }

     public function setProductId($id) {
         $this->productId = intval($id);
     }

     public function getProductId() {
         return $this->productId;
     }

 }
 