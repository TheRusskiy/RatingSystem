<?php
header("Content-type: text/xml; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
$request = $_GET["podrazdelenie"];

if($request) echo loadData($request);

function loadData($request){
   include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
    $result2 = mysql_query("SELECT id_otvetstvennogo_lica,Familiya ,Imya,Otchestvo FROM `Otvetstvennoe_lico` where id_podrazdeleniya_FK ='$request' ",$db);
    $m = mysql_fetch_array($result2);
   do{
       $result3[] = "<otv_lico value ='".$m['id_otvetstvennogo_lica']."' >" ."<fam value='".$m['Familiya']."' >".$m['Familiya']."</fam><imya value='".$m['Imya']."' >".$m['Imya']."</imya><otch value ='".$m['Otchestvo']."' >".$m['Otchestvo']."</otch></otv_lico>"; 
    }
    while($m = mysql_fetch_array($result2));

 $result = "<?xml version='1.0' encoding='windows-1251'?>
                  <colors>";//.$result."</colors>";
				  for($i=0;$i<count($result3);$i++){
					  $result=$result.$result3[$i];
				  }
			      $result=$result."</colors>";
				  return $result;
}

?> 