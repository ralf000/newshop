<?php

 class User extends TableModelAbstract {

     private $login, $password, $fullName, $email, $photo, $validateKey, $path, $id;
     protected $user;

     public function __construct($login = '', $password = '') {
         parent::__construct();
         $this->login    = $login;
         $this->password = $password;
     }

     public function login() {
         $user = $this->checkCreds();
         if ($user) {
             $this->user          = $user;
             session_start();
             $this->setToken();
             $this->checkUser();
             $_SESSION['user_id'] = $this->user['id'];
             return $this->user['id'];
         }
         return FALSE;
     }

     public function registration() {
         $st           = $this->db->prepare("INSERT INTO $this->table (`username`, `full_name`, `email`, `password_hash`, `validate_key`) VALUES :username, :fullName, :photo, :email, :password_hash, :validate_key");
         $st->execute([':username' => $this->login, ':full_name' => $this->fullName, ':password_hash' => $this->password, ':validate_key' => $this->validateKey]);
         $this->lastId = $st->lastInsertId();
     }

     public function checkUser() {
         // Предотвращение перехвата сеанса
         if (!isset($_REQUEST['token']) || $_REQUEST['token'] != $token) {
             session_destroy();
             header('Location: /user/login');
             exit;
         }
         // Предотвращение фиксации сеанса (включая ini_set('session.use_only_cookies', true);)
         if (!isset($_SESSION['generated']) || $_SESSION['generated'] < (time() - 60 * 3)) {
             session_regenerate_id();
             $_SESSION['generated'] = time();
         }
     }

     public function addRecord() {
         
     }

     public function updateRecord() {}
     
     public function updatePhoto() {
         if (empty($this->id))
             $this->id = $this->user['id'];
         $this->path = $this->path . $this->id;
         $st = $this->db->prepare("UPDATE $this->table SET `photo` = :photo WHERE `id` = $this->lastId");
         $st->execute([':photo' => $this->path . '/main_' . Helper::strToLat($this->photo)]);
         Helper::moveFile('photo', TRUE, NULL, 'img', $this->path);
     }

     private function setToken() {
         $salt              = Helper::generate(4);
         $tokenstr          = strval(date('W')) . $salt;
         $token             = md5($tokenstr);
         $_SESSION['token'] = $token;
         output_add_rewrite_var('token', $token);
     }

     //Современный способ солить и хешировать пароль
     /*      * Функция солит и хеширует пароль
      * @param  string $password
      * @return string хеш пароля
      */
     private function hs($password) {
         if (defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH) {
             $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22); //$2y$11$ - специальный ключ
             return crypt($password, $salt);
         }
     }

     private function checkCreds() {
         $st = $this->db->prepare("SELECT username, email FROM $this->table WHERE username = :username");
         $st->execute([':username' => $this->login]);
         if ($st->rowCount() === 1) {
             $user = $st->fetch(PDO::FETCH_ASSOC);
             if ($this->confirmPassword($user['password_hash'], $this->password))
                 return $user;
         }
         return FALSE;
     }

     //проверка логина и почты на уникальность
     private function checkUniq() {
         $st = $this->db->prepare("SELECT username, email FROM $this->table WHERE username = :username OR email = :email");
         $st->execute([':username' => $this->login, ':email' => $this->email]);
         if ($st->rowCount() > 0)
             return FALSE;
         else
             return TRUE;
     }

     private function confirmPassword($hash, $password) {
         return crypt($password, $hash) === $hash;
     }

     public function setData() {
         $method            = 'INPUT_POST';
         $this->login       = Validate::validateVar('login', $method, 'str');
         $this->fullName    = Validate::validateVar('fullName', $method, 'str');
         $this->email       = Validate::validateVar('email', $method, 'str');
         $this->password    = Validate::validateVar('pass', $method, 'str');
         $this->photo       = $_FILES['photo']['name'];
         $this->validateKey = Helper::generate(10);
         $this->path        = TableModelAbstract::IMG_UPLOAD_DIR . 'users/';
     }

     public function getUser() {
         return $this->user;
     }

 }
 