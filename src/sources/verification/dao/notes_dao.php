<?php
require_once(__DIR__."/../../faq/dao/criteria_dao.php");
class NotesDao {
    static function all_notes($record_id){
        $notes_query = mysql_query("
            SELECT n.id as id, n.record_id as record_id, n.date as date, n.text as text,
            u.id as user_id, u.name as user_name
            FROM rating_record_notes n
            JOIN user u ON n.user_id = u.id
            WHERE n.record_id = $record_id
            ");
        $rows = array();
        while ($row = mysql_fetch_array($notes_query)){
            $record = array();
            $record["id"]=$row["id"];
            $record["record_id"]=$row["record_id"];
            $record["date"]=$row["date"];
            $record["text"]=$row["text"];
            $record["user_id"]=$row["user_id"];
            $record["user_name"]=$row["user_name"];
            $rows[]= $record;
        }
        return $rows;
    }

    static function create_notes($notes){
        if(sizeof($notes)===0){return;}
        $values = "";
        foreach($notes as $i => $r){
            $values.="(";
            $values.="'".mysql_real_escape_string($r['record_id'])."', ";
            $values.="'".mysql_real_escape_string($r['date'])."', ";
            $values.="'".mysql_real_escape_string($r['text'])."', ";
            $values.="'".mysql_real_escape_string($r['user_id'])."'";
            $values.=")";
            if($i!==sizeof($notes)-1){
                $values.=",";
            }
        }
        $result = mysql_query("
            INSERT INTO rating_record_notes(record_id, date, text, user_id)"."
            VALUES $values
            ");
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
        return mysql_insert_id();
    }
    static function insert_note_from_object($note, $user){
        $note->date = date('Y-m-d');
        $note->user_id = $user->id;
        $note->user_name = $user->name;
        $row = array();
        $row["record_id"]=$note->record_id;
        $row["date"]=$note->date;
        $row["text"]=$note->text;
        $row["user_id"]=$user->id;
        $note->id=self::create_notes(array($row));
        return $note;
    }

    static function delete_notes($notes){
        if(sizeof($notes)===0){return;}
        foreach($notes as $r){
            $id = mysql_real_escape_string($r['id']);
            $result = mysql_query("
            DELETE FROM rating_record_notes
            WHERE id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

}