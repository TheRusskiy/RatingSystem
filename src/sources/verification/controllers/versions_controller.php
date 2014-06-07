<?php
require_once 'app_controller.php';
require_once(__DIR__."/../../faq/dao/seasons_dao.php");
require_once(__DIR__."/../../faq/dao/versions_dao.php");
require_once(__DIR__."/../../faq/rating/version.php");

class VersionsController extends AppController
{
    function index()
    {
        $all = VersionsDao::all();
        $all_json = array();
        foreach($all as $c){
            $all_json[]=$c->properties_for_json();
        }
        return json_encode($all_json);
    }

    function create(){
        $version = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $version = new Version($version);
        $version = VersionsDao::insert($version);
        return json_encode($version->properties_for_json());
    }

    function delete(){
        $version_id = params("version_id");
        VersionsDao::delete($version_id);
        return "";
    }

    function update(){
        $version = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $version = new Version($version);
        VersionsDao::update($version);
        return json_encode($version->properties_for_json());
    }
}