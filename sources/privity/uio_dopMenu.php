<?php
/*include "core/skin.php";
//include "uio_queryPomesheniya.php";
if($_SESSION['user_id']=='2'){
 echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>   ��������&nbsp������������</a>","<br><a href='uio_otchetiPomes.php'>���������,��������� �� ������� ������������</a><br><a href='uio_edit.php?buttonName=������ ���������&r=otchet'>������������������ �������� ���������</a><br><a href='uio_otcheti111.php'>��������� � ������ ���������</a><br><a href='uio_otcheti222.php'>��������� ��� ������������</a>");
}
else{ echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>".
"<br><a href='uio_otcheti.php'>������</a>","<br><a href='uio_otchetiPomes.php'>���������,��������� �� ������� ������������</a><br><a href='uio_edit.php?buttonName=������ ���������&r=otchet'>������������������ �������� ���������</a><br><a href='uio_otcheti111.php'>��������� � ������ ���������</a><br><a href='uio_otcheti222.php'>��������� ��� ������������</a>");
}*/
function dopolMenu($param)
{
  include "config.php";
  $db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
  $edit = mysql_query("SELECT * FROM `menu` where prev=$param order by `numberitem`",$db);
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