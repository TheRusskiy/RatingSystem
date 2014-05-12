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
}