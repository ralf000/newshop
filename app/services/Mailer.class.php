<?php

 namespace app\services;

use app\helpers\Helper;
use app\helpers\Validate;
use Exception;

 class Mailer {

     static private $data = [];

     static public function emailHandler($to = FALSE) {
         try {
             if (!$to)
                 $to = Helper::getSiteConfig()->contactinfo->siteMail->value;
             if (empty(self::$data))
                 throw new Exception('Класс не инициализирован должным образом');
             self::emailSender((string) $to, self::$data['subject'], self::$data['message'], self::$data['email']);
             return TRUE;
         } catch (Exception $ex) {
             Session::setUserMsg('Пожалуйста, заполните все поля формы', 'danger');
             header('Location: ' . $_SERVER['REQUEST_URI']);
         }
     }

     static public function emailSender($mail, $subject = '', $content = '', $from = '', $message = '') {
         if (empty($message)) {
             $message = <<<_HTML_
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
        table {border-collapse: collapse;}
    </style>
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body style="width: 100%; padding: 0; margin: 0; font-family: serif;min-width: 100%;">
    <table cellpadding="10" width="100%" style="border-spacing: 0;font-family: sans-serif;">
        <tr style="background: #42718f">
            <td valign="center" style="padding-left: 30px;">
                <table>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <div class="title" style="height: 100px;float: left;padding: 10px;color: white;font-size: 14px;">
                                <p style="text-transform: uppercase;">Магазин</p>
                                <p style="text-transform: uppercase;">NewShop</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="center" style="float: right; padding-right: 30px;">
                <table>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: 5px solid #437290;">
                <div style="padding: 20px;">
                    <!--контент здесь-->
                    $content
                </div>
            </td>
        </tr>
        <tr style="background: #42718f">
            <td valign="center" style="padding-left: 30px; padding-bottom: 40px;">
                <div class="title" style="height: 100px;float: left;padding: 10px;color: white;font-size: 12px;">
                    <p style="text-transform: uppercase;">адрес: Химки, ул. Пролетарская д. 23</p>
                    <p style="text-transform: uppercase;">Телефон: +2346 17 38 93</p>
                    <p style="text-transform: uppercase;">Факс: 1-714-252-0026</p>
                    <p style="text-transform: uppercase;">Электронная почта: info@newshop.ru</p>
                </div>
            </td>
            <td valign="center" style="float: right; padding-right: 30px;">
                <table>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
_HTML_;
         }

         $headers = "MIME-Version: 1.0" . "\r\n";
         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

         $headers .= 'From: <aaa@aaa.ru>' . "\r\n";
         $headers .= 'Cc: ' . "\r\n";

         if (mail($mail, $subject, $message, $headers))
             return TRUE;
     }

     public static function setData(array $data, $method = 'POST') {
         foreach ($data as $k => $v) {
             $filter         = ($k === 'email') ? 'email' : 'str';
             self::$data[$k] = Validate::validateInputVar($k, $method, $filter);
         }
     }

     public function getData() {
         return self::$data;
     }

 }
 