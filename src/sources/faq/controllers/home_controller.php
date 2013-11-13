<?php
require_once 'app_controller.php';

class HomeController extends AppController{
    function index(){
        $result="Welcome Home";
        return $this->wrap($result);
    }

}