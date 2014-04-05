<?php
require_once 'app_controller.php';
require_once(__DIR__."/../../faq/dao/criteria_dao.php");

class CriteriaController extends AppController
{
    function index()
    {
        $criteria = params("criteria");
        $all = CriteriaDao::all($criteria);
        $all_json = array();
        foreach($all as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }
}