<?php
require_once 'app_controller.php';
//require_once '../';

class TeachersController extends AppController{
    function index(){
        $all = TeachersDao::all();
        return json_encode($all) ;
    }
}