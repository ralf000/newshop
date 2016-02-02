<?php

 /* Пути по-умолчанию для поиска файлов */
 set_include_path(get_include_path()
         . PATH_SEPARATOR . 'app/controllers'
         . PATH_SEPARATOR . 'app/models'
         . PATH_SEPARATOR . 'app/services'
         . PATH_SEPARATOR . 'app/helpers'
 );

 /* Автозагрузчик классов */
 spl_autoload_register(function ($class) {
     include $class . '.class.php';
 });

 ini_set('session.use_only_cookies', true);

 /* Инициализация и запуск FrontController */
 $controller = FrontController::getInstance();
 $controller->route();

 /* Вывод данных */
 echo $controller->getPage();