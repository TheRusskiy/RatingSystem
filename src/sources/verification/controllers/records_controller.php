<?php
require_once 'app_controller.php';
//require_once '../';

class RecordsController extends AppController{
    function index(){
        $criteria = params("criteria");
        $all = RecordsDao::all($criteria);
        return json_encode($all) ;
    }

    function create(){
        $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $record = RecordsDao::upsert_from_object($record, $this->current_user());
        return json_encode($record);
    }

    function update(){
        $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
//        $record = json_decode(file_get_contents("php://input"), true);
        $record = RecordsDao::upsert_from_object($record, $this->current_user());
        return json_encode($record);
    }
}