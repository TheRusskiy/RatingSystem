<?php
require_once "param_processor.php";
require_once "criteria.php";
require_once "version.php";
require_once "date_splitter.php";
require_once "season.php";
require_once "rating_result.php";
class CriteriaCalculator {
    public function __construct($season = null) {
        if ($season == null){
            $season = SeasonsDAO::find(ParamProcessor::Instance()->get_season_id());
        }
        $this->season = $season;
    }

    public function calculate($version){
        $criteria = $version->getCriteria();
        $this->staff_id = ParamProcessor::Instance()->get_staff_id();
        $season = $this->season;
        $result = null;

        if (intval($version->year_2_limit)!=0){
            $result = $this->multi_year_result($version, $season);
        } else {
            $result = $this->type_aware_calculate($version, $season);
            $this->update_values_for_limits($version, $result);
        }
        $result->criteria = $criteria;
        $result->version = $version;
        return $result;
    }

    private function type_aware_calculate($version, $season){
        $criteria = $version->getCriteria();
        switch($criteria->fetch_type){
            case "sql":
                return $this->sql_calculate($version, $season);
            case "php":
                return $this->php_calculate($version, $season);
            case "manual":
                return $this->manual_calculate($version, $season);
            case "manual_options":
                return $this->manual_options_calculate($version, $season);
            default: throw new Exception("Unknown fetch type");
        }
    }


    private function sql_calculate($version, $season){
//        $criteria->has_records = true;
        $criteria = $version->getCriteria();
        $text_query = $criteria->fetch_value;
        $text_query = str_replace("@staff_id@", $this->staff_id, $text_query);
        $text_query = str_replace("@from_period_id@", $season->from_period, $text_query);
        $text_query = str_replace("@to_period_id@", $season->to_period, $text_query);
        $text_query = str_replace("@from_date@", $season->from_date, $text_query);
        $text_query = str_replace("@to_date@", $season->to_date, $text_query);
        $query = mysql_query($text_query);
        $row = mysql_fetch_array($query);
        $query_result = intval($row[0]);
//        $criteria->value = ($criteria->value===null) ? $query_result : $query_result + $criteria->value;
        $result = new RatingResult();
        $result->value = $query_result;
        return $result;
    }

    private function update_values_for_limits($version, $result)
    {
        $criteria = $version->getCriteria();
        if ($criteria->fetch_type == 'manual_options'){
            $this->update_values_for_limits_options($version, $result);
            return;
        }
        $initial_score = $result->value * $version->multiplier;
        if ($initial_score > $version->year_limit && $version->year_limit!=0) {
            $result->score = $version->year_limit;
            $result->value_with_limit = $version->year_limit / $version->multiplier;
        } else {
            $result->score = $initial_score;
            $result->value_with_limit = $result->value;
        }
    }
    private function update_values_for_limits_options($version, $result){
        $criteria = $version->getCriteria();
        $initial_score = 0;
        for($i = 0; $i<sizeof($version->multiplier); $i++){
            $initial_score+= $result->value[$i]*$version->multiplier[$i];
        }
        if ($initial_score > $version->year_limit  && $version->year_limit!=0) {
            $result->score = $version->year_limit;
            $result->value_with_limit = null;
        } else {
            $result->score = $initial_score;
            $result->value_with_limit = null;
        }
    }

    private function php_calculate($version, $season){
        ParamProcessor::Instance()->set_season_id($season->id);
        ParamProcessor::Instance()->set_season($season);
        $criteria = $version->getCriteria();
        $file_result = include(__DIR__."/../php_queries/".$criteria->fetch_value);
        $result = new RatingResult();
        $result->value = $file_result;
        return $result;
    }

    private function manual_calculate($version, $season){
        $criteria = $version->getCriteria();
        $query = mysql_query("SELECT * FROM rating_records " .
                             "WHERE ".
                             "staff_id=$this->staff_id " .
                             "AND criteria_id = $criteria->id " .
                             "AND date >='$season->from_date' " .
                             "AND date <='$season->to_date' ");
        $values = array();
        $records = array();
        while ($row = mysql_fetch_array($query)) {
            $records[]=$row;
            $values[] = $row['value'];
        }
        $sum = 0;
        foreach ($values as $v) {
            $sum += intval($v);
        }

        $result = new RatingResult();
        $result->value = $sum;
        $result->records = $records;
        return $result;
    }

    private function manual_options_calculate($version, $season){
        $criteria = $version->getCriteria();
        $query = mysql_query("SELECT * FROM rating_records " .
                             "WHERE ".
                             "staff_id=$this->staff_id " .
                             "AND criteria_id = $criteria->id " .
                             "AND date >='$season->from_date' " .
                             "AND date <='$season->to_date' ");
        $values = array();
        for($i = 0; $i<sizeof($version->multiplier); $i++){
            $values[$i]=0;
        }
        $records = array();
        while ($row = mysql_fetch_array($query)) {
            $records[]=$row;
            $values[$row['value']]++;
        }

        $result = new RatingResult();
        $result->value = $values;
        $result->records = $records;
        return $result;
    }

    private function multi_year_result($version, $season)
    {
        $criteria = $version->getCriteria();
        $current_season = $season;
        $seasons = array();
        while ($current_season != null) {
            $v = $current_season->getVersionFromCriteria($criteria->id);
            if ($v == null){
                break;
            }
            array_unshift($seasons, $current_season);
            $current_season = $current_season->previous();
        }
        $prev = null;
        foreach ($seasons as $season) {
            $version = $season->getVersionFromCriteria($criteria->id);
            $r = $this->type_aware_calculate($version, $season);
            $this->update_values_for_limits($version, $r);
            if ($prev != null && ($r->score + $prev->score > $version->year_2_limit)) {
                $r->score = $version->year_2_limit - $prev->score;
            }
            if ($criteria->fetch_type != 'manual_options') {
                $r->value_with_2_limit = ($r->score) / $version->multiplier;
            }
            if($prev != null){
                $r->previous_year_score = $prev->score;
            } else {
                $r->previous_year_score = null;
            }
            $prev = $r;
        }
        $result = $prev;
        return $result;
    }
}