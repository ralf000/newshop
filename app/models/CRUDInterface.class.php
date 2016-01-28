<?php

interface CRUDInterface {
    
    public function addRecord();
    public function readAllRecords();
    public function readOneRecord();
    public function updateRecord();
    public function deleteRecord();
}
