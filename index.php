<?php

use app\controllers\FrontController;
use app\services\Session;

/* Пути по-умолчанию для поиска файлов */
 set_include_path(get_include_path()
         . PATH_SEPARATOR . 'app/controllers'
         . PATH_SEPARATOR . 'app/models'
         . PATH_SEPARATOR . 'app/services'
         . PATH_SEPARATOR . 'app/helpers'
         . PATH_SEPARATOR . 'app/tests'
         . PATH_SEPARATOR . 'app/widgets'
 );

 /* Автозагрузчик классов */
 spl_autoload_register(function ($class) {
     require_once $class . '.class.php';
 });

$url = 'http://examples.com/sub/subdir?id=1&val=test#hash';
echo app\helpers\Helper::clearUrl($url);
 exit;
 
 Session::init();

 /* Инициализация и запуск FrontController */
 $controller = FrontController::getInstance();
 $controller->route();

 /* Вывод данных */
 echo $controller->getPage();
 