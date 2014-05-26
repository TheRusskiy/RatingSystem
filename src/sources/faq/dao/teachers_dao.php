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
        $query = "
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
            ";
        $query = mysql_query($query);
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $teachers = array();
        while ($row = mysql_fetch_array($query)){
            $teachers[]= $row;
        }
        return $teachers;
    }

    static function count($search = null){
        $filter = TeachersDao::filter($search);
        $query = mysql_query("
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
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $row = mysql_fetch_array($query);
        return $row[0];
    }

    static function find($id){
        $query = mysql_query("
            SELECT *
            FROM staff2
            WHERE id = $id
            LIMIT 1
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $row = mysql_fetch_array($query);
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
//            $t=mb_strtolower($t, 'utf-8');
            $t=trim($t);
//            $t = mb_convert_encoding($t, "windows-1251", "utf-8");
            $r.=" (s.name LIKE '%$t%' OR \n";
            $r.="s.secondname LIKE '%$t%' OR \n";
            $r.="s.surname LIKE '%$t%' )\n"; //COLLATE cp1251_general_ci
            if ($i!==sizeof($tokens)-1){
                $r.=' AND ';
            }
        }
        return $r;
    }
}