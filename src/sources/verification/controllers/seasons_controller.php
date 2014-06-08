<?php
require_once 'app_controller.php';
require_once(__DIR__."/../../faq/dao/seasons_dao.php");

class SeasonsController extends AppController
{
    function index()
    {
        $all = SeasonsDao::all();
        $all_json = array();
        foreach($all as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }
    function index_criteria()
    {
        $all = SeasonsDao::all_criteria_versions(params("season_id"));
        $all_json = array();
        foreach($all as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }
    function show()
    {
        $s = SeasonsDao::find(params("id"));
        return json_encode($s->properties_for_json());
    }

    function create(){
        $season = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $season = new Season($season->new_id, $season->from_date, $season->to_date);
        $season = SeasonsDao::insert($season);
        return json_encode($season->properties_for_json());
    }

    function replace_criteria(){
        $season_criteria = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $season_id = $season_criteria->season_id;
        $season_criteria = $season_criteria->season_criteria;
        SeasonsDao::delete_criteria_versions($season_id);
        SeasonsDao::insert_criteria_versions($season_criteria, $season_id);
        $season_criteria = SeasonsDao::all_criteria_versions($season_id);
        $all_json = array();
        foreach($season_criteria as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }

    function delete(){
        $season_id = params("season_id");
        SeasonsDao::delete($season_id);
        return "";
    }

    function update(){
        $season = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $new_id = $season->id;
        if (isset($season->new_id)){
            $new_id = $season->new_id;
        }
        $season = new Season($season->id, $season->from_date, $season->to_date);
        SeasonsDao::update($season, $new_id);
        return json_encode($season->properties_for_json());
    }
}