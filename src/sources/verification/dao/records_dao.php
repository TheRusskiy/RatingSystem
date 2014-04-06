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

    static function count($criteria_id, $page = null, $per_page = null){
      $teachers_query = mysql_query("
            SELECT COUNT(*) as length
            FROM rating_records
            WHERE criteria_id = $criteria_id
            ");
      $result = mysql_fetch_array($teachers_query);
      return $result["length"];
    }
    static function all($criteria_id, $page = null, $page_length = null){
        $limiter = "";
        if ($page!==null) {
            $page = intval($page)-1;
            $from = $page * $page_length;
            $limiter = "ORDER BY id desc
                        LIMIT" . " $page_length OFFSET $from";
        }
        $criteria = CriteriaDao::find($criteria_id);
        $records_query = "
            SELECT r.id as id, r.criteria_id as criteria_id, r.name as name, r.date as date, r.staff_id as staff_id, r.value as value,
            t.name as teacher_name, t.surname as teacher_surname, t.secondname as teacher_secondname,
            u.id as user_id, u.name as user_name
            FROM rating_records r
            JOIN staff2 t ON r.staff_id = t.id
            JOIN user u ON r.user_id = u.id
            WHERE r.criteria_id = $criteria_id
            $limiter
            ";
        $records_query = mysql_query($records_query);
        $rows = array();
        $ids = array();
        while ($row = mysql_fetch_array($records_query)){
            $record = array();
            $record["id"]=$row["id"];
            array_push($ids, $row["id"]);
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
            $rows[]= $record;
        }
        $string_ids = implode(", ", $ids);
        $notes_count_query = "
            SELECT r.id as id, n.id as note_id
            FROM rating_records r
            JOIN rating_record_notes n ON r.id = n.record_id
            WHERE r.id IN ($string_ids)
        ";
        $notes_count_query = mysql_query($notes_count_query);
        $id_notes_map = array();
        while ($row = mysql_fetch_array($notes_count_query)){
            if (!isset($id_notes_map[$row["id"]])){
                $id_notes_map[$row["id"]] = array();
            }
            array_push($id_notes_map[$row["id"]], $row["note_id"]);
        }
        foreach($rows as $key=>$r){
            if (!isset($id_notes_map[$r["id"]])){
                $id_notes_map[$r["id"]] = array();
            }
            $rows[$key]["notes"]=$id_notes_map[$r["id"]];
        }
        return $rows;
    }

    static function upsert_from_object($record, $user){
        $row = array();
        $row["staff_id"]=$record->teacher->id;
        $row["criteria_id"]=$record->criteria_id;
        $row["user_id"]=$user->id;
        $row["name"]=$record->name;
        $row["date"]=$record->date;
        if (isset($record->option)){
            $row["value"]=$record->option->value;
        } else {
            $row["value"]=1;
        }
        if (isset($record->id)&&$record->id!=null){ # update
            $row["id"]=$record->id;
            self::update(array($row));
        } else { # create
            $record->id=self::create(array($row));
        }
        $record->user->id = $user->id;
        $record->user->name = $user->name;

        $timestamp = strtotime($row['date']);
        $record->date = date('Y-m-d', $timestamp);
        $record->notes = array();
        return $record;
    }
    static function create($records){
        if(sizeof($records)===0){return;}
        $values = "";
        foreach($records as $i => $r){
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
            // delete dependent notes
            $result = mysql_query("
                DELETE FROM rating_record_notes
                WHERE record_id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

    static function update($records){
        if(sizeof($records)===0){return;}
        foreach($records as $r){
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