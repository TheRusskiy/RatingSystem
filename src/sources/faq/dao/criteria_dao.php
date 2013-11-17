<?php
class CriteriaDao {
    static function all($page=null, $count=null){
        $limiter = "";
        if ($page!==null) {
            $from = $page * $count;
            $limiter = "ORDER BY id
                        LIMIT" . " $count OFFSET $from";
        }
        $query = mysql_query("
            SELECT id, name, fetch_type, fetch_value, multiplier, calculation_type, year_limit
            FROM criteria
            $limiter
            ");
        $result = array();
        while ($row = mysql_fetch_array($query)){
            $result[]= new Criteria($row);
        }
        return $result;
    }

    static function count(){
        $count_query = mysql_query("
            SELECT count(*)
            FROM criteria
            ");
        $row = mysql_fetch_array($count_query);
        return $row[0];
    }

}