<?php 
    $fam = $_GET["fam"];
 $imya = $_GET["imya"];
 $otch = $_GET["otch"];
$pod = $_GET["pod"];
  include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
    $result2 = mysql_query("SELECT id_otvetstvennogo_lica_FK  FROM `Ispolzovnie_pomesheniya` where  id_otvetstvennogo_lica_FK in(SELECT id_otvetstvennogo_lica  FROM `Otvetstvennoe_lico` where Familiya ='$fam' AND Imya='$imya'  AND Otchestvo='$otch' AND  id_podrazdeleniya_FK='$pod')",$db);
    $m = mysql_fetch_array($result2);
    
    $count= mysql_num_rows($result2);
//    do{
      echo $count;
 //   }
 //   while($m = mysql_fetch_array($result2));
?>