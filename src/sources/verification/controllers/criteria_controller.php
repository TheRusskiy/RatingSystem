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
        $all = CriteriaDao::all_with_records();
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
        $criteria = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $criteria = new Criteria($criteria);
        CriteriaDao::insert($criteria);
        return json_encode($criteria->properties_for_json());
    }

    function delete(){
        $criteria_id = params("criteria_id");
        CriteriaDao::delete($criteria_id);
        return "";
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