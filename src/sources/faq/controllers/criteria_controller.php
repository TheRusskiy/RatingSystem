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

}