<?php

class TeachersDao {
    static function all($from_date, $to_date, $page=null, $count=null, $search = null){
        $limiter = "";
        $filter = TeachersDao::filter($search);
        if ($page!==null) {
            $from_page = $page * $count;
            $limiter = "ORDER BY s.id
                        LIMIT" . " $count OFFSET $from_page";
        }
        $teachers_query = mysql_query("
            SELECT s.*, c.value, c.is_data_complete
            FROM staff2 s
            LEFT JOIN cached_rating c ON
            (s.id = c.staff_id
            AND c.date_from='$from_date'
            AND c.date_to='$to_date')
            WHERE
            ".$filter."
            $limiter
            ");
        $teachers = array();
        while ($row = mysql_fetch_array($teachers_query)){
            $teachers[]= $row;
        }
        return $teachers;
    }

    static function count($search = null){
        $filter = TeachersDao::filter($search);
        $count_query = mysql_query("
            SELECT count(*)
            FROM staff2 s
            WHERE $filter
            ");
        $row = mysql_fetch_array($count_query);
        return $row[0];
    }

    static function find($id){
        $count_query = mysql_query("
            SELECT *
            FROM staff2
            WHERE id = $id
            LIMIT 1
            ");
        $row = mysql_fetch_array($count_query);
        return $row;
    }

    static function cache($id, $from, $to, $value, $is_data_complete){
        $query = mysql_query("
            DELETE FROM cached_rating
            WHERE staff_id = $id AND date_from = '$from' AND date_to = '$to'
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $query = mysql_query("
            INSERT INTO cached_rating (staff_id, date_from, date_to, value, is_data_complete)
            VALUES($id, '$from', '$to', $value, $is_data_complete)
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    private static function filter($search){
        $search = mysql_real_escape_string($search);
        if ($search=== null || trim($search)===""){
            return " 1=1 ";
        }
        $tokens = explode(' ', $search);
        $r="";
        foreach ($tokens as $i => $t) {
            $t=strtolower($t);
            $r.=" (LOWER(s.name) LIKE '%$t%' OR ";
            $r.="LOWER(s.surname) LIKE '%$t%' )";
            if ($i!==sizeof($tokens)-1){
                $r.=' AND ';
            }
        }
        return $r;
    }
}