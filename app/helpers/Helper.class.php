<?php

 namespace app\helpers;

use app\widgets\AdminWidgets;
use Reflection;
use ReflectionClass;
use function mb_strtolower;

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

     static function deleteFile($file) {
         if (file_exists($file))
             unlink($file) or die('Не могу удалить файл ' . $file);
         return TRUE;
     }

     static function deleteDir($dir, $type = 'img') {
         $rootDir = ($type === 'img') ? Path::IMG_UPLOAD_DIR : Path::FILE_UPLOAD_DIR;
         self::_searchDir($rootDir, $dir);
     }

     private static function _searchDir($rootDir, $dir) {
         foreach (scandir($rootDir) as $d) {
             if ($d !== '.' && $d !== '..' && is_dir($rootDir . $d)) {
                 if ($d == $dir) {
                     self::_removeDir($rootDir . $d);
                     return TRUE;
                 } else {
                     self::_searchDir($rootDir . $d, $dir);
                 }
             }
         }
     }

     public static function _removeDir($path) {
         return is_file($path) ?
                 @unlink($path) :
                 array_map(['Helper', '_removeDir'], glob($path . "/*")) == @rmdir($path);
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

     static function pagination($limit = 10, $page = 1, array $options = []) {
         $p     = $page;
         $aw    = new AdminWidgets();
         $num   = $aw->getNum('product');
         $pages = round($num / $limit);

         if ($page == 0)
             $page = 1;
         if ($page == 1) {
             $disabledP = 'disabled';
         } else if ($page == $pages) {
             $disabledN = 'disabled';
         } else {
             $disabled = '';
         }

         $link = '/admin/allProducts';
         if (!empty($options)) {
             foreach ($options as $key => $value) {
                 if (!empty($value))
                     $link .= "/$key/$value";
             }
         }

         $output = '';
         $output .= '<ul class="pagination">' . "\n";
         $output .= '<li class="' . $disabledP . '" id="previous">' . "\n";
         $output .= '<a href="' . $link . '/page/' . --$p . '" aria-controls="pgn" data-dt-idx="0" tabindex="0">&laquo;</a>' . "\n";
         $output .= '</li>' . "\n";

         for ($i = 1; $i <= $pages; $i++) {
             if ($page == $i)
                 $active = 'active';
             else
                 $active = '';
             $output .= '<li class="paginate_button ' . $active . '">' . "\n";
             $output .= '<a href="' . $link . '/page/' . $i . '" aria-controls="pgn" data-dt-idx="' . $i . '" tabindex="0">' . $i . '</a>' . "\n";
             $output .= '</li>' . "\n";
         }

         $output .= '<li class="paginate_button next ' . $disabledN . '" id="next">' . "\n";

         $output .= '<a href="' . $link . '/page/' . ++$page . '" aria-controls="pgn" data-dt-idx="' . ++$page . '" tabindex="0">&raquo;</a>' . "\n";
         $output .= '</li>' . "\n";
         $output .= '</ul>' . "\n";

         return $output;
     }

     static public function dateConverter($date) {
         return date('d-m-Y H:i:s', strtotime($date));
     }

     static public function tableToBootstrap($html, $replacement = '<table class="table table-bordered table-stripped">') {
         $pattern = '/<table.*?>/';
         return preg_replace($pattern, $replacement, $html);
     }

     static function clearUrl($url) {
         $pieces = parse_url($url);
         return $pieces['path'];
     }
 }
 