<?php

 class FrontController implements IController {

     private $_controller, $_action, $_params, $_head, $_header, $_body, $_footer, $_page;
     private static $_instance;

     static function getInstance() {
         if (!(self::$_instance instanceof self))
             self::$_instance = new self;
         return self::$_instance;
     }

     private function __construct() {
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
                     $keys[]   = $path[0];
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
         if (class_exists($this->getController())) {
             $rc = new ReflectionClass($this->getController());
             if ($rc->implementsInterface('IController')) {
                 if ($rc->hasMethod($this->getAction())) {
                     $controller = $rc->newInstance();
                     $method     = $rc->getMethod($this->getAction());
                     $method->invoke($controller);
                 } else
                     throw new Exception('Action');
             } else
                 throw new Exception('Interface');
         } else
             throw new Exception('Controller');
     }

     function getController() {
         return $this->_controller;
     }

     function getAction() {
         return $this->_action;
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
     
     function setPage($page){
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
 