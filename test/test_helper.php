<?php
require_once '../vendor/autoload.php';
include_once('../src/sources/faq/helpers.php');
include_once('../src/sources/faq/controllers/helpers.php');
include_once('../src/sources/faq/helpers.php');
//$TEST_CONFS['sql_host'] 		= 'localhost';
//#$TEST_CONFS['sql_database'] 	= 'test';
//$TEST_CONFS['sql_user'] 		= 'TheRusskiy';
//$TEST_CONFS['sql_pass'] 		= 'wordpass';
//$TEST_CONFS['sql_port']		= '';

function connect_test_db($database = 'diploma_test') {
    if (isset($GLOBALS['db_connected'])&&$GLOBALS['db_connected']) {return; }
//    global $TEST_CONFS;
    $TEST_CONFS['sql_host'] 		= '127.0.0.1';
    $TEST_CONFS['sql_user'] 		= 'root';
    $TEST_CONFS['sql_pass'] 		= '';
    $TEST_CONFS['sql_port']		= '';
    $result = true;
    if(!($mysql = mysql_connect($TEST_CONFS['sql_host'],$TEST_CONFS['sql_user'],$TEST_CONFS['sql_pass']))) {
        $result = false;
    }

    if(!($db = mysql_select_db($database))) {
        $result = false;
    }
    mysql_query("SET NAMES cp1251");

    $GLOBALS['db_connected'] = true;
    return $result;
}

function execute_sql_file($filename){
    if ($file = file_get_contents($filename)){
        foreach(explode(";", $file) as $query){
            $query = trim($query);
            if (!empty($query) && $query != ";") {
                if (!mysql_query($query)){
                    throw new Exception("Error during bootstrap: ".mysql_error());
                }
            }
        }
    }
}