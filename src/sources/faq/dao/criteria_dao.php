<?php
require_once(__DIR__.'/../rating/criteria.php');
class CriteriaDao {
    static function all($page=null, $count=null){
        $limiter = "";
        if ($page!==null) {
            $from = $page * $count;
            $limiter = "ORDER BY id
                        LIMIT" . " $count OFFSET $from";
        }
        $query = mysql_query("
            SELECT c.id AS id, MAX(c.name) AS name, MAX(c.description) AS description, MAX(c.fetch_type) AS fetch_type, MAX(c.fetch_value) AS fetch_value, MAX(c.external_records) AS external_records, COUNT(v.id) AS version_count
            FROM criteria c
            LEFT JOIN criteria_versions v ON (c.id = v.criteria_id)
            GROUP BY c.id
            $limiter
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $result = array();
        while ($row = mysql_fetch_array($query)){
            $criteria =  new Criteria($row);
            $result[]=$criteria;
        }
        return $result;
    }
    static function all_with_records(){
        $query = mysql_query("
            SELECT id, name, description, fetch_type, fetch_value, external_records
            FROM criteria
            WHERE fetch_type = 'manual' or fetch_type = 'manual_options'
            ");
        $result = array();
        while ($row = mysql_fetch_array($query)){
            $result[]= new Criteria($row);
        }
        return $result;
    }

    static function count(){
        $count_query = mysql_query("
            SELECT count(*)
            FROM criteria
            ");
        $row = mysql_fetch_array($count_query);
        return $row[0];
    }

    static function find($id){
        $id = mysql_real_escape_string($id);
        $query = mysql_query("
            SELECT *
            FROM criteria
            WHERE id = $id
            ");
        $row = mysql_fetch_array($query);
        return new Criteria($row);
    }

    static function update($criteria){
//        $multi = $criteria->multiplier_to_string();
        $external_records = $criteria->external_records_int();
        $query = mysql_query("
            UPDATE criteria
            SET
            fetch_type = '$criteria->fetch_type',
            fetch_value = '$criteria->fetch_value',
            name = '$criteria->name',
            external_records = $external_records,
            description = '$criteria->description'
            WHERE id = $criteria->id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function insert($criteria){
//        $multi = $criteria->multiplier_to_string();
        $external_records = $criteria->external_records_int();
        $query = mysql_query("
            INSERT INTO criteria(fetch_type, fetch_value, name, description, external_records)
             VALUES
             ('$criteria->fetch_type',
             '$criteria->fetch_value',
             '$criteria->name',
             '$criteria->description',
             $external_records)
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
        $criteria->id = mysql_insert_id();
        return $criteria;
    }

    static function delete($criteria){
        $id = null;
        if (is_a($criteria, 'Criteria')){
            $id = $criteria->id;
        } else {
            $id = $criteria;
        }
        $id = mysql_real_escape_string($id);
        $query = mysql_query("
            DELETE FROM criteria
            WHERE id = $id
            ");
        if(mysql_affected_rows()!==1){
            throw new Exception('SQL error: '.mysql_error());
        }
        $query = mysql_query("
            DELETE FROM criteria_versions
            WHERE criteria_id = $id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

}