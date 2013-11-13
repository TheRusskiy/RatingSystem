<?php
require_once 'app_controller.php';

class SessionsController extends AppController{
    function logout(){
        session('user_id', null);
        redirect('/');
    }

}