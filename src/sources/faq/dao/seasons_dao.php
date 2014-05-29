<?php
require_once(dirname(__FILE__).'/../rating/season.php');
class SeasonsDao {
    static function find($id){
        $count_query = mysql_query("
            SELECT *
            FROM rating_seasons
            WHERE id = $id
            LIMIT 1
            ");
        $row = mysql_fetch_array($count_query);
        if ($row){
            return new Season($row['id'], $row['from_date'], $row['to_date']);
        } else {
            return null;
        }
    }

    static function all(){
        $query = mysql_query("
            SELECT *
            FROM rating_seasons
            ORDER BY id DESC
            ");
        $seasons = array();
        while ($row = mysql_fetch_array($query)){
            $seasons[]= new Season($row['id'], $row['from_date'], $row['to_date']);
        }
        return $seasons;
    }

    static function insert($season){
        if (gettype($season->from_date)=="string"){
            $season->from_date = date('Y-m-d', strtotime($season->from_date));
        }
        if (gettype($season->to_date)=="string"){
            $season->to_date = date('Y-m-d', strtotime($season->to_date));
        }
        $id = mysql_real_escape_string($season->id);
        $from = mysql_real_escape_string($season->from_date);
        $to = mysql_real_escape_string($season->to_date);
        $query = mysql_query("
            INSERT INTO rating_seasons(id, from_date, to_date)
             VALUES
             ($id, '$from', '$to')
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        return $season;
    }
    static function update($season, $new_id){
        if (gettype($season->from_date)=="string"){
            $season->from_date = date('Y-m-d', strtotime($season->from_date));
        }
        if (gettype($season->to_date)=="string"){
            $season->to_date = date('Y-m-d', strtotime($season->to_date));
        }
        $new_id = mysql_real_escape_string($new_id);
        $old_id = mysql_real_escape_string($season->id);
        $from = mysql_real_escape_string($season->from_date);
        $to = mysql_real_escape_string($season->to_date);
        $query = mysql_query("
            UPDATE rating_seasons
            SET id=$new_id, from_date='$from', to_date='$to'
            WHERE id=$old_id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $season->id = $new_id;
        return $season;
    }
    static function delete($season_id){
        $id = mysql_real_escape_string($season_id);
        $query = mysql_query("
            DELETE FROM rating_seasons
            WHERE id=$id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        return true;
    }
}