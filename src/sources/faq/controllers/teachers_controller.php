<?php
require_once 'app_controller.php';
require_relative(__FILE__, '../dao/teachers_dao.php');
require_relative(__FILE__, '../rating/criteria_calculator.php');
require_relative(__FILE__, '../dao/records_dao.php');
require_relative(__FILE__, '../dao/seasons_dao.php');
class TeachersController extends AppController{
    function index(){
        $on_page = 50;
        $page = intval(params("page", 1));
        $from = session('from_date');
        $to = session('to_date');
        $teachers = TeachersDao::all($from, $to, $page-1, $on_page, params('search'));
        $page_count = TeachersDao::count(params('search'))/$on_page;
        return $this->wrap('teachers/index', array(
            'teachers'=>$teachers,
            'page_count'=>$page_count,
            'page'=> $page,
            'script'=>'teachers/index'));
    }

    function total_rating(){
        $teachers = TeachersDao::all();
        $criteria = CriteriaDao::all();
        if(params('season_id')==null){
            $all = SeasonsDao::all();
            ParamProcessor::Instance()->set_season_id($all[0]->id);
        }
        $seasons = SeasonsDao::all();
        $season = SeasonsDao::find(ParamProcessor::Instance()->get_season_id());
        $calculator = new CriteriaCalculator();
        foreach($teachers as $i=>$t){
            ParamProcessor::Instance()->set_staff_id($t['id']);
            $ratings = array();
            $total = 0;
            foreach($criteria as $c){
                $result = $calculator->calculate($c);
                $ratings[]=$result;
                $total+=$result->score;
            }
            $teachers[$i]['ratings'] = $ratings;
            $teachers[$i]['total_rating'] = $total;
        }
        return $this->wrap('teachers/total_rating', array(
            'seasons'=>$seasons,
            'season'=>$season,
            'criteria'=>$criteria,
            'container_class'=>'',
            'teachers'=>$teachers));
    }

    function show(){
        $id = intval(params("id"));
        $teacher = TeachersDao::find($id);
        $criteria = CriteriaDao::all();
        if(params('season_id')==null){
            $all = SeasonsDao::all();
            ParamProcessor::Instance()->set_season_id($all[0]->id);
        }
        ParamProcessor::Instance()->set_staff_id(params('id'));
        $calculator = new CriteriaCalculator();
        $results = array();
        foreach($criteria as $c){
            $results[]=$calculator->calculate($c);
        }
        $seasons = SeasonsDao::all();
        $season = SeasonsDao::find(ParamProcessor::Instance()->get_season_id());
        return $this->wrap('teachers/show', array(
            'teacher'=>$teacher,
            'criteria'=>$criteria,
            'results'=>$results,
            'seasons'=>$seasons,
            'season'=>$season,
            'script'=>'teachers/show'
        ));
    }
}