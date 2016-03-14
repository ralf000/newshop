<?php

 namespace app\models;

 use app\helpers\Helper;
 use app\helpers\Validate;
 use app\services\Role;
 use app\services\Session;
 use Exception;

 class UserUpdateTableModel extends UserTableModel {

     public $roleId, $addresses, $phones;

     public function updateRecord() {
         if (!$this->id)
             throw new Exception('Не задан id пользователя для обновления');
         try {
             $this->setUserIdForDB();
             $st = $this->db->prepare("UPDATE user SET full_name = ? WHERE id = ?");
             $st->execute([$this->fullName, $this->id]);
                 $this->addresses->updateRecord();
                 $this->phones->updateRecord();
             Role::updateRoleByUserId($this->db, $this->roleId, $this->id);
             Session::setMsg('Пользователь успешно обновлен', 'success');
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateAvatar() {
         if (empty($this->id))
             $this->id   = $this->user['id'];
         $this->path = $this->path . $this->id;
         try {
             if ($this->photo) {
                 $st = $this->db->prepare("UPDATE $this->table SET `photo` = ? WHERE `id` = ?");
                 $st->execute([$this->path . '/avatar/' . Helper::strToLat($this->photo), intval($this->id)]);
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = 'INPUT_POST') {
         if ($formType === 'userUpdate') {
             $this->id       = Validate::validateInputVar('id', $method, 'int');
             $this->roleId   = Validate::validateInputVar('roles', $method, 'int');
             $this->fullName = Validate::validateInputVar('fullName', $method, 'str');

             $addressModel    = new AddressTableModel($this->id);
             $addressModel->setData();
             $this->addresses = $addressModel;
             $phoneModel      = new PhoneTableModel($this->id);
             $phoneModel->setData();
             $this->phones    = $phoneModel;
         }
     }

 }
 