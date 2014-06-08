<?php
require_once(dirname(__FILE__).'/../rating/version.php');
class VersionsDao {
    static function find($id){
        $count_query = mysql_query("
            SELECT *
            FROM criteria_versions
            WHERE id = $id
            LIMIT 1
            ");
        $row = mysql_fetch_array($count_query);
        if ($row){
            return new Version($row);
        } else {
            return null;
        }
    }

    static function all($criteria_id = null){
        $condition = "";
        if ($criteria_id != null){
            $criteria_id = mysql_real_escape_string($criteria_id);
            $condition = " WHERE criteria_id = $criteria_id";
        }
        $query = mysql_query("
            SELECT *
            FROM criteria_versions
            $condition
            ORDER BY creation_date DESC
            ");
        $versions = array();
        while ($row = mysql_fetch_array($query)){
            $versions[]= new Version($row);
        }
        return $versions;
    }

    static function insert($version){
        if (gettype($version->creation_date)=="string"){
            $version->creation_date = date('Y-m-d', strtotime($version->creation_date));
        }
        $criteria_id = mysql_real_escape_string($version->criteria_id);
        $multiplier = mysql_real_escape_string($version->multiplier_to_string());
        $year_limit = mysql_real_escape_string($version->year_limit);
        $year_2_limit = mysql_real_escape_string($version->year_2_limit);
        $creation_date = mysql_real_escape_string($version->creation_date);
        $query = mysql_query("
            INSERT INTO criteria_versions(criteria_id, multiplier, year_limit, year_2_limit, creation_date)
             VALUES
             ($criteria_id, '$multiplier', $year_limit, $year_2_limit, '$creation_date')
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $version->id = mysql_insert_id();
        return $version;
    }
    static function update($version){
        if (gettype($version->creation_date)=="string"){
            $version->creation_date = date('Y-m-d', strtotime($version->creation_date));
        }
        $id = mysql_real_escape_string($version->id);
        $criteria_id = mysql_real_escape_string($version->criteria_id);
        $multiplier = mysql_real_escape_string($version->multiplier);
        $year_limit = mysql_real_escape_string($version->year_limit);
        $year_2_limit = mysql_real_escape_string($version->year_2_limit);
        $creation_date = mysql_real_escape_string($version->creation_date);
        $query = mysql_query("
            UPDATE criteria_versions
            SET criteria_id = $criteria_id, multiplier='$multiplier', year_limit = $year_limit, year_2_limit = $year_2_limit, creation_date = '$creation_date'
            WHERE id=$id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        return $version;
    }
    static function delete($version_id){
        $id = mysql_real_escape_string($version_id);
        $query = mysql_query("
            DELETE FROM criteria_versions
            WHERE id=$id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        return true;
    }
}