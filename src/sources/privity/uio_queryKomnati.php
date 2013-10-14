<?php
header("Content-type: text/xml; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
$request = $_GET["korpus"];
$request = iconv("UTF-8", "WINDOWS-1251",  $request);
//$request = iconv('UTF8','CP1251',$_GET["korpus"]);
//$request =1;
//$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
// mysql_select_db($CONFS['sql_database'] ,$db);
if($request) echo loadData($request);

function loadData($request){
   include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
    $result2 = mysql_query("SELECT Nomer_komnati From `Pomesenie`  where Nomer_korpusa_FK  ='$request'  group by Nomer_komnati",$db);
    $m = mysql_fetch_array($result2);
   do{
       $result3[] = "<komnata value ='".$m['Nomer_komnati']."' >".$m['Nomer_komnati']."</komnata>"; 
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