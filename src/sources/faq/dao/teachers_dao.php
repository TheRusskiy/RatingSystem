<?php

class TeachersDao {
    static function all($page=null, $count=null, $search = null){
        $limiter = "";
        $filter = TeachersDao::filter($search);
        if ($page!==null) {
            $from = $page * $count;
            $limiter = "ORDER BY id
                        LIMIT" . " $count OFFSET $from";
        }
        $teachers_query = mysql_query("
            SELECT *
            FROM staff2
            WHERE ".$filter."
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
            FROM staff2
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

    static function filter($search){
        if ($search=== null || trim($search)===""){
            return " 1=1 ";
        }
        $tokens = explode(' ', $search);
        $r="";
        foreach ($tokens as $i => $t) {
            $t=strtolower($t);
            $r.=" (LOWER(name) LIKE '%$t%' OR ";
            $r.="LOWER(surname) LIKE '%$t%' )";
            if ($i!==sizeof($tokens)-1){
                $r.=' AND ';
            }
        }
        return $r;
    }
}