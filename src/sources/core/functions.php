<?php

function connect_db() {
  global $CONFS;
  if(!($mysql = mysql_connect($CONFS['sql_host'],$CONFS['sql_user'],$CONFS['sql_pass']))) {
    echo ("Can't create connection ");
    exit();
  }

  if(!($db = mysql_select_db($CONFS['sql_database']))) {
    echo ("Can't select database");
    exit();
  }
  if(isset($CONFS['max_allowed_packet'])){
      mysql_query("SET GLOBAL max_allowed_packet={$CONFS['max_allowed_packet']}");
  }
  mysql_query("SET NAMES cp1251");
  return $mysql;
}


function fError($err) {
  echo "<font color=red>Error!</font> $err";
//  exit();

}


?>