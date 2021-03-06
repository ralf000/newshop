<?php

 namespace app\models;

use app\helpers\Generator;
use app\helpers\Helper;
use app\helpers\Path;
use app\helpers\User;
use app\helpers\Validate;
use app\services\Cookie;
use app\services\Mailer;
use app\services\Role;
use app\services\Session;
use Exception;
use PDO;

 class UserTableModel extends TableModelAbstract {

     protected $login, $password, $dpassword, $remember, $fullName, $email, $photo, $validateKey, $path, $userContacts, $addresses, $phones;
     protected $user, $id;

     public function __construct($login = '', $password = '') {
         parent::__construct();
         $this->login    = $login;
         $this->password = $password;
     }

     public function login() {
         $user = $this->checkCreds();
         if ($user) {
             $this->user = $user;
             $this->auth($this->user['id']);
             if (User::checkUser()) {
                 if (!empty($this->remember) && $this->remember > 0) {
                     $this->setRememberCookie($this->user['id']);
                 }
                 return $this->user['id'];
             }
         }
         return FALSE;
     }

     protected function setRememberCookie($userId) {
         $this->setId($userId);
         $this->setTable('user');
         $this->readRecordsById('id', 'password_hash');
         $hash = $this->getRecordsById()[0]['password_hash'];
         Cookie::set('remember', $this->user['id'] . '-' . md5($this->user['id'] . $_SERVER['REMOTE_ADDR'] . crypt($this->password, $hash)), time() + 3600 * 24 * 7, '/admin');
     }

     public function auth($userId) {
         Session::init();
//         $this->setToken();
         Session::set('user_id', $userId);
     }

     public function logout() {
         Cookie::delete('remember');
         Cookie::delete('generated');
         Session::destroy();
//         Session::unseted(['user_id', 'generated', 'username']);
         unset($this->user);
     }

     public function registration() {
         try {
             if ($this->checkUniq()) {
                 $this->addRecord();
                 if (!empty($this->id))
                     $this->addAddressesAndPhones();
                 if ($this->photo)
                     $this->updatePhoto();
                 //send mail for check user's email
                 $this->sendValidateCode();
             }else {
                 Session::setMsg('Введённые логин или email уже заняты. Пожалуйста введите другие', 'warning');
                 return FALSE;
             }
             return TRUE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function addRecord() {
         try {
             $this->setUserIdForDB();
             $st       = $this->db->prepare("INSERT INTO $this->table (`username`, `full_name`, `email`, `password_hash`, `validate_key`, `create_time`) VALUES (:username, :full_name, :email, :password_hash, :validate_key, :create_time)");
             $st->execute([
                 ':username' => $this->login, 
                 ':full_name' => $this->fullName, 
                 ':email' => $this->email, 
                 ':password_hash' => User::hs($this->password),
                 ':validate_key' => $this->validateKey, 
                 ':create_time' => date('Y-m-d H:i:s')
                 ]);
             $this->id = $this->db->lastInsertId();
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
     
     protected function addAddressesAndPhones(){
         if (!empty($this->addresses) && !empty($this->phones)){
             $this->addresses->setId($this->id);
             $this->addresses->addRecord();
             $this->phones->setId($this->id);
             $this->phones->addRecord();
         }
     }

     public function readUserAddress($condField = 'user_id') {
         if (empty($this->id))
             throw new Exception('Не задан id пользователя');
         try {
             $st                            = $this->db->prepare("SELECT `id`, `address`, `postal_code` FROM address WHERE `{$condField}` = ?");
             $st->execute([$this->id]);
             $this->userContacts['address'] = $st->fetchAll(PDO::FETCH_ASSOC);
             return $this->userContacts['address'];
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function readUserPhones($condField = 'user_id') {
         if (empty($this->id))
             throw new Exception('Не задан id пользователя');
         try {
             $st                           = $this->db->prepare("SELECT `id`, `number`, `number_type` FROM `phone` WHERE `{$condField}` = ?");
             $st->execute([$this->id]);
             $this->userContacts['phones'] = $st->fetchAll(PDO::FETCH_ASSOC);
             return $this->userContacts['phones'];
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function getAllUsers($fields = '*', $condition = '') {
         try {
             $st               = $this->db->prepare("SELECT $fields FROM user LEFT JOIN address ON user.id = address.user_id LEFT JOIN phone ON  user.id = phone.user_id $condition");
             $st->execute();
             return $this->allRecords = $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         
     }

     public function updatePhoto() {
         if (empty($this->id))
             $this->id   = $this->user['id'];
         $this->path = $this->path . $this->id;
         try {
             if ($this->photo) {
                 $st = $this->db->prepare("UPDATE $this->table SET `photo` = :photo WHERE `id` = :id");
                 $st->execute([':photo' => $this->path . '/main_' . Generator::strToLat($this->photo), ':id' => $this->id]);
                 Helper::moveFile('photo', TRUE, $this->id, 'userimg');
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

//     private function setToken() {
//         $salt              = Helper::generate(4);
//         $tokenstr          = strval(date('W')) . $salt;
//         $token             = md5($tokenstr);
//         $_SESSION['token'] = $token;
//         output_add_rewrite_var('token', $token);
//     }

     private function checkCreds() {
         try {
             $st = $this->db->prepare("SELECT `id`, `username`, `email`, `password_hash`, `validated` FROM $this->table WHERE `username` = :username");
             $st->execute([':username' => $this->login]);
             if ($st->rowCount() === 1) {
                 $user = $st->fetch(PDO::FETCH_ASSOC);
                 if (!$user['validated']) {
                     Session::setMsg('Для входа необходимо активировать ваш аккаунт при помощи письма, отправленного на ваш электронный ящик ранее', 'warning');
                     return FALSE;
                 }
                 if (User::confirmPassword($user['password_hash'], $this->password))
                     return $user;
             }
             Session::setMsg('Неверный логин или пароль', 'danger');
             return FALSE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     //проверка логина и почты на уникальность
     private function checkUniq() {
         try {
             $st = $this->db->prepare("SELECT username, email FROM $this->table WHERE username = :username OR email = :email");
             $st->execute([':username' => $this->login, ':email' => $this->email]);
             if ($st->rowCount() > 0)
                 return FALSE;
             else
                 return TRUE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function setData($formType = '', $method = 'INPUT_POST') {
         $this->login    = Validate::validateInputVar('username', $method, 'str');
         $this->password = Validate::validateInputVar('pass', $method, 'str');
         $this->remember = Validate::validateInputVar('remember', $method, 'int');
         if ($formType === 'reg' || $formType === 'registration') {
             $this->fullName    = Validate::validateInputVar('fullName', $method, 'str');
             $this->email       = Validate::validateInputVar('email', $method, 'email');
             $this->photo       = $_FILES['photo']['name'];
             $this->validateKey = Generator::generate(10);
             $this->path        = Path::USERIMG_UPLOAD_DIR;
             $this->dpassword   = Validate::validateInputVar('dpass', $method, 'str');
             
             $this->setAddressesAndPhones();
             
             return $this->password === $this->dpassword ? TRUE : FALSE;
         }
     }

     public function setValidateUserData(array $params = []) {
         $this->email       = filter_var($params['email'], FILTER_SANITIZE_EMAIL);
         $this->validateKey = filter_var($params['key']);
     }

     public function checkValidKey() {
         if (!(empty($this->email) && empty($this->validateKey))) {
             $user = $this->getUserEmail('id, username, email, validate_key, create_time');
             if ($user['validate_key'] && $user['validate_key'] === $this->validateKey && $user['create_time'] && time() <= strtotime($user['create_time'] . ' + 2 week'))
                 return $this->userActivate();
             else {
                 return FALSE;
             }
         }
     }

     public function deleteUser($id = NULL) {
         if (!$id)
             $id = $this->id;
         if (!$id)
             throw new Exception('не задан id пользователя для удаления!');
         try {
             $this->setUserIdForDB();
             $st = $this->db->prepare("UPDATE user SET deleted = 1 WHERE id = ?");
             $st->execute([$id]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     protected function setAddressesAndPhones() {
         $addressModel    = new AddressTableModel($this->id);
         $addressModel->setData();
         $this->addresses = $addressModel;
         $phoneModel      = new PhoneTableModel($this->id);
         $phoneModel->setData();
         $this->phones    = $phoneModel;
     }

     private function getUserEmail($fields = '*') {
         try {
             $st   = $this->db->prepare("SELECT $fields FROM $this->table WHERE `email` = :email");
             $st->execute([':email' => $this->email]);
             $user = $st->fetch(PDO::FETCH_ASSOC);
             if ($user) {
                 $this->user = $user;
                 return $user;
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     private function userActivate() {
         if (empty($this->user['id']))
             throw new Exception('Не задан id пользователя');
         try {
             $st = $this->db->prepare("UPDATE $this->table SET `validated` = ?, `validate_key` = ?, `update_time` = ? WHERE id = ?");
             $st->execute([1, NULL, date('Y-m-d H:i:s'), $this->user['id']]);
             Role::setRoleForUser($this->db, $this->user['id']);
             return TRUE;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     private function sendValidateCode() {
         $siteName = Helper::getSiteConfig()->general->siteName;
         $siteHost = Helper::getSiteConfig()->general->siteHost;
         $subject  = 'Подтверждение регистрации на сайте ' . $siteName;
         $content  = '
                         <p>Здравствуйте! Благодарим вас за регистрацию на сайте ' . $siteName . '</p>
                         <p>Для подтверждения регистрации пройдите по ссылке:</p>
                         <a href="' . $siteHost . '/user/validate/email/' . $this->email . '/key/' . $this->validateKey . '">Подтвердить email</a>';
         Mailer::emailSender($this->email, $subject, $content);
     }
     
     public function setPath($path) {
         $this->path = $path;
     }

     public function setPhoto($photo) {
         $this->photo = $photo;
     }

     public function getUser() {
         return $this->user;
     }

     public function getUserContacts() {
         return $this->userContacts;
     }
     
     public function getUserProfileManager($id = NULL, $table = 'user'){
         $this->setTable($table);
         return new UserProfileManagerModel($this, $id);
     }
 }
 