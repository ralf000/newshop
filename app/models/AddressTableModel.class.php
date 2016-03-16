<?php

 namespace app\models;

 use Exception;

 class AddressTableModel extends TableModelAbstract {

     protected $address = [], $postal  = [], $id;

     public function __construct($id = NULL, $address = [], $postal = []) {
         parent::__construct();
         if ($id)
             $this->id = $id;
             $this->address = $address;
             $this->postal = $postal;
     }

     public function addRecord() {
         if (!$this->id)
             throw new Exception('Не задан id пользователя для добавления нового адреса');
         try {
             foreach ($this->address as $key => $address) {
                 $st = $this->db->prepare("INSERT INTO address (user_id, address, postal_code) VALUES (?, ?, ?)");
                 $st->execute([$this->id, $address, $this->postal[$key]]);
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         if (!$this->id)
             throw new Exception('Не задан id пользователя для обновления адресов');
         try {
             foreach ($this->address as $key => $address) {
                 $st = $this->db->prepare("UPDATE address SET user_id = ?, address = ?, postal_code = ? WHERE id = ?");
                 $st->execute([$this->id, $address, $this->postal[$key], $key]);
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         if (!empty($_POST['address'])) {
             foreach ($_POST['address'] as $id => $adr) {
                 $this->address[(int) $id] = filter_var($adr, FILTER_SANITIZE_STRING);
             }
         }
         if (!empty($_POST['postal'])) {
             foreach ($_POST['postal'] as $id => $p) {
                 $this->postal[(int) $id] = filter_var($p, FILTER_SANITIZE_NUMBER_INT);
             }
         }
     }
     
     public function setAddress(array $address) {
         $this->address = $address;
     }
     
     public function setPostal(array $postal) {
         $this->postal = $postal;
     }

     public function getAddress() {
         return $this->address;
     }

     public function getPostal() {
         return $this->address;
     }

 }
 