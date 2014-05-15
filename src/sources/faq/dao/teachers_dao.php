<?php

class TeachersDao {
    static function all($page=null, $count=null, $search = null){
        $limiter = "";
        $filter = TeachersDao::filter($search);
        if ($page!==null) {
            $from_page = $page * $count;
            $limiter = "ORDER BY s.id
                        LIMIT" . " $count OFFSET $from_page";
        }
        $teachers_query = mysql_query("
            SELECT s.*, FLOOR(TO_DAYS(NOW()) - TO_DAYS(s.birthday)) as age, d.name as department
            FROM staff2 s
            JOIN depstaff ds ON
            (s.id = ds.id_staff
            AND ds.rateacc > 0.6
            )
            JOIN dep d ON
            (d.id = ds.id_dep)
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
            JOIN depstaff ds ON
            (s.id = ds.id_staff
            AND ds.rateacc > 0.6
            )
            JOIN dep d ON
            (d.id = ds.id_dep)
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

    private static function filter($search){
        $search = mysql_real_escape_string($search);
        if ($search=== null || trim($search)===""){
            return " 1=1 ";
        }
        $tokens = explode(' ', $search);
        $r="";
        foreach ($tokens as $i => $t) {
            $t=strtolower($t);
            $t=trim($t);
            $r.=" (LOWER(s.name) LIKE '%$t%' OR ";
            $r.="LOWER(s.secondname) LIKE '%$t%' OR ";
            $r.="LOWER(s.surname) LIKE '%$t%' )";
            if ($i!==sizeof($tokens)-1){
                $r.=' AND ';
            }
        }
        return $r;
    }
}