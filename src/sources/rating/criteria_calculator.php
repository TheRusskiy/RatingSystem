<?php
require_once "criteria.php";
class CriteriaCalculator {
    function __construct() {
        if (isset($_REQUEST['from_date'])){
            $this->from_date = mysql_real_escape_string($_REQUEST['from_date']);
        }
        if (isset($_REQUEST['to_date'])){
            $this->to_date = mysql_real_escape_string($_REQUEST['to_date']);
        }
        if (isset($_REQUEST['staff_id'])){
            $this->staff_id = mysql_real_escape_string($_REQUEST['staff_id']);
        }
    }

    function calculate($criteria){
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
        $query = mysql_query($criteria->fetch_value);
        $row = mysql_fetch_array($query);
        $query_result = intval($row[0]);
        return $query_result * $criteria->multiplier;
    }

    private function php_calculate($criteria){
        $file_result = (include $criteria->fetch_value);
        return $file_result * $criteria->multiplier;
    }

    private function manual_calculate($criteria){
        $query = mysql_query("SELECT value FROM rating_entries " .
                             "WHERE ".
                             "staff_id=$this->staff_id " .
                             "AND criteria_id = $criteria->id " .
                             "AND date >='$this->from_date' " .
                             "AND date <='$this->to_date' ");
        $values = array();
        while ($row = mysql_fetch_array($query)) {
            $values[] = $row[0];
        }
        if ($criteria->fetch_type == 'manual'){
            for ($i=0; $i<count($values); $i++){
                $values[$i] = $values[$i] * $criteria->multiplier;
            }
        } else if ($criteria->fetch_type == 'manual_options'){
            for ($i=0; $i<count($values); $i++){
                $values[$i] = $criteria->multiplier[intval($values[$i])];
            }
        } else {
            throw new Exception("Unknown fetch type");
        }
        switch($criteria->calculation_type){
            case "sum": $result = $this->sum($values); break;
            case "max": $result = $this->max($values); break;
            // exists unsupported for manual_options!!
            case "exists": $result = $this->exists($values) * $criteria->multiplier; break;
            default: throw new Exception("Unknown calculation type");
        }
        return $result;
    }

    private function sum($values){
        $result = 0;
        foreach($values as $v){
            $result+=$v;
        }
        return $result;
    }

    private function max($values){
        $result = 0;
        foreach($values as $v){
            if ($v>$result){
                $result = $v;
            }
        }
        return $result;
    }
    private function exists($values){
        $result = 0;
        foreach($values as $v){
            if ($v>0){
                $result = 1;
            }
        }
        return $result;
    }
}