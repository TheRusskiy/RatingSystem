<?php
require_once 'app_controller.php';
require_once(__DIR__."/../../faq/dao/criteria_dao.php");

class CriteriaController extends AppController
{
    function index()
    {
        $all = CriteriaDao::all();
        $all_json = array();
        foreach($all as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }
    function with_records()
    {
        $all = CriteriaDao::all();
        $all_json = array();
        foreach($all as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }
    function show()
    {
        $c = CriteriaDao::find(params('id'));
        return json_encode($c->properties_for_json());
    }

    function create(){
        $record = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        return json_encode($record);
//        $record = RecordsDao::upsert_from_object($record, $this->current_user());
//        return json_encode($record);
    }

    function update(){
        $criteria = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $criteria = new Criteria($criteria);
        CriteriaDao::update($criteria);
        return json_encode($criteria->properties_for_json());
    }

    function fetch_types()
    {
        $all = Criteria::fetch_types_index();
        return json_encode($all);
    }
    function calculation_types()
    {
        $all = Criteria::calculation_types_index();
        return json_encode($all);
    }
}