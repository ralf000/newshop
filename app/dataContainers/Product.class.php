<?php

 namespace app\dataContainers;

 class Product {

     private $id, $quantity;

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

 }
 