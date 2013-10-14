<?php 
header("Content-type: text/xml; charset=windows-1251");
    $request = $_GET["korpus"];
	$request = iconv("UTF-8", "WINDOWS-1251",  $request);
	include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
    $result2 = mysql_query("SELECT  Adres_zdaniya FROM `Korpus` where  Nomer_korpusa =  '$request' ",$db);
    $m = mysql_fetch_array($result2);
    do{
       echo $m['Adres_zdaniya'];

    }
    while($m = mysql_fetch_array($result2));
?>