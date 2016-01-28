<?php

 class Product {

     public $title;
     public $article;
     public $created;

     function __construct($title, $article, $created) {
         $this->title = $title;
         $this->article = $article;
         $this->created = $created;
     }

 }
 