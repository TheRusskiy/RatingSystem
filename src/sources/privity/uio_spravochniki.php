<?php
function dict()
{
  include "config.php";
  $db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
  $edit = mysql_query("SELECT * FROM `menu` where prev=4 order by `numberitem`",$db);
  $rows=mysql_num_rows($edit);
  $m = mysql_fetch_array($edit);
  $dic="";;
  for($i=0;$i<$rows;$i++){
     $way = $m['way'];
     $label=$m['label'];
     $prev = $m['prev'];
     $otstup="";
  $dic=$dic."<br>".$otstup."<a href='".$way."'>".$label."</a>";
  $m = mysql_fetch_array($edit);
  }
return $dic;
}
?>