<?php

 class PrivilegedUser extends User {

     private $roles;

     public function __construct() {
         parent::__construct();
     }

     // Изменяем метод класса User
     public static function getByUsername($username) {
         $sql    = "SELECT * FROM user WHERE username = :username";
         $sth    = $this->db->prepare($sql);
         $sth->execute([":username" => $username]);
         $result = $sth->fetchAll();

         if (!empty($result)) {
             $privUser             = new PrivilegedUser();
             $privUser->user_id    = $result[0]["id"];
             $privUser->username   = $username;
             $privUser->password   = $result[0]["password_hash"];
             $privUser->email_addr = $result[0]["email"];
             $privUser->initRoles();
             return $privUser;
         } else {
             return false;
         }
     }

     // Наполняем объект roles соответствующими разрешениями
     protected function initRoles() {
         $this->roles = array();
         $sql         = "SELECT user_role.role_id, roles.role_name FROM user_role
                JOIN roles ON user_role.role_id = roles.role_id
                WHERE user_role.user_id = :user_id";
         $sth         = $this->db->prepare($sql);
         $sth->execute([":user_id" => $this->user_id]);

         while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
             $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
         }
     }

     // Проверяем, обладет ли пользователь нужными разрешениями
     public function hasPrivilege($perm) {
         foreach ($this->roles as $role) {
             if ($role->hasPerm($perm)) {
                 return true;
             }
         }
         return false;
     }
     
     // Проверка, обладает ли пользователь заданной ролью
     public function hasRole($role_name) {
         return isset($this->roles[$role_name]);
     }

    // Вставляем новое разрешение в роль
     public static function insertPerm($role_id, $perm_id) {
         $sql = "INSERT INTO role_perm (role_id, perm_id) VALUES (:role_id, :perm_id)";
         $sth = $this->db->prepare($sql);
         return $sth->execute(array(":role_id" => $role_id, ":perm_id" => $perm_id));
     }

    // Удаляем все разрешения из роли
     public static function deletePerms() {
         $sql = "TRUNCATE role_perm";
         $sth = $this->db->prepare($sql);
         return $sth->execute();
     }

 }
 