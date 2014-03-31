<?php
require_once 'app_controller.php';

class UserController extends AppController{
//    function index(){
//    }
    function current(){
        $user = array();
        $user['id'] = 201;
        return json_encode($user) ;
    }
}