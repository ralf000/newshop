<?php

 namespace app\controllers;

 use app\models\Model;
 use app\services\Session;
 use ReflectionClass;

 class FrontController implements IController {

     private $_controller, $_action, $_params, $_head, $_header, $_body, $_footer, $_page, $_beforeEvent, $_afterEvent;
     private static $_instance;

     static function getInstance() {
         if (!(self::$_instance instanceof self))
             self::$_instance = new self;
         return self::$_instance;
     }

     private function __construct() {
         $this->_beforeEvent = 'beforeEvent';
         $this->_afterEvent  = 'afterEvent';

         $request           = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
         $urlComponents     = parse_url($request);
         $path              = explode('/', trim($urlComponents['path'], '/'));
         $params            = [];
         parse_str($urlComponents['query'], $params);
         $this->_controller = !empty($path[0]) ? ucfirst($path[0]) . 'Controller' : 'IndexController';
         $this->_action     = !empty($path[1]) ? $path[1] . 'Action' : 'indexAction';
         if (count($path) > 2 && !empty($path[3])) {
             $path   = array_slice($path, 2);
             $keys   = $values = [];
             for ($i = 1, $max = count($path); $i <= $max; $i++) {
                 if ($i % 2 === 1)
                     $keys[]   = $path[$i - 1];
                 else
                     $values[] = $path[$i - 1];
             }
             $this->_params = array_combine($keys, $values);
         }
         if (!empty($this->getParams())) {
             if (!empty($params))
                 $this->_params = array_merge($this->getParams(), $params);
         } else {
             $this->_params = !empty($params) ? $params : NULL;
         }
     }

     public function route() {
         if (class_exists(__NAMESPACE__ . '\\' . $this->getController())) {
             $rc = new ReflectionClass(__NAMESPACE__ . '\\' . $this->getController());
             if ($rc->implementsInterface(__NAMESPACE__ . '\\' . 'IController')) {
                 if ($rc->hasMethod($this->getAction())) {
                     $controller = $rc->newInstance();
                     // invoke methods before action
                     if ($rc->hasMethod($this->getBeforeEvent())) {
                         //event must returned true
                         $beforeEvent = $rc->getMethod($this->getBeforeEvent());
                         if ($beforeEvent->invoke($controller, $this->getAction())) {
                             $method = $rc->getMethod($this->getAction());
                             $method->invoke($controller);
                         } else {
                             $this->redirToAuth();
                         }
                     }
                 } else {
                     http_response_code(404);
                     echo 'Action "' . $this->getAction() . '" not found';
                     exit;
                 }
             } else {
                 http_response_code(404);
                 echo "Interface not found";
                 exit;
             }
         } else {
             http_response_code(404);
             echo 'Controller "' . $this->getController() . '" not found';
             exit;
         }
     }

     private function redirToAuth() {
         Session::set('referer', $_SERVER['REQUEST_URI']);
         if (!Session::get('user_id')) {
             if ($this->getController() === 'AdminController') {
                 header('Location: /admin/login');
                 exit;
             } else {
                 header('Location: /user/login');
                 exit;
             }
         } else {
             $model  = new Model();
             $output = $model->render('../views/status/403.php', 'status');
             $this->setPage($output);
         }
     }

     public function getController() {
         return $this->_controller;
     }

     public function getClearController() {
         return strtolower(substr($this->_controller, 0, strpos($this->_controller, 'Controller')));
     }

     public function getAction() {
         return $this->_action;
     }

     public function getClearAction() {
         return strtolower(substr($this->_action, 0, strpos($this->_action, 'Action')));
     }

     public function getBeforeEvent() {
         return $this->_beforeEvent;
     }

     public function getAfterEvent() {
         return $this->_beforeEvent;
     }

     function getParams() {
         return $this->_params;
     }

     function setBody($body) {
         $this->_body = $body;
     }

     function getBody() {
         return $this->_body;
     }

     function setPage($page) {
         $this->_page = $page;
     }

     function getPage() {
         return $this->_page;
     }

     function setHead($head) {
         $this->_head = $head;
     }

     function getHead() {
         return $this->_head;
     }

     function setFooter($footer) {
         $this->_footer = $footer;
     }

     function getFooter() {
         return $this->_footer;
     }

 }
 