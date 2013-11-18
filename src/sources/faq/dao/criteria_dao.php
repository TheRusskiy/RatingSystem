<?php
class CriteriaDao {
    static function all($page=null, $count=null){
        $limiter = "";
        if ($page!==null) {
            $from = $page * $count;
            $limiter = "ORDER BY id
                        LIMIT" . " $count OFFSET $from";
        }
        $query = mysql_query("
            SELECT id, name, fetch_type, fetch_value, multiplier, calculation_type, year_limit
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
        $query = mysql_query("
            UPDATE criteria
            SET
            fetch_type = '$criteria->fetch_type',
            fetch_value = '$criteria->fetch_value',
            name = '$criteria->name',
            year_limit = $criteria->year_limit,
            multiplier = '$criteria->multiplier',
            calculation_type = '$criteria->calculation_type'
            WHERE id = $criteria->id
            ");
        if(!$query){
            throw new Exception('SQL error: '.mysql_error());
        }
    }

    static function insert($criteria){
        $query = mysql_query("
            INSERT INTO criteria(fetch_type, fetch_value, name, year_limit, multiplier, calculation_type)
             VALUES
             ('$criteria->fetch_type',
             '$criteria->fetch_value',
             '$criteria->name',
             $criteria->year_limit,
             '$criteria->multiplier',
             '$criteria->calculation_type')
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