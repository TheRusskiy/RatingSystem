<?php
require_once 'app_controller.php';

class CriteriaController extends AppController{
    function index(){
        $result=$this->render('criteria/index');
        return $this->wrap($result);
    }

}