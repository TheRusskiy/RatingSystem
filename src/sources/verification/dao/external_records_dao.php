<?php
require_once(__DIR__."/../../faq/dao/criteria_dao.php");
class ExternalRecordsDao {
/*
      id: 2
      criteria_id: 1
      description: 'Победа в олимпиаде'
      date: '2014-04-03'
      notes: [4,5]
      teacher:
        id: 2
        name: 'Some other name'
      status: 'new'
      created_by:
        id: 1
        name: "some dude"
      reviewed_by:
        id: 1
        name: "verification"
 */

    static function approve($record_id, $user){
        $record_id = mysql_real_escape_string($record_id);
        $user_id = mysql_real_escape_string($user->id);
        $q = "
            UPDATE rating_external_records
            SET status='approved',
            reviewed_by = '$user_id'
            WHERE id = $record_id
            ";
        $result = mysql_query($q);
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function reject($record_id, $user){
        $record_id = mysql_real_escape_string($record_id);
        $user_id = mysql_real_escape_string($user->id);
        $result = mysql_query("
            UPDATE rating_external_records
            SET status='rejected',
            reviewed_by = '$user_id'
            WHERE id = $record_id
            ");
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function all_new($criteria_id){
        return self::all($criteria_id, true);
    }
    static function all($criteria_id, $only_new = false){
        $criteria = CriteriaDao::find($criteria_id);
        $conditions = "";
        if ($only_new){
            $conditions = " AND r.status='new'";
        }
        $records_query = "
            SELECT r.id as id, r.criteria_id as criteria_id, r.description as description, r.date as date, r.staff_id as staff_id, r.status as status,
            t.name as teacher_name, t.surname as teacher_surname, t.secondname as teacher_secondname,
            reviewer.id as reviewer_id, reviewer.name as reviewer_name,
            creator.id as creator_id, creator.name as creator_name
            FROM rating_external_records r
            JOIN staff2 t ON r.staff_id = t.id
            LEFT JOIN user reviewer ON r.reviewed_by = reviewer.id
            JOIN user creator ON r.created_by = creator.id
            WHERE r.criteria_id = $criteria_id
            $conditions
            ";
        $records_query = mysql_query($records_query);
        $rows = array();
        $ids = array();
        while ($row = mysql_fetch_array($records_query)){
            $record = array();
            $record["id"]=$row["id"];
            array_push($ids, $row["id"]);
            $record["criteria_id"]=$row["criteria_id"];
            $record["description"]=$row["description"];
            $record["status"]=$row["status"];
            $record["date"]=$row["date"];
            // teacher
            $teacher = array();
            $teacher["name"]=$row["teacher_name"]." ".$row["teacher_surname"]." ".$row["teacher_secondname"];
            $teacher["id"]=$row["staff_id"];
            $record["teacher"]=$teacher;
            // reviewer (reviewed_by)
            $reviewer = array();
            $reviewer["name"]=$row["reviewer_name"];
            $reviewer["id"]=$row["reviewer_id"];
            $record["reviewed_by"]=$reviewer;
            // creator (created_by)
            $creator = array();
            $creator["name"]=$row["creator_name"];
            $creator["id"]=$row["creator_id"];
            $record["created_by"]=$creator;
            $rows[]= $record;
        }
        $string_ids = implode(", ", $ids);
        if (count($ids)!=0) {
            $notes_count_query = "
            SELECT r.id as id, n.id as note_id
            FROM rating_external_records r
            JOIN rating_record_external_notes n ON r.id = n.record_id
            WHERE r.id IN ($string_ids)
        ";
            $notes_count_query = mysql_query($notes_count_query);
            $id_notes_map = array();
            while ($row = mysql_fetch_array($notes_count_query)) {
                if (!isset($id_notes_map[$row["id"]])) {
                    $id_notes_map[$row["id"]] = array();
                }
                array_push($id_notes_map[$row["id"]], $row["note_id"]);
            }
            foreach ($rows as $key => $r) {
                if (!isset($id_notes_map[$r["id"]])) {
                    $id_notes_map[$r["id"]] = array();
                }
                $rows[$key]["notes"] = $id_notes_map[$r["id"]];
            }
        }
        return $rows;
    }

    static function find($id){
        $id = mysql_real_escape_string($id);
        $query = "
            SELECT r.id as id, r.criteria_id as criteria_id, r.description as description, r.date as date, r.staff_id as staff_id, r.status as status,
            t.name as teacher_name, t.surname as teacher_surname, t.secondname as teacher_secondname,
            reviewer.id as reviewer_id, reviewer.name as reviewer_name,
            creator.id as creator_id, creator.name as creator_name
            FROM rating_external_records r
            JOIN staff2 t ON r.staff_id = t.id
            LEFT JOIN user reviewer ON r.reviewed_by = reviewer.id
            JOIN user creator ON r.created_by = creator.id
            WHERE r.id = $id
            LIMIT 1
            ";
        $query = mysql_query($query);
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $row = mysql_fetch_array($query);
        if(!$row){
            throw new Exception("Record with id $id not found");
        }
        return $row;
    }

    static function upsert_from_object($record, $user){
        $row = array();
        $row["staff_id"]=$record->teacher->id;
        $row["criteria_id"]=$record->criteria_id;
        $row["created_by"]=$user->id;
//        $row["reviewed_by"]=$user->id;
        $row["description"]=$record->description;
        $row["date"]=$record->date;
        $row["status"]=$record->status;
        if (isset($record->id)&&$record->id!=null){ # update
            $row["id"]=$record->id;
            self::update(array($row));
        } else { # create
            $record->id=self::create(array($row));
        }
        $record->created_by->id = $user->id;
        $record->created_by->name = $user->name;

//        $record->reviewed_by->id = $user->id;
//        $record->reviewed_by->name = $user->name;

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
            $values.="'".mysql_real_escape_string($r['created_by'])."', ";
//            $values.="'".mysql_real_escape_string($r['reviewed_by'])."', ";
            $values.="'".mysql_real_escape_string($r['description'])."', ";
            $values.="'".mysql_real_escape_string($r['date'])."', ";
            $values.="'".mysql_real_escape_string($r['status'])."'";
            $values.=")";
            if($i!==sizeof($records)-1){
                $values.=",";
            }
        }
        $result = mysql_query("
            INSERT INTO rating_external_records(staff_id, criteria_id, created_by, description, date, status)"."
            VALUES $values
            ");
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
        return mysql_insert_id();
    }

    static function update($records){
        if(sizeof($records)===0){return;}
        foreach($records as $r){
            $id = mysql_real_escape_string($r['id']);
            $values="SET ";
            $values.="staff_id='".mysql_real_escape_string($r['staff_id'])."', ";
            $values.="criteria_id='".mysql_real_escape_string($r['criteria_id'])."', ";
            $values.="created_by='".mysql_real_escape_string($r['created_by'])."', ";
//            $values.="reviewed_by='".mysql_real_escape_string($r['reviewed_by'])."', ";
            $values.="description='".mysql_real_escape_string($r['description'])."', ";
            $values.="date='".mysql_real_escape_string($r['date'])."', ";
            $values.="status='".mysql_real_escape_string($r['status'])."'";
            $result = mysql_query("
            UPDATE rating_external_records
            $values
            WHERE id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

    static function delete($records){
        if(sizeof($records)===0){return;}
        foreach($records as $r){
            $id = mysql_real_escape_string($r['id']);
            $result = mysql_query("
                DELETE FROM rating_external_records
                WHERE id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
            // delete dependent notes
            $result = mysql_query("
                DELETE FROM rating_record_external_notes
                WHERE record_id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

}