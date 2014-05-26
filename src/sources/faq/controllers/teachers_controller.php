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
        $teachers = TeachersDao::all($page-1, $on_page, params('search'));
        $all_teachers = TeachersDao::all();
        $teacher_names = array();
        foreach($all_teachers as $t){
            array_push($teacher_names, "{$t['surname']} {$t['name']} {$t['secondname']}");
        }
        $page_count = TeachersDao::count(params('search'))/$on_page;
        return $this->wrap('teachers/index', array(
            'teachers'=>$teachers,
            'page_count'=>$page_count,
            'page'=> $page,
            'teacher_names'=>$teacher_names,
            'script'=>'teachers/index'));
    }

    function total_rating(){
        $html = "";
        $cached_html = mysql_get_cache('total_rating_html');
        if ($cached_html ){
            $html = mb_convert_encoding($cached_html, "utf-8", "windows-1251");
        } else {
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
            $teachers = arrayToObject($teachers);
            $html =  $this->wrap('teachers/total_rating', array(
                'seasons'=>$seasons,
                'season'=>$season,
                'criteria'=>$criteria,
                'container_class'=>'',
                'teachers'=>$teachers));
            $html_cp1251 = mb_convert_encoding($html, "windows-1251", "utf-8");
            mysql_set_cache('total_rating_html', $html_cp1251, 60);
        }
        $etag=md5($html);
        $headers = apache_request_headers();
        $old_etag = "invalid etag";
        if (isset($headers['If-None-Match'])){
            $old_etag = $headers['If-None-Match'];
        }
        header("Etag: $etag");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        if ($old_etag==$etag){
            header("HTTP/1.0 304 Not Modified");
            exit();
        } else {
            return $html;
        }
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