<?php

 namespace app\dataContainers;

use app\helpers\Helper;

 class Article {

     protected $data = [];

     function __construct(array $data) {
         $this->data = $data;
         $this->data['mainimage'] = $this->getRelativeLink($this->data['mainimage']);
         $this->data['content'] = $this->cleanImgSrc($this->data['content']);
     }

     private function getRelativeLink($link) {
         return str_replace('//', '/', substr($link, strpos($link, 'upload')));
     }
     
     private function cleanImgSrc($data) {
         return str_replace(Helper::getSiteConfig()->general->siteHost, '', $data);
     }

     function getData() {
         return $this->data;
     }

 }
 