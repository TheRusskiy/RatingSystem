<?php
require_once 'app_controller.php';

class HomeController extends AppController{
    function index(){
        return $this->wrap('home/home');
    }
    function help(){
        return $this->wrap('home/help');
    }
}