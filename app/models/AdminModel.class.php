<?php

 class AdminModel extends Model {

     private $widgetsData = [], $data        = [], $title       = '';

     public function __construct($title = '', $subTitle = '') {
         $this->title = $title;
         $userModel   = new UserTableModel();
         $userModel->setId(Session::get('user_id'));
         $userModel->setTable('user');
         $userModel->readRecordsById('id', '`id`,`username`, `full_name`, `photo`, `email`');
         $userModel->readUserAddress();
         $userModel->readUserPhones();
         $this->setData(['title' => $title, 'subTitle' => $subTitle, 'user' => $userModel->getRecordsById()[0], 'userContacts' => $userModel->getUserContacts()]);
     }

     public function breadCrumbs() {
         $pages = [
             'admin'   => 'Главная',
             'profile' => 'Профиль пользователя',
             'add'     => 'Добавление новых товаров'
         ];
         $output = '';
         $link = '';
         
         $path   = parse_url($_SERVER['REQUEST_URI']);
         $parts  = explode('/', $path['path']);
         $parts  = array_diff($parts, ['']); //delete empty elements in in array
         $output = '<ol class = "breadcrumb">';
         foreach ($parts as $part) {
             $link .= '/'.$part;
             $output .= '<li><a href = "' . $link . '"><i class = ""></i> '. $pages[$part] .' </a></li>';
         }
         $output .= '</ol >';
         return $output;
     }

     function getWidgetsData() {
         return $this->widgetsData;
     }

     function setWidgetsData(array $widgetsData) {
         $this->widgetsData = $widgetsData;
     }

     public function setData(array $data) {
         array_push($this->data, $data);
     }

     function getData() {
         return $this->data;
     }

 }
 