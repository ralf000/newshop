<?php

 Class Helper {

     static function g($var) {
         echo '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/styles/default.min.css">
                <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/highlight.min.js"></script>
                <script>hljs.initHighlightingOnLoad();</script>';
         echo '<pre><code class="php" style="border: 1px solid black;">';
         if (is_array($var)) {
             print_r($var);
         } elseif (is_object($var)) {
             $class = get_class($var);
             Reflection::export(new ReflectionClass($class));
         } else {
             echo $var;
         }
         echo '</code></pre>';
     }

     static public function moveFile($inputName, $isMain, $id = NULL, $fileType = 'img') {
         if (!$id)
             $id   = date('d_m_Y');
         if ($fileType === 'img' || $fileType === 'image')
             $path = Path::IMG_UPLOAD_DIR . $id;
         elseif ($fileType === 'userimg')
             $path = Path::USERIMG_UPLOAD_DIR . $id;
         else
             $path = Path::FILE_UPLOAD_DIR . $id;
         if (!is_dir($path)) {
             if (!mkdir($path, 0777, TRUE))
                 die('Не удалось создать директорию ' . $path);
         }
         $prefix = $isMain ? 'main_' : '';

         if (!empty($_FILES[$inputName]['name'])) {
             //for multiple
             if (is_array($_FILES[$inputName]['name'])) {
                 foreach ($_FILES[$inputName]['name'] as $idx => $name) {
                     $uploadFile = $path . '/' . $prefix . self::strToLat($name);
                     copy($_FILES[$inputName]['tmp_name'][$idx], $uploadFile);
                 }
             } else {//for one file
                 $fileName   = self::strToLat($_FILES[$inputName]['name']);
                 $uploadFile = $path . '/' . $prefix . $fileName;
                 copy($_FILES[$inputName]['tmp_name'], $uploadFile);
             }
         } else {
             return FALSE;
         }
     }

     /**
      * Для перевода кириллицы в латиницу
      * @param $string - строка, которую нужно перевести
      * 
      * @return переведённую строку
      */
     static public function strToLat($string) {
         # Замена символов
         $replace = array(
             'а' => 'a', 'б' => 'b',
             'в' => 'v', 'г' => 'g',
             'д' => 'd', 'е' => 'e',
             'ё' => 'yo', 'ж' => 'j',
             'з' => 'z', 'и' => 'i',
             'й' => 'y', 'к' => 'k',
             'л' => 'l', 'м' => 'm',
             'н' => 'n', 'о' => 'o',
             'п' => 'p', 'р' => 'r',
             'с' => 's', 'т' => 't',
             'у' => 'u', 'ф' => 'f',
             'х' => 'h', 'ц' => 'ts',
             'ч' => 'ch', 'ш' => 'sh',
             'щ' => 'sch', 'ъ' => '',
             'ы' => 'i', 'ь' => '',
             'э' => 'e', 'ю' => 'ju',
             'я' => 'ja', ' ' => '-', '.' => '.'
         );
         # Переводим строку в нижний регистр
         $string  = mb_strtolower($string, 'utf-8');
         # Заменяем
         return $string  = strtr($string, $replace);
     }

     static public function generate($number) {
         $arr  = array('a', 'b', 'c', 'd', 'e', 'f',
             'g', 'h', 'i', 'j', 'k', 'l',
             'm', 'n', 'o', 'p', 'r', 's',
             't', 'u', 'v', 'x', 'y', 'z',
             'A', 'B', 'C', 'D', 'E', 'F',
             'G', 'H', 'I', 'J', 'K', 'L',
             'M', 'N', 'O', 'P', 'R', 'S',
             'T', 'U', 'V', 'X', 'Y', 'Z',
             '1', '2', '3', '4', '5', '6',
             '7', '8', '9', '0', '.', ',',
             '(', ')', '[', ']', '!', '?',
             '&', '^', '%', '@', '*', '$',
             '<', '>', '/', '|', '+', '-',
             '{', '}', '`', '~');
         // Генерируем пароль
         $pass = "";
         for ($i = 0; $i < $number; $i++) {
             // Вычисляем случайный индекс массива
             $index = rand(0, count($arr) - 1);
             $pass .= $arr[$index];
         }
         return md5($pass);
     }

     static function getSiteConfig() {
         return parse_ini_file(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config/site.ini');
     }

     static function clearDir($dir) {
         if ($objs = glob($dir . "/*")) {
             foreach ($objs as $obj) {
                 is_dir($obj) ? self::clearDir($obj) : unlink($obj);
             }
         }
     }

 }
 