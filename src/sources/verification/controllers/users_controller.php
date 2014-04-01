<?php
require_once 'app_controller.php';
//require_once '../';

class UsersController extends AppController{
//    function index(){
//    }
    function current(){
        session('user_id');
        $user = array();
        $user['id'] = 201;
        return json_encode($this->current_user()) ;
    }
}