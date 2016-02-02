<?php

interface CRUDInterface {
    
    public function addRecord();
    public function readAllRecords();
    public function readRecordsById();
    public function updateRecord();
    public function deleteRecord();
}
