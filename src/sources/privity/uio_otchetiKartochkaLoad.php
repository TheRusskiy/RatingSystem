<?php
header('Content-type: text/html;charset=windows-1251');

header("Content-Type: application/force-download"); 
header("Content-Type: application/octet-stream"); 
header("Content-Type: application/download");
header("Content-type: application/vnd.ms-word");

header("Content-Disposition: attachment;Filename=document_name.doc");
header("Content-Transfer-Encoding: binary ");
include("uio_otchetiKartochkaForm.php");
include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
echo  kartochka($db);



?>