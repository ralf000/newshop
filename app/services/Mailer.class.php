<?php

 class Mailer {

     static public function emailSender($mail, $subject = '', $content = '', $message = '') {
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
                            <a href="http://investmoscow.ru"><img style="float: left;" src="http://investmoscow.ru/media/2350142/logoleft.png" alt="">
                            </a>

                        </td>
                        <td>
                            <div class="title" style="height: 100px;float: left;padding: 10px;color: white;font-size: 14px;">
                                <p>Единый информационный</p>
                                <p style="text-transform: uppercase;">Инвестиционный портал</p>
                                <p style="text-transform: uppercase;">Города Москвы</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="center" style="float: right; padding-right: 30px;">
                <table>
                    <tr>
                        <td>
                            <a href="http://investmoscow.ru"><img style="float: left;" src="http://investmoscow.ru/media/2350143/logoright.png" alt="">
                            </a>

                        </td>
                        <td>
                            <div class="title" style="height: 100px;float: left;padding: 10px;color: white;font-size: 14px;">
                                <p style="text-transform: uppercase;">Официальный ресурс</p>
                                <p style="text-transform: uppercase;">Правительства Москвы</p>
                            </div>
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
                    <p style="text-transform: uppercase;">адрес: 119019, Москва, ул.Новый Арбат, д.11, стр.1 (м. Арбатская)</p>
                    <p style="text-transform: uppercase;">Единый телефон: +7 (495) 690-00-00</p>
                    <p style="text-transform: uppercase;">Факс: +7 (495) 691-05-06</p>
                    <p style="text-transform: uppercase;">Электронная почта: investmoscow@mos.ru</p>
                </div>
            </td>
            <td valign="center" style="float: right; padding-right: 30px;">
                <table>
                    <tr>
                        <td>
                            <a href="http://investmoscow.ru"><img style="float: left;" src="http://investmoscow.ru/media/2350141/bottomright.png" alt="">
                            </a>

                        </td>
                        <td>
                            <div class="title" style="height: 100px;float: left;padding: 10px;color: white;font-size: 14px;">
                                <p style="text-transform: uppercase;">Городское агентство</p>
                                <p style="text-transform: uppercase;">Управления инвестициями</p>
                            </div>
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

 }
 