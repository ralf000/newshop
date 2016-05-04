<?php

 namespace app\models;

use app\helpers\Basket;
use app\helpers\Helper;
use Exception;

 class UserProfileManagerModel extends Model {

     private $userTableModel = NULL;
     private $id;
     private $fullProfile = [];

     public function __construct(UserTableModel $userTableModel, $id = NULL) {
         parent::__construct();
         if (is_null($this->userTableModel))
             $this->userTableModel = $userTableModel;
         if (!is_null($id)) {
             $this->id = $id;
             $this->userTableModel->setId($id);
         }
     }

     public function getFullUserProfile() {
         try {
             if (!$this->id)
                 throw new Exception('Не задан id пользователя');
             $user['profile']  = $this->userTableModel->readRecordsById();
             $this->userTableModel->readUserAddress();
             $this->userTableModel->readUserPhones();
             $user['contacts'] = $this->userTableModel->getUserContacts();
             $orderModel       = new OrderTableModel();
             $orderModel->setTable('order_body as b, order_type as t, order_status as s, order_delivery_type as d');
             $orderModel->setId($this->id);
             $user['orders']   = $orderModel->readRecordsById('user_id', '*', 'AND b.status_id = s.id AND b.delivery_type = d.id AND s.type_id = t.id');
             if (!empty($user['orders'])){
                 foreach ($user['orders'] as $key => $order){
                     if ($key !== 'rowCount')
                         $user['orders'][$key]['body'] = Basket::getProductsList($order['body']);
                 }
             }
             $user['profile']['photo'] = !empty($user['profile'][0]['photo']) ? $user['profile'][0]['photo'] : \app\helpers\Path::DEFAULT_USER_AVATAR;
             $this->fullProfile = $user;
             return $user;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }


     function getId() {
         return $this->id;
     }

     function setId($id) {
         $this->id = $id;
     }

 }
 