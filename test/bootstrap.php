<?php
require_once('../test/test_helper.php');
connect_test_db();
execute_sql_file('fixtures.sql');
$GLOBALS['db_connected'] = false; //hacks, dirty hacks everywhere. Welcome to <del>hell</del>PHP baby!
?>