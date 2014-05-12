<?php
require_once "param_processor.php";
require_once "criteria.php";
require_once "date_splitter.php";
require_once "season.php";
class CriteriaCalculator {
    public function __construct() {
        $from_date = null;
        $to_date = null;
        if (ParamProcessor::Instance()->get_season_id()){
            $season = SeasonsDAO::find(ParamProcessor::Instance()->get_season_id());
            $from_date = $season->from_date;
            $to_date = $season->to_date;
        } else {
            $from_date = ParamProcessor::Instance()->get_from_date();
            $to_date = ParamProcessor::Instance()->get_to_date();
        }
        $this->staff_id = ParamProcessor::Instance()->get_staff_id();

        $splitter = new DateSplitter();
        $this->dates = $splitter->split($from_date, $to_date);
        $this->date_ids = array();
        foreach($this->dates as $d){
            $this->date_ids[] = Season::period_from_date($d);
        }
    }

    public function calculate($criteria){
        $values = array();
        for ($i=0; $i<count($this->dates); $i=$i+2){
            $this->from_date = $this->dates[$i];
            $this->to_date = $this->dates[$i+1];
            $this->from_date_id = $this->date_ids[$i];
            $this->to_date_id = $this->date_ids[$i+1];
            $values[]= $this->with_limit($criteria->year_limit,
                $this->calculate_for_current_dates($criteria)
            );
        }
        $result = $this->sum($values);
        $criteria->result =$result;
        return $result;
    }

    public function calculate_for_season($criteria, $season){
        $values = array();
        for ($i=0; $i<count($this->dates); $i=$i+2){
            $this->from_date = $this->dates[$i];
            $this->to_date = $this->dates[$i+1];
            $this->from_date_id = $this->date_ids[$i];
            $this->to_date_id = $this->date_ids[$i+1];
            $values[]= $this->with_limit($criteria->year_limit,
                $this->calculate_for_current_dates($criteria)
            );
        }
        $result = $this->sum($values);
        $criteria->result =$result;
        return $result;
    }

    private function with_limit($limit, $value){
        if ($value > $limit && $limit != 0){
            return $limit;
        } else {
            return $value;
        }
    }
    private function calculate_for_current_dates($criteria){
        switch($criteria->fetch_type){
            case "sql":
                return $this->sql_calculate($criteria);
            case "php":
                return $this->php_calculate($criteria);
            case "manual":
                return $this->manual_calculate($criteria);
            case "manual_options":
                return $this->manual_calculate($criteria);
            default: throw new Exception("Unknown fetch type");
        }
    }

    private function sql_calculate($criteria){
        $criteria->has_records = true;
        $text_query = $criteria->fetch_value;
        $text_query = str_replace("@staff_id@", $this->staff_id, $text_query);
        $text_query = str_replace("@from_period_id@", $this->from_date_id, $text_query);
        $text_query = str_replace("@to_period_id@", $this->to_date_id, $text_query);
        $query = mysql_query($text_query);
        $row = mysql_fetch_array($query);
        $query_result = intval($row[0]);
        $criteria->value = ($criteria->value===null) ? $query_result : $query_result + $criteria->value;
        return $query_result * $criteria->multiplier;
    }

    private function php_calculate($criteria){
        $criteria->has_records = true;
        $file_result = include($criteria->fetch_value);
        $criteria->value = ($criteria->value===null) ? $file_result : $file_result + $criteria->value;
        return $file_result * $criteria->multiplier;
    }

    private function manual_calculate($criteria){
        $query = mysql_query("SELECT * FROM rating_records " .
                             "WHERE ".
                             "staff_id=$this->staff_id " .
                             "AND criteria_id = $criteria->id " .
                             "AND date >='$this->from_date' " .
                             "AND date <='$this->to_date' ");
        $values = array();
        while ($row = mysql_fetch_array($query)) {
            $criteria->has_records = true;
            $criteria->records[]=$row;
            $values[] = $row['value'];
        }
        if ($criteria->fetch_type == 'manual'){
            $values_acc = $criteria->value;
            $values_acc = $values_acc === null ? 0 : $values_acc;
            for ($i=0; $i<count($values); $i++){
                $values_acc+=$values[$i];
                $values[$i] = $values[$i] * $criteria->multiplier;
            }
            $criteria->value = $values_acc;
        } else if ($criteria->fetch_type == 'manual_options'){
            $option_values_acc = $criteria->value;
            if ($option_values_acc === null){
                $option_values_acc = array_fill(0, sizeof($criteria->multiplier), 0);
            }
            for ($i=0; $i<count($values); $i++){
                $option_values_acc[$values[$i]]+=1;
                $values[$i] = $criteria->multiplier[intval($values[$i])];
            }
            $criteria->value = $option_values_acc;
        } else {
            throw new Exception("Unknown fetch type");
        }
        $result = $this->sum($values);
        return $result;
    }

    private function sum($values){
        $result = 0;
        foreach($values as $v){
            $result+=$v;
        }
        return $result;
    }
}