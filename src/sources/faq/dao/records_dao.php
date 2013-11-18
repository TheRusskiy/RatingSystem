<?php
class RecordsDao {
    static function create($records){
        if(sizeof($records)===0){return;}
        $values = "";
        foreach($records as $i => $r){
            if (is_array($r['value'])){ // weird IE bug
                $r['value'] = $r['value'][0];
            }
            $values.="(";
            $values.="'".mysql_real_escape_string($r['staff_id'])."', ";
            $values.="'".mysql_real_escape_string($r['criteria_id'])."', ";
            $values.="'".mysql_real_escape_string($r['date'])."', ";
            $values.="'".mysql_real_escape_string($r['value'])."'";
            $values.=")";
            if($i!==sizeof($records)-1){
                $values.=",";
            }
        }
        $result = mysql_query("
            INSERT INTO rating_records(staff_id, criteria_id, date, value)"."
            VALUES $values
            ");
        if(!$result){
            throw new Exception('SQL error: '.mysql_error());
        }
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