<?php

class WidgetAbstract{
    protected $db;
    
    function __construct() {
        $this->db = DB::init()->connect();
    }

}

