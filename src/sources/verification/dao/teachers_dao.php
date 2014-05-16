<?php

class TeachersDao {
    static function all(){
        $teachers_query = mysql_query("
            SELECT s.*
            FROM staff2 s
            JOIN depstaff ds ON
            (s.id = ds.id_staff
            AND ds.rateacc > 0.6
            )
            JOIN dep d ON
            (d.id = ds.id_dep)
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