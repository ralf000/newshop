<?php

 namespace app\models;

use app\dataContainers\Order;
use app\helpers\Basket;
use app\helpers\Validate;
use Exception;
use PDO;

 class OrderTableModel extends TableModelAbstract {

     private $order;
     private $orderBodyManager;

     public function addRecord() {
         try {
             if (empty($this->order) || !is_object($this->order))
                 throw new Exception('Объект Order не инициализирован');
             $st = $this->db->prepare("INSERT INTO order_body (body, note, user_id, address, phone, status_id, delivery_type, delivery_date, delivery_time, created_time) VALUES (?,?,?,?,?,?,?,?,?,NOW())");
             $st->execute([
                 $this->order->getBasket(),
                 $this->order->getNote(),
                 $this->order->getUserId(),
                 $this->getAddress(),
                 $this->getPhone(),
                 1,
                 $this->order->getDeliveryType(),
                 $this->order->getDeliveryDate(),
                 $this->order->getDeliveryTime()
             ]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {}

     
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

     public function getDeliveryForId($id) {
         try {
             $st       = $this->db->prepare("SELECT delivery_type FROM order_delivery_type WHERE id = ?");
             $st->execute([$id]);
             $delivery = $st->fetchAll(PDO::FETCH_ASSOC)[0]['delivery_type'];
             return (!empty($delivery)) ? $delivery : FALSE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function getStatusForId($id) {
         try {
             $st     = $this->db->prepare("SELECT s.id as status_id, s.status, s.note, t.id as type_id, t.type FROM order_status as s LEFT JOIN order_type as t ON s.type_id = type_id WHERE s.id = ?");
             $st->execute([$id]);
             $result = $st->fetchAll(PDO::FETCH_ASSOC)[0];
             return $result ? $result : FALSE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = '') {
         $data   = [];
         $method = 'INPUT_POST';

         $data['basket']          = Basket::get();
         $data['user_id']         = Validate::validateInputVar('user_id', $method, 'int');
         $data['delivery_type']   = Validate::validateInputVar('delivery_type', $method, 'int');
         $data['user_address']    = Validate::validateInputVar('user_address', $method, 'int');
         $data['city']            = Validate::validateInputVar('city', $method, 'str');
         $data['street']          = Validate::validateInputVar('street', $method, 'str');
         $data['home']            = Validate::validateInputVar('home', $method, 'str');
         $data['flat']            = Validate::validateInputVar('flat', $method, 'int');
         $data['postal']          = Validate::validateInputVar('postal', $method, 'int');
         $data['user_phone']      = Validate::validateInputVar('user_phone', $method, 'int');
         $data['number']          = Validate::validateInputVar('number', $method, 'int');
         $data['numType']         = Validate::validateInputVar('numType', $method, 'int');
         $data['deliveryDate']    = Validate::validateInputVar('deliveryDate', $method, 'str');
         $data['deliveryTime']    = Validate::validateInputVar('deliveryTime', $method, 'str');
         $data['note']            = Validate::validateInputVar('note', $method, 'str');
         $data['rememberAddress'] = Validate::validateInputVar('rememberAddress', $method, 'int');
         $data['rememberPhone']   = Validate::validateInputVar('rememberPhone', $method, 'int');

         $this->order = new Order($data);
     }

     public function getOrderStatusList($mode = FALSE) {
         try {
             if ($mode) {
                 $st   = $this->db->query('SELECT * FROM order_type');
                 $list = $st->fetchAll(PDO::FETCH_ASSOC);
                 foreach ($list as $key => $type) {
                     $st                     = $this->db->prepare("SELECT * FROM order_status WHERE type_id = ?");
                     $st->execute([$type['id']]);
                     $statuses               = $st->fetchAll(PDO::FETCH_ASSOC);
                     $list[$key]['statuses'] = $statuses;
                 }
             } else {
                 $st   = $this->db->query('SELECT * FROM order_status');
                 $list = $st->fetchAll(PDO::FETCH_ASSOC);
             }
             return $list;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
     
     public function getDeliveryTypes() {
         try {
             $st = $this->db->query("SELECT * FROM order_delivery_type");
             return $st->fetchAll(\PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setOrderStatus($orderId, $statusId) {
         try {
             $st = $this->db->prepare('UPDATE order_body SET status_id = ? WHERE id = ?');
             $st->execute([$statusId, $orderId]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
     
     public function setDeliveryType($orderId, $typeId) {
         try {
             $st = $this->db->prepare('UPDATE order_body SET delivery_type = ? WHERE id = ?');
             $st->execute([$typeId, $orderId]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function getAddress() {
         $userAddressId = $this->order->getUserAddress();
         if (!empty($userAddressId) && $userAddressId != 0) {
             $addressModel = new AddressTableModel($this->order->getUserId());
             $addressModel->setTable('address');
             $address      = $addressModel->readRecordsById()[0];
             return $address['address'] . ', Индекс: ' . $address['postal_code'];
         } else {
             $mode = $this->order->getRememberAddress();
             if ($mode && $mode == 1) {
                 $addressModel = new AddressTableModel(
                         $this->order->getUserId(), [$this->order->getFullAddress()], [$this->order->getPostal()]
                 );
                 $flag         = $addressModel->checkAddress($this->order->getFullAddress());
                 if (!$flag)
                     $addressModel->addRecord();
             }
             if (!is_null($this->order->getFullAddress()))
                 return $this->order->getFullAddress() . ', Индекс: ' . $this->order->getPostal();
             else
                 return NULL;
         }
     }

     public function getPhone() {
         $userPhoneId = $this->order->getUserPhone();
         if (!empty($userPhoneId) && $userPhoneId != 0) {
             $phoneModel = new PhoneTableModel($this->order->getUserId());
             $phoneModel->setTable('phone');
             $phone      = $phoneModel->readRecordsById()[0];
             return $phone['number'] . ', Тип: ' . $phone['number_type'];
         } else {
             $mode = $this->order->getRememberPhone();
             if ($mode && $mode === 1) {
                 $phoneModel = new PhoneTableModel($this->order->getUserId(), [$this->order->getNumber()], [$this->order->getNumType()]);
                 $flag       = $phoneModel->checkPhone($this->order->getNumber());
                 if (!$flag)
                     $phoneModel->addRecord();
             }
             return $this->order->getFullPhone();
         }
     }
     
     public function getOrderBodyManager() {
         $this->orderBodyManager = new OrderBodyManagerModel();
         return $this->orderBodyManager;
     }

     public function setProductId($id) {
         $this->productId = intval($id);
     }

     public function getProductId() {
         return $this->productId;
     }

 }
 