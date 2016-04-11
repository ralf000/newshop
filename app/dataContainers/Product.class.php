<?php

 namespace app\dataContainers;

 class Product {

     public $id, $quantity, $data;

     function __construct($id, $quantity = 1) {
         $this->id       = (int) $id;
         $this->quantity = (int) $quantity;
     }

     function getId() {
         return $this->id;
     }

     function getQuantity() {
         return $this->quantity;
     }

     function setId($id) {
         $this->id = (int) $id;
     }

     function setQuantity($quantity) {
         $this->quantity = (int) $quantity;
     }
     
     function setData(array $data){
         $this->data = $data;
     }
     
     function getData($key = FALSE){
         if ($key && array_key_exists($key, $this->data))
             return $this->data[$key];
         return $this->data;
     }
 }
 