<?php

 namespace app\models;

 use Exception;

 class PhoneTableModel extends TableModelAbstract {

     protected $number = [], $types  = [], $id;

     public function __construct($id = NULL, array $number = [], array $types = []) {
         parent::__construct();
         if ($id)
             $this->id = $id;
         $this->number = $number;
         $this->types = $types;
     }

     public function addRecord() {
         if (!$this->id)
             throw new Exception('Не задан id пользователя для добавления нового телефона');
         try {
             foreach ($this->number as $key => $number) {
                 $st = $this->db->prepare("INSERT INTO phone (user_id, number, number_type) VALUES (?, ?, ?)");
                 $st->execute([$this->id, $number, $this->types[$key]]);
             }
             return $this->db->lastInsertId();
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         if (!$this->id)
             throw new Exception('Не задан id пользователя для обновления адресов');
         try {
             foreach ($this->number as $key => $number) {
                 $st = $this->db->prepare("UPDATE phone SET user_id = ?, number = ?, number_type = ? WHERE id = ?");
                 $st->execute([$this->id, $number, $this->types[$key], $key]);
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         if (!empty($_POST['number'])) {
             foreach ($_POST['number'] as $id => $num) {
                 $this->number[(int) $id] = filter_var($num, FILTER_SANITIZE_NUMBER_INT);
             }
         }
         if (!empty($_POST['numtype'])) {
             foreach ($_POST['numtype'] as $id => $type) {
                 $this->types[(int) $id] = filter_var($type, FILTER_SANITIZE_STRING);
             }
         }
     }
     
     public function checkPhone($number) {
         try {
             $st = $this->db->prepare("SELECT id FROM phone WHERE number LIKE ?");
             $st->execute([$number]);
             return (count($st->fetchAll(\PDO::FETCH_ASSOC)) > 0) ? TRUE : FALSE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

 }
 