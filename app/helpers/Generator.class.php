<?php

 namespace app\helpers;

 use app\controllers\FrontController;
 use app\services\Session;
 use app\widgets\AdminWidgets;

 class Generator {

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

     static function pagination($limit = 10, $page = 1, array $options = []) {
         $p = $page;
         if (!$options['num']) {
             $aw  = new AdminWidgets();
             $num = $aw->getNum($options['table']);
         } else {
             $num = $options['num'];
         }
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

         $fc         = FrontController::getInstance();
         $controller = $fc->getClearController();
         $action     = $fc->getClearAction();
         $link       = "/$controller/$action";
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

     static function sliderGenerator(array $slides) {
         $output = $list   = $active = $item   = '';
         $output .= '<div id="slider-carousel" class="carousel slide" data-ride="carousel">' . "\n";
         $output .= '<ol class = "carousel-indicators">' . "\n";

         for ($i = 0, $max = count($slides); $i < $max; $i++) {
             $active = ($i === 0) ? 'active' : '';
             $list .= '<li data-target = "#slider-carousel" data-slide-to = "' . $i . '" class = "' . $active . '"></li>' . "\n";
         }
         $output .= $list;
         $output .= '</ol >' . "\n";

         $output .= '<div class="carousel-inner">' . "\n";
         foreach ($slides as $key => $slide) {
             $active = ($key === 0) ? 'active' : '';
             $item .= '<div class="item ' . $active . '">' . "\n";

             $item .= '<div class="col-sm-6">' . "\n";
             $item .= '<h1><span>' . mb_substr($slide['title_h1'], 0, 1) . '</span>' . mb_substr($slide['title_h1'], 1) . '</h1>' . "\n"; //первый символ другого цвета
             $item .= '<h2>' . $slide['title_h2'] . '</h2>' . "\n";
             $item .= '<p>' . $slide['content'] . '</p>' . "\n";
             $item .= '<a href="' . $slide['link'] . '" class = "btn btn-default get">Подробнее</a>' . "\n";
             $item .= '</div>' . "\n";

             $item .= '<div class="col-sm-6">' . "\n";
             $item .= '<img src="\\' . $slide['image'] . '" alt="' . $slide['title_h1'] . '" style="width: 110%"/>' . "\n";
             $item .= '</div>' . "\n";

             $item .= '</div>' . "\n";
         }
         $output .= $item;
         $output .= '</div>' . "\n";

         $output .= '<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev"><i class="fa fa-angle-left"></i></a>' . "\n";
         $output .= '<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next"><i class="fa fa-angle-right"></i></a>' . "\n";

         $output .= '</div>';

         return $output;
     }

     public static function topMenu($menu, $user) {
         $output = '';
         if (empty($menu) || !is_array($menu))
             return FALSE;
         foreach ($menu as $v) {
             if ($user) {
                 if (strstr($v->link, strtolower('login')))
                     $output .= ' <li><a href = "/user/profile/id/'
                             . Session::get('user_id') . '"><i class = "' . $v->icon . '"></i>' . $user
                             . '</a></li>' . "\n";
                 else
                     $output .= ' <li><a href = "' . $v->link . '"><i class = "' . $v->icon . '"></i>' . $v->value . '</a></li>' . "\n";
             }else {
                 if (!strstr($v->link, strtolower('logout')))
                     $output .= ' <li><a href = "' . $v->link . '"><i class = "' . $v->icon . '"></i>' . $v->value . '</a></li>' . "\n";
             }
         }

         return $output;
     }

     public static function popularProducts(array $products) {
         $output = '';
         foreach ($products as $p) {
             if (!empty(p) && is_array($p)) {
                 $output .= '<div class="col-sm-4">' . "\n" . '
            <div class="product-image-wrapper">' . "\n" . '
                <div class="single-products">' . "\n" . '
                    <div class="productinfo text-center">' . "\n" . '
                        <img src="/' . $p['image'] . '" alt="' . $p['title'] . '" />' . "\n" . '
                        <h2>' . $p['price'] . ' <i class="fa fa-rub"></i></h2>' . "\n" . '
                        <p>' . $p['title'] . '</p>' . "\n" . '
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Добавить в корзину</a>' . "\n" . '
                    </div>' . "\n" . '
                    <div class="product-overlay">' . "\n" . '
                        <div class="overlay-content">' . "\n" . '
                            <h2>' . $p['price'] . ' <i class="fa fa-rub"></i></h2>' . "\n" . '
                            <p><a href="/product/view/id/' . $p['id'] . '" style="color: #fff;">' . $p['title'] . '</a></p>' . "\n" . '
                            <a href="/product/view/id/' . $p['id'] . '" class="btn" style="color: #fff;"><i class="fa  fa-arrow-right"></i> Подробнее</a>' . "\n" . '
                            <a href="' . $p['id'] . '" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Добавить в корзину</a>' . "\n" . '
                        </div>' . "\n" . '
                    </div>' . "\n" . '
                </div>' . "\n" . '
            </div>' . "\n" . '
        </div>' . "\n";
             }
         }
         return $output;
     }

     public static function recommendedProducts(array $products) {
         $output = '<div id = "recommended-item-carousel" class = "carousel slide" data-ride = "carousel">' . "\n";
         $output .= '<div class = "carousel-inner">' . "\n";
         $row    = $slides = '';
         foreach ($products as $key => $p) {
             $slides .= "\n" . '<div class = "col-sm-4">' . "\n";
             $slides .= '<div class = "product-image-wrapper">' . "\n";
             $slides .= '<div class = "single-products">' . "\n";
             $slides .= '<div class = "productinfo text-center">' . "\n";
             $slides .= '<img src = "/' . $p['image'] . '" alt = "' . $p['title'] . '" />' . "\n";
             $slides .= '<h2>' . $p['price'] . ' <i class="fa fa-rub"></i></h2>' . "\n";
             $slides .= '<p>' . $p['title'] . '</p>' . "\n";
             $slides .= '<a href = "' . $p['id'] . '" class = "btn btn-default add-to-cart"><i class = "fa fa-shopping-cart"></i>Добавить в корзину</a>' . "\n";
             $slides .= '</div>' . "\n";
             $slides .= '</div>' . "\n";
             $slides .= '</div>' . "\n";
             $slides .= '</div>' . "\n";

             ++$key;
             if ($key !== 0 && $key % 3 === 0 || --$key === Helper::getLastKeyOfArray($products)) {
                 $active = (empty($row)) ? ' active' : '';
                 $row .= '<div class = "item' . $active . '">' . $slides . '</div>' . "\n";
                 $slides = '';
             }
         }
         $output .= $row;
         $output .= '</div>' . "\n";
         $output .= '<a class = "left recommended-item-control" href = "#recommended-item-carousel" data-slide = "prev">
                <i class = "fa fa-angle-left"></i>
            </a>
            <a class = "right recommended-item-control" href = "#recommended-item-carousel" data-slide = "next">
                <i class = "fa fa-angle-right"></i>
            </a>' . "\n";
         $output .= '</div>' . "\n";
         return $output;
     }

     public static function getDeliveryDate() {
         return '<input type="date" name="deliveryDate" class="form-control" id="deliveryDate" min="' . date('Y-m-d', strtotime('+1 day')) . '" max="' . date('Y-m-d', strtotime('+6 days')) . '"/>';
     }

 }
 