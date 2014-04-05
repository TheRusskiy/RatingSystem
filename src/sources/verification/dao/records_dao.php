<?php
require_once(__DIR__."/../../faq/dao/criteria_dao.php");
class RecordsDao {
/*
      id: 1
      criteria_id: 1
      date: "01.02.2013"
      name: "Победа в областной олимпиаде по математике"
      option:
        value: 1
        name: "1 место"
      teacher:
        id: 1
        name: "Прохоров Сергей Антонович"
      user:
        id: 202
        name: "Ишков Д.С."
      notes: [1,2,3]
 */

    static function all($criteria_id, $page = null, $per_page = null){
        // todo pages
        $criteria = CriteriaDao::find($criteria_id);
        $teachers_query = mysql_query("
            SELECT r.id as id, r.criteria_id as criteria_id, r.name as name, r.date as date, r.staff_id as staff_id, r.value as value,
            t.name as teacher_name, t.surname as teacher_surname, t.secondname as teacher_secondname,
            u.id as user_id, u.name as user_name
            FROM rating_records r
            JOIN staff2 t ON r.staff_id = t.id
            JOIN user u ON r.user_id = u.id
            ");
        $rows = array();
        while ($row = mysql_fetch_array($teachers_query)){
            $record = array();
            $record["id"]=$row["id"];
            $record["criteria_id"]=$row["criteria_id"];
            $record["name"]=$row["name"];
            $record["date"]=$row["date"];
            // teacher
            $teacher = array();
            $teacher["name"]=$row["teacher_name"]." ".$row["teacher_surname"]." ".$row["teacher_secondname"];
            $teacher["id"]=$row["staff_id"];
            $record["teacher"]=$teacher;
            // option
            $record["option"]=$criteria->option_for($row["value"]);
            // user
            $user = array();
            $user["name"]=$row["user_name"];
            $user["id"]=$row["user_id"];
            $record["user"]=$user;
            // notes
            $record["notes"]=array(); // todo notes
            $rows[]= $record;
        }
        return $rows;
    }

    static function create_from_object($record, $user){
        $row = array();
        $row["staff_id"]=$record->teacher->id;
        $row["criteria_id"]=$record->criteria_id;
        $row["user_id"]=$user->id;
        $row["name"]=$record->name;
        $row["date"]=$record->date;
        $row["value"]=$record->option->value;
        $record->id=self::create(array($row));
        $record->user->id = $user->id;
        $record->user->name = $user->name;

        $timestamp = strtotime($row['date']);
        $record->date = date('Y-m-d', $timestamp);
        return $record;
    }
    static function create($records){
        if(sizeof($records)===0){return;}
        $values = "";
        foreach($records as $i => $r){
//            if (is_array($r['value'])){ // weird IE bug
//                $r['value'] = $r['value'][0];
//            }
            $values.="(";
            $values.="'".mysql_real_escape_string($r['staff_id'])."', ";
            $values.="'".mysql_real_escape_string($r['criteria_id'])."', ";
            $values.="'".mysql_real_escape_string($r['user_id'])."', ";
            $values.="'".mysql_real_escape_string($r['name'])."', ";
            $values.="'".mysql_real_escape_string($r['date'])."', ";
            $values.="'".mysql_real_escape_string($r['value'])."'";
            $values.=")";
            if($i!==sizeof($records)-1){
                $values.=",";
            }
        }
        $result = mysql_query("
            INSERT INTO rating_records(staff_id, criteria_id, user_id, name, date, value)"."
            VALUES $values
            ");
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
        return mysql_insert_id();
    }

    static function delete($records){
        if(sizeof($records)===0){return;}
        foreach($records as $r){
            $id = mysql_real_escape_string($r['id']);
            $result = mysql_query("
            DELETE FROM rating_records
            WHERE id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

    static function update($records){
        if(sizeof($records)===0){return;}
        foreach($records as $r){
            if (is_array($r['value'])){  // weird IE bug
                $r['value'] = $r['value'][0];
            }
            $id = mysql_real_escape_string($r['id']);
            $values="SET ";
            $values.="staff_id='".mysql_real_escape_string($r['staff_id'])."', ";
            $values.="criteria_id='".mysql_real_escape_string($r['criteria_id'])."', ";
            $values.="user_id='".mysql_real_escape_string($r['user_id'])."', ";
            $values.="name='".mysql_real_escape_string($r['name'])."', ";
            $values.="date='".mysql_real_escape_string($r['date'])."', ";
            $values.="value='".mysql_real_escape_string($r['value'])."'";
            $result = mysql_query("
            UPDATE rating_records
            $values
            WHERE id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

}