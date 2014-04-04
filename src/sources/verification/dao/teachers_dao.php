<?php

class TeachersDao {
    static function all(){
        $teachers_query = mysql_query("
            SELECT s.*
            FROM staff2 s
            ");
        $teachers = array();
        while ($row = mysql_fetch_array($teachers_query)){
            $teacher = array();
            $teacher["name"]=$row["name"]." ".$row["surname"]." ".$row["secondname"];
            $teacher["id"]=$row["id"];
            $teachers[]= $teacher;
        }
        return $teachers;
    }

}