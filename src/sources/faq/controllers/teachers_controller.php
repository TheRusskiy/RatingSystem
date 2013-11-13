<?php
require_once 'app_controller.php';

class TeachersController extends AppController{
    function index(){
        $result=$this->render('teachers/index');
        return $this->wrap($result);
    }

}