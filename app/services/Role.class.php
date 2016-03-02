<?php
 
   namespace app\services;

use Exception;
use PDO;

 class Role {

     protected $db;
     protected $permissions;

     protected function __construct() {
         $this->db = DB::init()->connect();
         $this->permissions = array();
     }

     // Возвращаем объект роли с соответствующими полномочиями
     public static function getRolePerms($role_id) {
         $role = new Role();
         $sql  = "SELECT permissions.perm_desc FROM role_perm
                JOIN permissions ON role_perm.perm_id = permissions.perm_id
                WHERE role_perm.role_id = :role_id";
         $sth  = $this->db->prepare($sql);
         $sth->execute([":role_id" => $role_id]);

         while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
             $role->permissions[$row["perm_desc"]] = true;
         }
         return $role;
     }

     // Проверка установленных полномочий
     public function hasPerm($permission) {
         return isset($this->permissions[$permission]);
     }
     
     
     // Вставить новую роль
     public static function insertRole($role_name) {
         $sql = "INSERT INTO roles (role_name) VALUES (:role_name)";
         $sth = $this->db->prepare($sql);
         return $sth->execute(array(":role_name" => $role_name));
     }

    // Вставить массив ролей для заданного ID пользователя
     public static function insertUserRoles($user_id, $roles) {
         $sql = "INSERT INTO user_role (user_id, role_id) VALUES (:user_id, :role_id)";
         $sth = $this->db->prepare($sql);
         $sth->bindParam(":user_id", $user_id, PDO::PARAM_STR);
         $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
         foreach ($roles as $role_id) {
             $sth->execute();
         }
         return true;
     }

    // удалить массив ролей и все связи
     public static function deleteRoles($roles) {
         $sql = "DELETE t1, t2, t3 FROM roles as t1
            JOIN user_role as t2 on t1.role_id = t2.role_id
            JOIN role_perm as t3 on t1.role_id = t3.role_id
            WHERE t1.role_id = :role_id";
         $sth = $this->db->prepare($sql);
         $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
         foreach ($roles as $role_id) {
             $sth->execute();
         }
         return true;
     }

    // Удалить все роли для заданного пользователя
     public static function deleteUserRoles($user_id) {
         $sql = "DELETE FROM user_role WHERE user_id = :user_id";
         $sth = $this->db->prepare($sql);
         return $sth->execute(array(":user_id" => $user_id));
     }
     
     public static function setRoleForUser($db, $userId, $role = 'Client'){
         try {
             $st = $db->prepare("INSERT INTO `user_role` (`user_id`, `role_id`) VALUES (?, (SELECT `role_id` FROM `roles` WHERE `role_name` = ?))");
             $st->execute([$userId, $role]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
 }
 