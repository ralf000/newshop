<?php

 class UserTableModel extends TableModelAbstract {

     private $login, $password, $dpassword, $fullName, $email, $photo, $validateKey, $path;
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
             Session::init();
             $this->setToken();
             Session::set('user_id', $this->user['id']);
             if (self::checkUser())
                 return $this->user['id'];
         }
         return FALSE;
     }

     public function logout() {
         Session::destroy();
         unset($this->user);
     }

     public function registration() {
         try {
             if ($this->checkUniq()) {
                 $this->addRecord();
                 if ($this->photo)
                     $this->updatePhoto();
                 //send mail for check user's email
                 $this->sendValidateCode();
             }else {
                 Session::setMsg('Введённые логин или email уже заняты. Пожалуйста введите другие', 'warning');
                 return FALSE;
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public static function checkUser() {
         // Предотвращение перехвата сеанса
         if (!(isset($_REQUEST['token']) || $_REQUEST['token'] === Session::get('token'))) {
             $sessUserId = Session::get('user_id');
             if (!(isset($sessUserId))) {
                 Session::destroy();
                 unset($this->user);
                 Session::setMsg('Произошла ошибка. Пожалуйста авторизуйтесь заново', 'warning');
                 return FALSE;
             }
         }
         // Предотвращение фиксации сеанса (включая ini_set('session.use_only_cookies', true);)
         $sessGenerated = Session::get('generated');
         if (!isset($sessGenerated) || $sessGenerated < (time() - 30)) {
             session_regenerate_id();
             $_SESSION['generated'] = time();
         }
         return TRUE;
     }

     public function addRecord() {
         $st       = $this->db->prepare("INSERT INTO $this->table (`username`, `full_name`, `email`, `password_hash`, `validate_key`, `create_time`) VALUES (:username, :full_name, :email, :password_hash, :validate_key, :create_time)");
         $st->execute([':username' => $this->login, ':full_name' => $this->fullName, ':email' => $this->email, ':password_hash' => $this->hs($this->password), ':validate_key' => $this->validateKey, ':create_time' => date('Y-m-d H:i:s')]);
         $this->id = $this->db->lastInsertId();
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
                 $st->execute([':photo' => $this->path . '/main_' . Helper::strToLat($this->photo), ':id' => $this->id]);
                 Helper::moveFile('photo', TRUE, $this->id, 'userimg');
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
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
         try {
             $st = $this->db->prepare("SELECT `id`, `username`, `email`, `password_hash`, `validated` FROM $this->table WHERE `username` = :username");
             $st->execute([':username' => $this->login]);
             if ($st->rowCount() === 1) {
                 $user = $st->fetch(PDO::FETCH_ASSOC);
                 if (!$user['validated']) {
                     Session::setMsg('Для входа необходимо активировать ваш аккаунт при помощи письма, отправленного на ваш электронный ящик ранее', 'warning');
                     return FALSE;
                 }
                 if ($this->confirmPassword($user['password_hash'], $this->password))
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

     private function confirmPassword($hash, $password) {
         return crypt($password, $hash) === $hash;
     }

     public function setData($formType = '', $method = 'INPUT_POST') {
         $this->login    = Validate::validateInputVar('username', $method, 'str');
         $this->password = Validate::validateInputVar('pass', $method, 'str');
         if ($formType === 'reg' || $formType === 'registration') {
             $this->fullName    = Validate::validateInputVar('fullName', $method, 'str');
             $this->email       = Validate::validateInputVar('email', $method, 'email');
             $this->photo       = $_FILES['photo']['name'];
             $this->validateKey = Helper::generate(10);
             $this->path        = TableModelAbstract::USERIMG_UPLOAD_DIR;
             $this->dpassword   = Validate::validateInputVar('dpass', $method, 'str');
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
                 $this->userActivate();
             else {
                 Session::setMsg('Невозможность активировать данный аккаунт. Пожалуйста зарегистрируйтесь заново', 'warning');
                 header('Location: user/registration');
                 exit;
             }
         }
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
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }
     
     private function sendValidateCode(){
         $siteName = Helper::getSiteConfig()['siteName'];
         $siteHost = Helper::getSiteConfig()['siteHost'];
         $subject  = 'Подтверждение регистрации на сайте ' . $siteName;
         $content  = '
                         <p>Здравствуйте! Благодарим вас за регистрацию на сайте ' . $siteName . '</p>
                         <p>Для подтверждения регистрации пройдите по ссылке:</p>
                         <a href="' . $siteHost . '/user/validate/email/' . $this->email . '/key/' . $this->validateKey . '">Подтвердить email</a>';
         Mailer::emailSender($this->email, $subject, $content);
     }

     public function getUser() {
         return $this->user;
     }

 }
 