<?php

 abstract class TableModelAbstract extends Model implements CRUDInterface{

     protected $id;
     protected $db;
     protected $table;
     protected $record;
     protected $allRecords;
     
     const IMG_UPLOAD_DIR  = 'upload/images/';
     const FILE_UPLOAD_DIR = 'upload/files/';

     public function __construct() {
         try {
             $this->db = DB::init()->connect();
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function readAllRecords($fileds = '*') {
         try {
             $query = $this->db->prepare("SELECT $fileds FROM $this->table");
             $query->execute();
             $this->allRecords = $query->fetchAll(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             $e->getMessage();
         }
     }

     public function readOneRecord($fileds = '*') {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её отображения');
         try {
             $query  = $this->db->prepare("SELECT $fileds FROM $this->table WHERE `id` = :id");
             $query->execute([':id' => $this->id]);
             $this->record = $query->fetch(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             $e->getMessage();
         }
     }

     abstract function addRecord();

     abstract function updateRecord();

     public function deleteRecord() {
         if ($this->id == NULL)
             throw new Exception('укажите id записи для её удаления');
         try {
             $query = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
             $query->execute([':id' => $this->id]);
         } catch (PDOException $e) {
             die($e->getMessage());
         }
     }
     
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

     public function getRecord() {
         return $this->record;
     }

     public function getAllRecords() {
         return $this->allRecords;
     }

 }
 