<?php
require_once(dirname(__FILE__).'/../rating/season.php');
require_once(dirname(__FILE__).'/../rating/version.php');
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
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $seasons = array();
        while ($row = mysql_fetch_array($query)){
            $seasons[]= new Season($row['id'], $row['from_date'], $row['to_date']);
        }
        return $seasons;
    }

    static function all_criteria_versions($season_id = null){
        $condition = "";
        if ($season_id!=null){
            $season_id = mysql_real_escape_string($season_id);
            $condition = "AND s.id = $season_id";
        }
        $query = "
            SELECT v.*
            FROM
              rating_seasons_criteria_versions sv,
              criteria_versions v,
              rating_seasons s
            WHERE
                sv.criteria_version_id = v.id
                AND sv.rating_season_id = s.id
                $condition
            ORDER BY sv.version_order ASC
            ";
        $query = mysql_query($query);
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $versions = array();
        while ($row = mysql_fetch_array($query)){
            $versions[]= new Version($row);
        }
        return $versions;
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

    static function insert_criteria_versions($season_criteria, $season_id){
        if (count($season_criteria)==0){
            return true;
        }
        $values = "";
        foreach($season_criteria as $i=>$sc){
            $criteria_version_id = mysql_real_escape_string($sc->id);
            $rating_season_id = mysql_real_escape_string($season_id);
            $values.="($criteria_version_id, $rating_season_id, $i)";
            if ($i!=count($season_criteria)-1){
                $values.=", ";
            }
        }
        $query = mysql_query("
            INSERT INTO rating_seasons_criteria_versions(criteria_version_id, rating_season_id, version_order)
             VALUES $values
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        return true;
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
    static function delete_criteria_versions($season_id){
        $id = mysql_real_escape_string($season_id);
        $query = mysql_query("
            DELETE FROM rating_seasons_criteria_versions
            WHERE rating_season_id=$id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        return true;
    }
}