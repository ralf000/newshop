<?php

 Class Helper {

     static function g($var) {
         echo '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/styles/default.min.css">
                <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.0.0/highlight.min.js"></script>
                <script>hljs.initHighlightingOnLoad();</script>';
         echo '<pre><code class="php" style="border: 1px solid black;">';
         if (is_array($var) || is_object($var)) {
             print_r($var);
         } else {
             echo $var;
         }
         echo '</code></pre>';
     }

     static public function moveFile($inputName, $fileType = 'img') {
         if ($fileType === 'img' || $fileType === 'image')
             $path = TableModelAbstract::IMG_UPLOAD_DIR;
         else
             $path = TableModelAbstract::FILE_UPLOAD_DIR;
         echo is_dir($path);
         if (!is_dir($path)) {
             if (!mkdir($path, 0777, TRUE))
                 die('Не удалось создать директории ' . $path);
         }
         $uploadFile = $path . $_FILES[$inputName]['name'];
         return (copy($_FILES[$inputName]['tmp_name'], $uploadFile)) ? TRUE : FALSE;
     }

//     static function arrToStr(array $array, $flag){
//         if ($flag){
//             $output = '';
//             $cnt = 1;
//             foreach ($array as $v){
//                 if ($cnt === 1)
//                    $output .= ':'.$v;
//                 else
//                     $output .= ',:'.$v;
//                 $cnt++;
//             }
//             return $output;
//         }
//         return implode(',', $array);
//     }
 }
 