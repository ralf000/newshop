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
         $pages  = [
             'profile'     => 'Профиль пользователя',
             'add'         => 'Добавление новых товаров',
             'allProducts' => 'Все товары',
             'page'        => 'Страница',
             'view'        => 'Просмотр',
             'product' => 'Товар'
         ];
         $output = '';
         $link   = '';

         $fc     = FrontController::getInstance();
         $action = $fc->getAction();
         $action = $fc->getClearAction();
         $params = $fc->getParams() ? array_diff($fc->getParams(), ['']) : [];
         $output = '<ol class = "breadcrumb">';
         if (!(empty($action) || $action === 'index'))
             $output .= '<li><a href = "/admin"><i class = ""></i> Главная </a></li>';
         $output .= '<li><a href = "/admin/'.$action.'"><i class = ""></i>' . $pages[$action] . '</a></li>';
         foreach ($params as $key => $value) {
             $link .= '/' . $value;
             $output .= '<li><a href = "/admin/'.$action.'/'. $key.'/'.$value.'"><i class = ""></i> ' . $pages[$key] . ' ' . $value . ' </a></li>';
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
 