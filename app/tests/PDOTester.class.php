<?php

class PDOTester extends PDO {

     public function __construct($dsn, $username = null, $password = null, $driver_options = array()) {
         parent::__construct($dsn, $username, $password, $driver_options);
         $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('PDOStatementTester', array($this)));
     }

 }
 