<?php
require_once 'app_controller.php';

class HomeController extends AppController{
    function index(){
        $result=render('home/home');
        return $this->wrap($result);
    }
}