<?php
require_once 'app_controller.php';
require_relative(__FILE__, '../dao/criteria_dao.php');
class CriteriaController extends AppController{
    function index(){
        $on_page = 50;
        $page = intval(params("page", 1));
        $criteria = CriteriaDao::all($page-1, $on_page);
        $page_count = CriteriaDao::count()/$on_page;
        return $this->wrap('criteria/index', array(
            'criteria'=>$criteria,
            'page_count'=>$page_count,
            'page'=> $page));
    }

    function new_criteria(){
        $criteria = new Criteria();
        return $this->wrap('criteria/new_criteria', array(
            'criteria'=>$criteria,
            'script'=>'criteria/_form'));
    }

    function edit(){
        $criteria = CriteriaDao::find(params('id'));
        return $this->wrap('criteria/edit_criteria', array(
            'criteria'=>$criteria,
            'script'=>'criteria/_form'));
    }

    function upsert(){
        $criteria = new Criteria($_REQUEST);
        if($criteria->id !== null && $criteria->id !== ""){
            CriteriaDao::update($criteria);
            flash('notice', 'Критерий успешно обновлён');
        } else {
            CriteriaDao::insert($criteria);
            flash('notice', 'Критерий успешно создан');
        }
        TeachersDao::flush_cache();
        redirect('/', array('controller'=>'criteria', 'action'=>'index'));
    }

    function delete(){
        CriteriaDao::delete(params('id'));
        flash('notice', 'Критерий успешно удалён');
        redirect('/', array('controller'=>'criteria', 'action'=>'index'));
    }

}