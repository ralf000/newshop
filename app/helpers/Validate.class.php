<?php
 class Validate {

     /**
      * Фильтрует переменную, переданную методами post или get
      * @param string $name имя переменной (ключ в массиве post или get)
      * @param string $method константа метода, которым передана переменная (например 'INPUT_POST')
      * @param string $type тип переменной
      * @return mixed отфильтрованная переменная
      */
     static function validateVar($name, $method, $type = 'FILTER_DEFAULT') {
         switch ($type) {
             case 'int': $filter = FILTER_SANITIZE_NUMBER_INT; break;
             case 'str': $filter = FILTER_SANITIZE_STRING; break;
             case 'url': $filter = FILTER_SANITIZE_URL; break;
             case 'email': $filter = FILTER_SANITIZE_EMAIL; break;
             default: $filter = FILTER_DEFAULT;
         }
         if (!defined($method)) {
             if (!preg_match('/^input/i', $method))
                 $method = 'INPUT_' . strtoupper($method);
         }
         $method = constant($method);
         if (filter_has_var($method, $name))
             return filter_input($method, $name, $filter);
     }
     
     /**
      * Проверяет, присутствует ли в таблице значение 
      * @param PDO $db дескриптор соединения
      * @param string $table имя базы, с которой идет работа
      * @param string $searchField имя поля, по которому идет проверка
      * @param string $value значение, по которому идет проверка
      * @return bool true если нет совпадений
      */
     static function validateValue(PDO $db, $table, $searchField, $value){
         $st = $db->prepare("SELECT COUNT(*) FROM $table WHERE $searchField = :value");
         $st->execute([':value' => $value]);
         $result = $st->fetchColumn(0);
         return (empty($result)) ? TRUE : FALSE;
     }
 }
 