<?php

function require_relative($source, $path){
    return require_once dirname($source).'/'.$path;
}
function _or_(){
    foreach(func_get_args() as $arg){
        if ($arg == true) {return $arg;}
    }
    return false;
}
function mysql_set_cache($key, $value, $time=0){
    $escaped = mysql_real_escape_string($value);
    $text_query = "REPLACE INTO rating_cache(`key`, value, time_to_live) VALUES('$key', '$escaped', $time)";
    $query = mysql_query($text_query);
    if(!$query){
        throw new Exception('SQL error: '.mysql_error());
    }
}
function mysql_get_cache($key){
    $query = mysql_query("SELECT * FROM rating_cache WHERE `key` = '$key'");
    if(!$query){
        throw new Exception('SQL error: '.mysql_error());
    }
    $row = mysql_fetch_array($query);
    $value = "";
    $cached = false;
    if ($row){
        $now = new DateTime();
        $now = strtotime($now->format('Y-m-d H:i:s'));
        $age = $now - strtotime($row['created_at']);
        $ttl = intval($row['time_to_live']);
        if ($age<$ttl || $ttl == 0){
            $value = $row['value'];
            $cached = true;
        } else {
            $query = mysql_query("DELETE FROM rating_cache WHERE `key` = '$key'");
            if(!$query){
                throw new Exception('SQL error: '.mysql_error());
            }
        }
    }
    if ($cached){
        return $value;
    } else {
        return false;
    }
}

function mysql_expire_cache($key){
    $query = mysql_query("DELETE FROM rating_cache WHERE `key` = '$key'");
    if(!$query){
        throw new Exception('SQL error: '.mysql_error());
    }
}