<?php

 namespace app\helpers;

 use Exception;

 class SiteConfigurator {

     private $data = [], $json;

     function setPostData($data) {
         $method = 'INPUT_POST';
         foreach ($data as $k => $v) {
             if (is_array($v)) {
                 foreach ($v as $subK => $subV) {
                     foreach ($subV as $subSubK => $subSubV) {
                         $this->data[$k][$subK][$subSubK] = filter_var($subSubV, FILTER_SANITIZE_STRING);
                     }
                 }
             } else {
                 $type           = ($k === 'currentCategoryWidget') ? 'int' : 'str';
                 $this->data[$k] = Validate::validateInputVar($k, $method, $type);
             }
         }
     }

     private function siteCfgJsonCreator() {
         try {
             $json = $this->getSiteConfig();
             if (!$json)
                 throw new Exception('Не могу получить настроечный файл');
             $d    = $this->data;
             $json->general->siteName          = $d['siteName'];
             $json->contactinfo->sitePhone->icon = $d['sitePhoneIcon'];
             $json->contactinfo->sitePhone->value     = $d['sitePhone'];
             $json->contactinfo->siteMail->icon = $d['siteEmailIcon'];
             $json->contactinfo->siteMail->value = $d['siteEmail'];
             $json->social = [];
             foreach ($d['social'] as $k => $v) {
                 $json->social[] = $v;
             }
             $json->topmenu = [];
             foreach ($d['topmenu'] as $k => $v) {
                 $json->topmenu[] = $v;
             }
             $json->currentCategoryWidget = $d['currentCategoryWidget'];
             $this->json                  = $json;
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function getSiteConfig() {
         return json_decode(file_get_contents(Path::SITE_CONFIG . 'site.json'));
     }

     public function setSiteConfig() {
         $this->siteCfgJsonCreator();
         return file_put_contents(Path::SITE_CONFIG . 'site.json', json_encode($this->json));
     }

     public function setData($value, $key = NULL) {
         if ($key === NULL)
             $this->data[]     = $value;
         else
             $this->data[$key] = $value;
     }

     public function getData() {
         return $this->data;
     }
    
  }
 