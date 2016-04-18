<?php

use app\controllers\FrontController;
use app\helpers\Basket;
use app\services\Session;

/* Пути по-умолчанию для поиска файлов */
 set_include_path(get_include_path()
         . PATH_SEPARATOR . 'app/controllers'
         . PATH_SEPARATOR . 'app/models'
         . PATH_SEPARATOR . 'app/services'
         . PATH_SEPARATOR . 'app/helpers'
         . PATH_SEPARATOR . 'app/tests'
         . PATH_SEPARATOR . 'app/widgets'
         . PATH_SEPARATOR . 'app/dataContainers'
 );

 /* Автозагрузчик классов */
 spl_autoload_register(function ($class) {
     require_once $class . '.class.php';
 });

  //классы composer
 require_once '/app/extensions/vendor/autoload.php';
 
 Session::init();
 Basket::init();
 /* Инициализация и запуск FrontController */
 $controller = FrontController::getInstance();
 $controller->route();

 /* Вывод данных */
 echo $controller->getPage();
 