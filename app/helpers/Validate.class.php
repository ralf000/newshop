<?php

 class Validate {

//     static function filterPost(array $postVars) {
//         $output = [];
//         foreach ($postVars as $value) {
//             $key          = $value;
//             $value        = filter_input(INPUT_POST, $key);
//             $output[$key] = $value;
//         }
//         return $output;
//     }

     static function validateVar($name, $method, $type = '') {
         switch ($type) {
             case 'int' || 'integer': $filter = 'FILTER_SANITIZE_NUMBER_INT';
                 break;
             case 'str' || 'string': $filter = 'FILTER_SANITIZE_STRING';
                 break;
             case 'url': $filter = 'FILTER_SANITIZE_URL';
                 break;
             case 'email': $filter = 'FILTER_SANITIZE_EMAIL';
                 break;
             default: $filter = 'FILTER_DEFAULT';
                 break;
         }
         if (!defined($method)) {
             if (!preg_match('/^input/i', $method))
                 $method = 'INPUT_' . strtoupper($method);
         }
         $method = constant($method);
         $filter = constant($filter);
         if (filter_has_var($method, $name))
             return filter_input($method, $name, $filter);
     }

 }
 