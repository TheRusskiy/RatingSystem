<?php
require_once 'app_controller.php';
require_relative(__FILE__, '../dao/teachers_dao.php');
class TeachersController extends AppController{
    function index(){
        $on_page = 50;
        $page = intval(params("page", 1)) - 1;
        $teachers = TeachersDao::all($page, $on_page);
        $page_count = TeachersDao::count()/$on_page;
        $result=$this->render('teachers/index', array('teachers'=>$teachers, 'page_count'=>$page_count));
        return $this->wrap($result);
    }

}