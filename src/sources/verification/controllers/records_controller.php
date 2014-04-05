<?php
require_once 'app_controller.php';
//require_once '../';

class RecordsController extends AppController{
    function index(){
        $criteria = params("criteria");
        $all = RecordsDao::all($criteria);
        return json_encode($all) ;
    }
}