<?php

 namespace app\helpers;

 use app\services\Session;
 use Reflection;
 use ReflectionClass;
 use function mb_substr;

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
         elseif ($fileType === 'slide')
             $path = Path::IMG_UPLOAD_DIR_SLIDER . $id;
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
                     $uploadFile = $path . '/' . $prefix . Generator::strToLat($name);
                     copy($_FILES[$inputName]['tmp_name'][$idx], $uploadFile);
                 }
             } else {//for one file
                 $fileName   = Generator::strToLat($_FILES[$inputName]['name']);
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
         switch ($type) {
             case 'img': $rootDir = Path::IMG_UPLOAD_DIR;
                 break;
             case 'slider': $rootDir = Path::IMG_UPLOAD_DIR_SLIDER;
                 break;
             default : $rootDir = Path::FILE_UPLOAD_DIR;
         }
         self::_searchDir($rootDir, $dir);
     }
     
     static function mb_ucfirst($str, $enc = 'utf-8') {
         return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc) . mb_substr($str, 1, mb_strlen($str, $enc), $enc);
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

     private static function _removeDir($path) {
         return is_file($path) ?
                 @unlink($path) :
                 array_map(['self', '_removeDir'], glob($path . "/*")) == @rmdir($path);
     }

     static function getSiteConfig() {
         $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config/site.json';
         $json = file_get_contents($path);
         return json_decode($json);
     }

     static function clearDir($dir) {
         if ($objs = glob($dir . "/*")) {
             foreach ($objs as $obj) {
                 is_dir($obj) ? self::clearDir($obj) : unlink($obj);
             }
         }
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

     static function getIconForUserProfileBYAdmin($action = 'insert') {
         $icon = '';
         switch ($action) {
             case 'insert': $icon = 'fa fa-plus-circle bg-green';
                 break;
             case 'update': $icon = 'fa fa-refresh bg-blue';
                 break;
             case 'delete': $icon = 'fa fa-minus-circle bg-red';
                 break;
             default : $icon = 'fa fa-check-square bg-blue';
         }
         return $icon;
     }

     static function strSplitter($str, $length = 21) {
         $dots = (strlen($str) > $length) ? '...' : '';
         return mb_substr($str, 0, $length) . $dots;
     }

     static function redirectChecker() {
         if (filter_has_var(INPUT_GET, 'redirect')) {
             Session::set('redirect', filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_URL));
             if (filter_has_var(INPUT_GET, 'hash'))
                 Session::set('redirectHash', filter_input(INPUT_GET, 'hash', FILTER_SANITIZE_STRING));
         }else {
             return FALSE;
         }
     }

     static function getRedirect() {
         $redirect['url']  = Session::get('redirect');
         $redirect['hash'] = Session::get('redirectHash');
         Session::unseted(['redirect', 'redirectHash']);
         return $redirect;
     }

     static function getLastKeyOfArray(array $array) {
         end($array);
         $lastKey = key($array);
         reset($array);
         return (int) $lastKey;
     }

     static function getInStockForClients($quantity) {
         $result = '';
         switch ($quantity) {
             case $quantity > 50: $result = 'очень много';
                 break;
             case $quantity > 30: $result = 'много';
                 break;
             case $quantity > 10: $result = 'заканчивается';
                 break;
             default : 'в наличии';
                 break;
         }
         return $result;
     }

 }
 