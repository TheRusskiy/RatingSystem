<?php
require_once(__DIR__."/../../faq/dao/criteria_dao.php");
class NotesDao {
    static function all_external_notes($record_id){
        return self::all_notes($record_id, true);
    }

    static function all_notes($record_id, $external=true){
        $notes_table = $external ? 'rating_record_external_notes' : 'rating_record_notes';
        $notes_query = mysql_query("
            SELECT n.id as id, n.record_id as record_id, n.date as date, n.text as text,
            u.id as user_id, u.name as user_name
            FROM $notes_table n
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

    static function create_notes($notes, $external=false){
        $notes_table = $external ? 'rating_record_external_notes' : 'rating_record_notes';
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
            INSERT INTO $notes_table(record_id, date, text, user_id)"."
            VALUES $values
            ");
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
        return mysql_insert_id();
    }
    static function insert_external_note_from_object($note, $user){
        return self::insert_note_from_object($note, $user, true);
    }
    static function insert_note_from_object($note, $user, $external=false){
        $note->date = date('Y-m-d');
        $note->user_id = $user->id;
        $note->user_name = $user->name;
        $row = array();
        $row["record_id"]=$note->record_id;
        $row["date"]=$note->date;
        $row["text"]=$note->text;
        $row["user_id"]=$user->id;
        $note->id=self::create_notes(array($row), $external);
        return $note;
    }

    static function delete_external_notes($notes){
        self::delete_notes($notes, true);
    }

    static function delete_notes($notes, $external=false){
        $notes_table = $external ? 'rating_record_external_notes' : 'rating_record_notes';
        if(sizeof($notes)===0){return;}
        foreach($notes as $r){
            $id = mysql_real_escape_string($r['id']);
            $result = mysql_query("
            DELETE FROM $notes_table
            WHERE id = $id
            ");
            if(!$result){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }

}