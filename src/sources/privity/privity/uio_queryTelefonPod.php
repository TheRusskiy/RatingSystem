<?php 
    $request = $_GET['podrazdelenie'];
   include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
    $result2 = mysql_query("SELECT  telephon  FROM `Structurnoe_podrazdelenie` where  id_podrazdeleniya ='$request' ",$db);
    $m = mysql_fetch_array($result2);
    do{
       echo $m['telephon'];
    }
    while($m = mysql_fetch_array($result2));
?>