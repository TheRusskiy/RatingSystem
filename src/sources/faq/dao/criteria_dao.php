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
            SELECT id, name, description, fetch_type, fetch_value, multiplier, calculation_type, year_limit, creation_date
            FROM criteria
            $limiter
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
        $multi = $criteria->multiplier_to_string();
        $query = mysql_query("
            UPDATE criteria
            SET
            fetch_type = '$criteria->fetch_type',
            fetch_value = '$criteria->fetch_value',
            name = '$criteria->name',
            year_limit = $criteria->year_limit,
            multiplier = '$multi',
            calculation_type = '$criteria->calculation_type',
            creation_date = '$criteria->creation_date',
            description = '$criteria->description'
            WHERE id = $criteria->id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function insert($criteria){
        $multi = $criteria->multiplier_to_string();
        $query = mysql_query("
            INSERT INTO criteria(fetch_type, fetch_value, name, description, year_limit, multiplier, calculation_type, creation_date)
             VALUES
             ('$criteria->fetch_type',
             '$criteria->fetch_value',
             '$criteria->name',
             '$criteria->description',
             $criteria->year_limit,
             '$multi',
             '$criteria->calculation_type',
             '$criteria->creation_date')
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function delete($id){
        $query = mysql_query("
            DELETE FROM criteria
            WHERE id = $id
            ");
        if(mysql_affected_rows()!==1){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

}