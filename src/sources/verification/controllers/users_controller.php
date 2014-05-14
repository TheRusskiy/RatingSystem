<?php
require_once 'app_controller.php';
//require_once '../';

class UsersController extends AppController{
    function current(){
        return json_encode($this->current_user()) ;
    }
    function index(){
        $users = UsersDao::all();
        $user_attrs = array();
        foreach($users as $u){
            array_push($user_attrs, $u->attributes());
        }
        return json_encode($user_attrs);
    }
    function update(){
        $user_json = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        $user = UsersDao::find($user_json->id);
        $string = User::permissions_to_string($user_json->permissions);
        $user->set_permissions_from_string($string);
        $user->role = $user_json->role;
        UsersDao::update_permissions($user);
        return json_encode($user->attributes());
    }
}