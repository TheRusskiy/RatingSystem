<?php
require_once 'app_controller.php';

class HomeController extends AppController{
    function index(){
        $ts = TeachersDao::all();
        $teacher_names = array();
        foreach($ts as $t){
            array_push($teacher_names, "{$t['surname']} {$t['name']} {$t['secondname']}");
        }
        return $this->wrap('home/home', array(
            'container_class'=>'',
            'teacher_names'=>$teacher_names
        ));
    }
    function help(){
        return $this->wrap('home/help');
    }
}