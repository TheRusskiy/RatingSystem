<?php
class UsersDao {
    static function find($id){
        $id = mysql_real_escape_string($id);
        $query = mysql_query("
            SELECT *
            FROM user
            WHERE id = $id
            ");
        $row = mysql_fetch_array($query);
        return new User($row);
    }
}