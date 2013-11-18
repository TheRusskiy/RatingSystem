<?php

class TeachersDao {
    static function all($page=null, $count=null){
        $limiter = "";
        if ($page!==null) {
            $from = $page * $count;
            $limiter = "ORDER BY id
                        LIMIT" . " $count OFFSET $from";
        }
        $teachers_query = mysql_query("
            SELECT *
            FROM staff2
            $limiter
            ");
        $teachers = array();
        while ($row = mysql_fetch_array($teachers_query)){
            $teachers[]= $row;
        }
        return $teachers;
    }

    static function count(){
        $count_query = mysql_query("
            SELECT count(*)
            FROM staff2
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

}