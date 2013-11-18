<?php
require_once 'app_controller.php';
require_relative(__FILE__, '../dao/teachers_dao.php');
require_relative(__FILE__, '../rating/criteria_calculator.php');
require_relative(__FILE__, '../dao/records_dao.php');
class TeachersController extends AppController{
    function index(){
        $on_page = 50;
        $page = intval(params("page", 1));
        $teachers = TeachersDao::all($page-1, $on_page);
        $page_count = TeachersDao::count()/$on_page;
        return $this->wrap('teachers/index', array(
            'teachers'=>$teachers,
            'page_count'=>$page_count,
            'page'=> $page));
    }

    function show(){
        $id = intval(params("id"));
        $teacher = TeachersDao::find($id);
        $criteria = CriteriaDao::all();
        $calculator = new CriteriaCalculator();
        foreach($criteria as $c){
            $calculator->calculate($c);
        }
        return $this->wrap('teachers/show', array(
            'teacher'=>$teacher,
            'criteria'=>$criteria,
            'script'=>'teachers/show'));
    }

    function save_records(){
        try {
            ob_start(); //todelete in production
            $records = params('records');
            $to_delete = array();
            $to_update = array();
            $to_create = array();
            foreach ($records as $r) {
                if (isset($r['id']) && $r['id']!=null && $r['action']!=='delete'){
                    $to_update[]=$r;
                }elseif (isset($r['id']) && $r['id']!=null && $r['action']==='delete'){
                    $to_delete[]=$r;
                } elseif ($r['action']==='create'){
                    $to_create[]=$r;
                } else {
                    throw new Exception("Unknown record action!");
                }
            }
            RecordsDao::create($to_create);
            RecordsDao::update($to_update);
            RecordsDao::delete($to_delete);
            $xhtml = ob_get_clean();
            flash('notice', "Записи успешно обновлены");
            redirect("/", array('controller'=>'teachers', 'action'=>'show', 'id'=>params('staff_id')));
        } catch(Exception $e){
            $xhtml = ob_get_clean();
            flash('error', $e->getMessage().$xhtml);
            redirect("/", array('controller'=>'teachers', 'action'=>'show', 'id'=>params('staff_id')));
        }
    }

}