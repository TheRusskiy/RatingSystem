<?php

class TeachersDao {
    static function all(){
        $teachers_query = mysql_query("
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
            GROUP BY s.id, s.shortname, s.secondname, s.surname, s.name, d.name
            HAVING SUM(ds.rateacc) > 0.2
            ");
        $teachers = array();
        while ($row = mysql_fetch_array($teachers_query)){
            $teacher = array();
            $teacher["name"]=$row["surname"]." ".$row["name"]." ".$row["secondname"];
            $teacher["id"]=$row["id"];
            $teachers[]= $teacher;
        }
        return $teachers;
    }

}