<?php

 namespace app\dataContainers;

 class Slide {

     protected $titleH1, $titleH2, $content, $link, $image, $publiched;

     function __construct($titleH1, $titleH2, $content, $link, $image, $publiched) {
         $this->titleH1    = $titleH1;
         $this->titleH2    = $titleH2;
         $this->content    = $content;
         $this->link       = $link;
         $this->image      = $image;
         $this->publiched = (int) $publiched;
     }

     function getTitleH1() {
         return $this->titleH1;
     }

     function getTitleH2() {
         return $this->titleH2;
     }

     function getContent() {
         return $this->content;
     }

     function getLink() {
         return $this->link;
     }

     function getImage() {
         return $this->image;
     }
     
     function getPublished() {
         return $this->publiched;
     }

 }
 