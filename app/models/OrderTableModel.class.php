<?php

 class OrderTableModel extends TableModelAbstract {
     
     private $order, $content, $statusId, $userId;

     public function addRecord() {
         try {
             $st = $this->db->prepare("INSERT INTO $this->table (`content`, `status_id`, `user_id`) VALUES (?, ?, ?)");
             $st->execute([$this->content, $this->statusId, $this->userId]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         if (!$this->id)
             throw new Exception('Не задан id заказа');
         $this->readRecordsById()[0];
         if (!$this->content && $this->recordsById['content'])
             $this->content = $this->recordsById['content'];
         if (!$this->statusId && $this->recordsById['status_id'])
             $this->statusId = $this->recordsById['status_id'];
         try {
             $st = $this->db->prepare("UPDATE SET $this->table SET `content` = ?, `status_id` = ? WHERE id = ?");
             $st->execute([$this->content, $this->statusId, $this->id]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         
     }

 }
 