<?php
//print_r($_POST);
//$podrazdelenie = $_POST['Structurnoe_podrazdlenie'];
function editPod($db){
$count=$_POST['newStroka'];

    $result2 = mysql_query("SELECT * FROM `Structurnoe_podrazdelenie`",$db);
	
    $m = mysql_fetch_array($result2);
	$rows=mysql_num_rows($result2);
	
$j=0;
if($rows>0){
do{ 

		 $famNew = "famEdit_".$j;
		 $famNew = $_POST[$famNew];
		 $imyaNew = "imyaEdit_".$j;
		 $imyaNew =$_POST[$imyaNew];
		 $otchNew = "otchEdit_".$j;
		 $otchNew =$_POST[$otchNew];
		 $famOld = $m['Nazvanie_podrazdeleniya'];
		 $imyaOld = $m['Rukovoditel'];
		 $otchOld = $m['telephon'];
		 $id=$m['id_podrazdeleniya'];
		 if((isset($famNew))&&(isset($imyaNew))&&(isset($otchNew)))
			$result =mysql_query("UPDATE `Structurnoe_podrazdelenie` SET `Nazvanie_podrazdeleniya`='$famNew',`Rukovoditel`='$imyaNew',`telephon`='$otchNew' WHERE `id_podrazdeleniya` = '$id'",$db);
		 else {$result =mysql_query("Delete from Structurnoe_podrazdelenie 
								WHERE `id_podrazdeleniya` = '$id'",$db);}
$j++;
}

while($m = mysql_fetch_array($result2));
}

  while($j<$count){
	  echo "     ".$j;
	  
	                 $famNew = "famEdit_".$j;
					 $famNew = $_POST[$famNew];
					 $imyaNew = "imyaEdit_".$j;
                     $imyaNew =$_POST[$imyaNew];
					 $otchNew = "otchEdit_".$j;
                     $otchNew =$_POST[$otchNew];
    
      $result =mysql_query("INSERT INTO `Structurnoe_podrazdelenie` ( `id_podrazdeleniya` , `Nazvanie_podrazdeleniya` , `Rukovoditel` , `telephon`  ) VALUES ('', '$famNew', '$imyaNew', '$otchNew')",$db);
	  $j++;
  }
}
 $url = $_SERVER['PHP_SELF']."?nav=dicPod";
echo "<script>
document.location.href='$url';</script>";
?>