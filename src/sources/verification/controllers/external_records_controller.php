<?php
require_once 'app_controller.php';

class ExternalRecordsController extends AppController{
    function index(){
        $criteria = params("criteria");
        $all = ExternalRecordsDao::all($criteria);
        return json_encode($all);
    }

    function create(){
        $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $record = ExternalRecordsDao::upsert_from_object($record, $this->current_user());
        return json_encode($record);
    }

    function delete(){
        $record_id = params("record_id");
        $r = array();
        $r["id"] = $record_id;
        ExternalRecordsDao::delete(array($r));
        return "";
    }

    function approve(){
        ExternalRecordsDao::approve(params("id"));
    }
    function reject(){
        ExternalRecordsDao::reject(params("id"));
    }
}