<?php
require_once 'app_controller.php';
require_relative(__FILE__, '../dao/teachers_dao.php');
require_relative(__FILE__, '../rating/criteria_calculator.php');
class TeachersController extends AppController{
    function index(){
        $on_page = 50;
        $page = intval(params("page", 1));
        $teachers = TeachersDao::all($page-1, $on_page);
        $page_count = TeachersDao::count()/$on_page;
        $result=render('teachers/index', array(
            'teachers'=>$teachers,
            'page_count'=>$page_count,
            'page'=> $page));
        return $this->wrap($result);
    }

    function show(){
        $id = intval(params("id"));
        $teacher = TeachersDao::find($id);
        $criteria = CriteriaDao::all();
        $calculator = new CriteriaCalculator();
        foreach($criteria as $c){
            $calculator->calculate($c);
        }
        $result=render('teachers/show', array(
            'teacher'=>$teacher,
            'criteria'=>$criteria));
        return $this->wrap($result);
    }

}