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
        $record = RecordsDao::create_from_object($record, $this->current_user());
        return json_encode($record);
    }
}