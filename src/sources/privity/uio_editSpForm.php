<?php
function editSpForm($db){
	//print_r($_POST);
	
	$table = $_POST['table'];
	$col = $_POST['col'];
	
  $count=$_POST['count'];
  $result2 = mysql_query("Delete FROM `".$table."` ",$db);
  $j=0;
  while($j<=$count){
	 // try{
	    $famNew2 = "famEdit_".$j;
	    $famNew = $_POST[$famNew];
	  if(isset($_POST[$famNew2])) $famNew = $_POST[$famNew2];
		if(isset($famNew))
	      $result =mysql_query("INSERT INTO `".$table."` ( `id`,`".$col."` ) VALUES ('$j','$famNew')",$db);
	    $j++;
	//  }
	//  catch(Exeption $e){}
  }
  if($table == 'sostoyanie') $url = $_SERVER['PHP_SELF']."?nav=dicSost";	
if($table == 'etag') $url = $_SERVER['PHP_SELF']."?nav=dicEtag";
if($table == 'vidprava') $url = $_SERVER['PHP_SELF']."?nav=dicPrav";
if($table == 'kategoriyapomesheniya') $url = $_SERVER['PHP_SELF']."?nav=dicKategoriya";
if($table == 'vidispolzovaniya') $url = $_SERVER['PHP_SELF']."?nav=dicIspol";
if($table == 'obremenenie') $url = $_SERVER['PHP_SELF']."?nav=dicObremenenie";
echo "<script>
document.location.href='$url';</script>";
}	

?>