<?php

 abstract class TableModelAbstract extends Model implements CRUDInterface {

     protected $id;
     protected $table      = '';
     protected $recordsById;
     protected $allRecords = [];
     protected $params     = [];

     public function readAllRecords($fileds = '*') {
         try {
             $query            = $this->db->prepare("SELECT $fileds FROM $this->table");
             $query->execute();
             $this->allRecords = $query->fetchAll(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             $e->getMessage();
         }
     }

     public function readRecordsById($foreignKey = 'id', $fileds = '*') {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её отображения');
         try {
             $query                         = $this->db->prepare("SELECT $fileds FROM $this->table WHERE `" . $foreignKey . "` = :id");
             $query->execute([':id' => $this->id]);
             $this->recordsById             = $query->fetchAll(PDO::FETCH_ASSOC);
             $this->recordsById['rowCount'] = $query->rowCount();
         } catch (PDOException $e) {
             $e->getMessage();
         }
     }

     abstract function addRecord();

     abstract function updateRecord();

     public function deleteRecord($field = 'id') {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её удаления');
         try {
             $query = $this->db->prepare("DELETE FROM $this->table WHERE $field = :id");
             $query->execute([':id' => $this->id]);
             return $query->rowCount();
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }

     abstract function setData($formType = '', $method = '');

//     protected function fetchToArr($rawFetch, $fetchMethod = 'FETCH_ASSOC') {
//         while ($row = $rawFetch->fetch(PDO::$fetchMethod)) {
//             $result[] = $row;
//         }
//         return $result;
//     }

     public function setId($id) {
         $this->id = intval($id);
     }

     public function getId() {
         return $this->id;
     }

     public function setTable($table) {
         $this->table = $table;
     }

     public function getTable() {
         return $this->table;
     }

     public function getRecordsById() {
         return $this->recordsById;
     }

     public function getAllRecords() {
         return $this->allRecords;
     }
     
     function __set($key, $value) {
         $method = 'set' . ucfirst($key);
         if (is_callable(array($this, $method))) {
             $this->$method($value);
         } else {
             $this->params[$key] = $value;
         }
     }

     function __get($key) {
         return $this->params[$key];
     }

 }
 