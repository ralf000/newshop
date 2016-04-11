<?php

 namespace app\dataContainers;

 class Order {

     private $basket;
     private $userId;
     private $deliveryType;
     private $userAddress;
     private $city;
     private $street;
     private $home;
     private $flat;
     private $postal;
     private $userPhone;
     private $number;
     private $numType;
     private $deliveryDate;
     private $deliveryTime;
     private $note;
     private $rememberAddress;
     private $rememberPhone;

     function __construct(array $data) {
         $this->basket          = $data['basket'];
         $this->userId          = $data['user_id'];
         $this->deliveryType    = $data['delivery_type'];
         $this->userAddress     = $data['user_address'];
         $this->city            = $data['city'];
         $this->street          = $data['street'];
         $this->home            = $data['home'];
         $this->flat            = $data['flat'];
         $this->postal          = $data['postal'];
         $this->userPhone       = $data['user_phone'];
         $this->number          = $data['number'];
         $this->numType         = $data['numType'];
         $this->deliveryDate    = $data['deliveryDate'];
         $this->deliveryTime    = $data['deliveryTime'];
         $this->note            = $data['note'];
         $this->rememberAddress = $data['rememberAddress'];
         $this->rememberPhone   = $data['rememberPhone'];
     }

     function getBasket() {
         return serialize($this->basket);
     }

     function getUserId() {
         return $this->userId;
     }

     function getDeliveryType() {
         return $this->deliveryType;
     }

     function getUserAddress() {
         return $this->userAddress;
     }

     function getCity() {
         return $this->city;
     }

     function getStreet() {
         return $this->street;
     }

     function getHome() {
         return $this->home;
     }

     function getFlat() {
         return $this->flat;
     }

     function getPostal() {
         return $this->postal;
     }

     function getUserPhone() {
         return $this->userPhone;
     }

     function getNumber() {
         return $this->number;
     }

     function getNumType() {
         return $this->numType;
     }

     function getDeliveryDate() {
         return $this->deliveryDate;
     }

     function getDeliveryTime() {
         return $this->deliveryTime;
     }

     function getNote() {
         return $this->note;
     }

     function getRememberAddress() {
         return $this->rememberAddress;
     }

     function getRememberPhone() {
         return $this->rememberPhone;
     }

     function getFullAddress() {
         if (!empty($this->city))
             return "г. $this->city, улица $this->street, дом $this->home, кв. $this->flat";
         return NULL;
     }

     function getFullPhone() {
         if (empty($this->number))
             return FALSE;
         if (empty($this->numType))
             $this->numType = 'Другой';
         return "$this->number, Тип: $this->numType";
     }

 }
 