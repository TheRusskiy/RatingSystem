<?php
function editRejim($db){
	//print_r($_POST);
  $count=$_POST['count'];
  $result2 = mysql_query('Delete FROM `Rejim_ispol` ',$db);
  $j=0;
  while($j<=$count){
	 // try{
	    $famNew2 = "famEdit_".$j;
	    $famNew = $_POST[$famNew];
	  if(isset($_POST[$famNew2])) $famNew = $_POST[$famNew2];
		if(isset($famNew))
	      $result =mysql_query("INSERT INTO `Rejim_ispol` ( `id`,`rejim` ) VALUES ('$j','$famNew')",$db);
	    $j++;
	//  }
	//  catch(Exeption $e){}
  }
}	
 $url = $_SERVER['PHP_SELF']."?nav=dicRejim";
echo "<script>
document.location.href='$url';</script>";
?>