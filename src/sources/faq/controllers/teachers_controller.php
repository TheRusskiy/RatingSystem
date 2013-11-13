<?php
require_once 'app_controller.php';
class TeachersController extends AppController{
    function index(){
        $on_page = 50;
        $page = intval(params("page", 1)) - 1;
        $start_record = $page * $on_page;
        $teachers_query = mysql_query("
            SELECT id, shortname
            FROM staff2
            ORDER BY id
            LIMIT" . " $on_page OFFSET $start_record
            ");
        $teachers = array();
        while ($row = mysql_fetch_array($teachers_query)){
            $teachers[]= $row;
        }
        $count_query = mysql_query("
            SELECT count(*)
            FROM staff2
            ");
        $row = mysql_fetch_array($count_query);
        $page_count = $row[0]/$on_page;
        $result=$this->render('teachers/index', array('teachers'=>$teachers, 'page_count'=>$page_count));
        return $this->wrap($result);
    }

}