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

    function calculate_rating(){
        $id = intval(params("id"));
        $teacher = TeachersDao::find($id);
        $criteria = CriteriaDao::all();
        $calculator = new CriteriaCalculator();
        foreach($criteria as $c){
            $calculator->calculate($c);
        }
        TeachersDao::cache(
            $id,
            session('from_date'),
            session('to_date'),
            $this->get_result_value($criteria),
            $this->get_result_completeness($criteria)
        );
        return $this->get_result($criteria);
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

    private function get_result($criteria){
        $sum = 0;
        $warning="";
        foreach($criteria as $c){
            $warning = "";
            $sum+=$c->result;
            if (!$c->has_records){
                $warning='(?)';
            }
        }
        return $sum.$warning;
    }
    private function get_result_value($criteria){
        $sum = 0;
        foreach($criteria as $c){
            $sum+=$c->result;
        }
        return $sum;
    }
    private function get_result_completeness($criteria){
        $warning=1;
        foreach($criteria as $c){
            if (!$c->has_records){
                $warning=0;
            }
        }
        return $warning;
    }
}