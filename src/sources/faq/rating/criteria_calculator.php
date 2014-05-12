<?php
require_once "param_processor.php";
require_once "criteria.php";
require_once "date_splitter.php";
require_once "season.php";
require_once "rating_result.php";
class CriteriaCalculator {
    public function __construct() {
        $this->season = SeasonsDAO::find(ParamProcessor::Instance()->get_season_id());
        $this->staff_id = ParamProcessor::Instance()->get_staff_id();
    }

    public function calculate($criteria){
        $season = $this->season;
        $result = null;

        if (intval($criteria->year_2_limit)!=0){
            $current_season = $season;
            $seasons = array();
            while ($current_season != null) {
                array_unshift($seasons, $current_season);
                $current_season = $current_season->previous();
            }
            $prev = null;
            foreach($seasons as $season){
                $r = $this->type_aware_calculate($criteria, $season);
                $this->update_values_for_limits($criteria, $r);
                if ($prev != null){
                    if ($r->score + $prev->score > $criteria->year_2_limit){
                        $r->score = $criteria->year_2_limit - $prev->score;

                    }
                }
                $r->value_with_2_limit = ($r->score) / $criteria->multiplier;
                $prev = $r;
            }
            $result = $prev;

        } else {
            $result = $this->type_aware_calculate($criteria, $season);
            $this->update_values_for_limits($criteria, $result);
        }
        return $result;
    }

    private function type_aware_calculate($criteria, $season){
        switch($criteria->fetch_type){
            case "sql":
                return $this->sql_calculate($criteria, $season);
            case "php":
                return $this->php_calculate($criteria, $season);
            case "manual":
                return $this->manual_calculate($criteria, $season);
            case "manual_options":
                return $this->manual_calculate($criteria, $season);
            default: throw new Exception("Unknown fetch type");
        }
    }


    private function sql_calculate($criteria, $season){
//        $criteria->has_records = true;
        $text_query = $criteria->fetch_value;
        $text_query = str_replace("@staff_id@", $this->staff_id, $text_query);
        $text_query = str_replace("@from_period_id@", $season->from_period, $text_query);
        $text_query = str_replace("@to_period_id@", $season->to_period, $text_query);
        $query = mysql_query($text_query);
        $row = mysql_fetch_array($query);
        $query_result = intval($row[0]);
//        $criteria->value = ($criteria->value===null) ? $query_result : $query_result + $criteria->value;
        $result = new RatingResult();
        $result->value = $query_result;
        return $result;
    }

    private function update_values_for_limits($criteria, $result)
    {
        $initial_score = $result->value * $criteria->multiplier;
        if ($initial_score > $criteria->year_limit) {
            $result->score = $criteria->year_limit;
            $result->value_with_limit = $criteria->year_limit / $criteria->multiplier;
        } else {
            $result->score = $initial_score;
            $result->value_with_limit = $result->value;
        }
    }

//    public function calculate($criteria){
//        $values = array();
//        $current_season = $this->season;
//        while($current_season != null){
//            $this->from_date = $current_season->from_date;
//            $this->to_date = $current_season->to_date;
//            $this->from_date_id = $current_season->from_period;
//            $this->to_date_id = $current_season->to_period;
//            $values[]= $this->with_limit($criteria->year_limit,
//                $this->calculate_for_current_dates($criteria)
//            );
//            $current_season = $current_season->previous();
//        }
//        $result = $this->sum($values);
//        $criteria->result =$result;
//        return $result;
//    }

//    public function calculate_for_season($criteria, $season){
//        $values = array();
//        for ($i=0; $i<count($this->dates); $i=$i+2){
//            $this->from_date = $this->dates[$i];
//            $this->to_date = $this->dates[$i+1];
//            $this->from_date_id = $this->date_ids[$i];
//            $this->to_date_id = $this->date_ids[$i+1];
//            $values[]= $this->with_limit($criteria->year_limit,
//                $this->calculate_for_current_dates($criteria)
//            );
//        }
//        $result = $this->sum($values);
//        $criteria->result =$result;
//        return $result;
//    }
//
//    private function with_limit($limit, $value){
//        if ($value > $limit && $limit != 0){
//            return $limit;
//        } else {
//            return $value;
//        }
//    }
//

//
//    private function php_calculate($criteria){
//        $criteria->has_records = true;
//        $file_result = include($criteria->fetch_value);
//        $criteria->value = ($criteria->value===null) ? $file_result : $file_result + $criteria->value;
//        return $file_result * $criteria->multiplier;
//    }
//
//    private function manual_calculate($criteria){
//        $query = mysql_query("SELECT * FROM rating_records " .
//                             "WHERE ".
//                             "staff_id=$this->staff_id " .
//                             "AND criteria_id = $criteria->id " .
//                             "AND date >='$this->from_date' " .
//                             "AND date <='$this->to_date' ");
//        $values = array();
//        while ($row = mysql_fetch_array($query)) {
//            $criteria->has_records = true;
//            $criteria->records[]=$row;
//            $values[] = $row['value'];
//        }
//        if ($criteria->fetch_type == 'manual'){
//            $values_acc = $criteria->value;
//            $values_acc = $values_acc === null ? 0 : $values_acc;
//            for ($i=0; $i<count($values); $i++){
//                $values_acc+=$values[$i];
//                $values[$i] = $values[$i] * $criteria->multiplier;
//            }
//            $criteria->value = $values_acc;
//        } else if ($criteria->fetch_type == 'manual_options'){
//            $option_values_acc = $criteria->value;
//            if ($option_values_acc === null){
//                $option_values_acc = array_fill(0, sizeof($criteria->multiplier), 0);
//            }
//            for ($i=0; $i<count($values); $i++){
//                $option_values_acc[$values[$i]]+=1;
//                $values[$i] = $criteria->multiplier[intval($values[$i])];
//            }
//            $criteria->value = $option_values_acc;
//        } else {
//            throw new Exception("Unknown fetch type");
//        }
//        $result = $this->sum($values);
//        return $result;
//    }
//
//    private function sum($values){
//        $result = 0;
//        foreach($values as $v){
//            $result+=$v;
//        }
//        return $result;
//    }
}