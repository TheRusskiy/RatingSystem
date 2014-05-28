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
            SELECT
                s.id as id,
                s.shortname as shortname,
                s.surname as surname,
                s.secondname as secondname,
                s.name as name,
                d.name as department
            FROM staff2 s
            JOIN depstaff ds ON
            (s.id = ds.id_staff
            )
            JOIN dep d ON
            (d.id = ds.id_dep)
            WHERE
            d.id_deptype = 30278001
            $filter
            GROUP BY s.id, s.shortname, s.secondname, s.surname, s.name, d.name
            HAVING SUM(ds.rateacc) > 0.2
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
            FROM(
                SELECT s.id
                FROM staff2 s
                JOIN depstaff ds ON
                (s.id = ds.id_staff
                )
                JOIN dep d ON
                (d.id = ds.id_dep)
                WHERE
                d.id_deptype = 30278001
                $filter
                GROUP BY s.id
                HAVING SUM(ds.rateacc) > 0.2
                ) filtered
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
            return " AND 1=1";
        }
        $tokens = explode(' ', $search);
        $r="";
        if (sizeof($tokens)>0){
            $r = " AND ";
        }
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