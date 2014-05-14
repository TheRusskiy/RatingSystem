<?php
require_once 'app_controller.php';
//require_once '../';

class RecordsController extends AppController{
    function index(){
        $criteria = params("criteria_id");
        $page = params("page");
        $page_length = params("page_length");
        $all = RecordsDao::all($criteria, $page, $page_length);
        return json_encode($all);
    }

    function search(){
        $criteria = params("criteria_id");
        $page = params("page");
        $page_length = params("page_length");
        $search = json_decode(params("search"));
        $all = RecordsDao::all($criteria, $page, $page_length, $search);
        return json_encode($all);
    }

    function count(){
        $criteria = params("criteria_id");
        $count = RecordsDao::count($criteria);
        $obj = array();
        $obj["count"] = $count;
        return json_encode($obj);
    }

    function search_count(){
        $criteria = params("criteria_id");
        $search = json_decode(params("search"));
        $count = RecordsDao::count($criteria, $search);
        $obj = array();
        $obj["count"] = $count;
        return json_encode($obj);
    }

    function create(){
        $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $record = RecordsDao::upsert_from_object($record, $this->current_user());
        return json_encode($record);
    }

    function update(){
        $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $record = RecordsDao::upsert_from_object($record, $this->current_user());
        return json_encode($record);
    }

    function delete(){
        $record_id = params("record_id");
        $r = array();
        $r["id"] = $record_id;
        RecordsDao::delete(array($r));
        return "";
    }
}