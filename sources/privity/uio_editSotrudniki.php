<?php
//print_r($_POST);
function editOtvetLica($db){
$podrazdelenie = $_POST['Structurnoe_podrazdlenie'];
$count=$_POST['newStroka'];

    $result2 = mysql_query("SELECT id_otvetstvennogo_lica,Familiya,Imya,Otchestvo FROM `Otvetstvennoe_lico` WHERE id_podrazdeleniya_FK='$podrazdelenie'",$db);
	$m = mysql_fetch_array($result2);
	 //$result3 = mysql_query("SELECT COUNT(*) WHERE id_podrazdeleniya_FK='$podrazdelenie'",$db);
	
   // $m2 = mysql_fetch_array($result3);
	//echo $m2;
	$rows=mysql_num_rows($result2);
	//echo " count  ".$rows;
$j=0;
if($rows>0){
do{

		 $famNew = "famEdit_".$j;
		 $famNew = $_POST[$famNew];
		 $imyaNew = "imyaEdit_".$j;
		 $imyaNew =$_POST[$imyaNew];
		 $otchNew = "otchEdit_".$j;
		 $otchNew =$_POST[$otchNew];
		 $famOld = $m['Familiya'];
		 $imyaOld = $m['Imya'];
		 $otchOld = $m['Otchestvo'];
		 $id=$m['id_otvetstvennogo_lica'];
	//	 echo  $famNew;
		 if((isset($famNew))&&(isset($imyaNew))&&(isset($otchNew)))
			 
			$result =mysql_query("UPDATE `Otvetstvennoe_lico` SET `Familiya` = '$famNew',`Imya`='$imyaNew',`Otchestvo`='$otchNew' 
								WHERE `id_otvetstvennogo_lica` = '$id'",$db);
			//if($result==true){$j++;echo "rrr2rr";}
			//}
		 
			
		 else {
			// if((isset($famNewOld))&&(isset($imyaNewOld))&&(isset($otchNewOld))){
			 $result =mysql_query("Delete from `Otvetstvennoe_lico` 
								WHERE `id_otvetstvennogo_lica` = '$id'",$db);
		// if($result==true){$j++;echo "rrrrr";}
			// }
		}
		 
		// echo $result;
		// echo "  $j";

//echo $j;
$j++;
}
while($m = mysql_fetch_array($result2));
}

  while($j<=$count){
	//  echo " ".$j;
	  
	                 $famNew = "famEdit_".$j;
					 $famNew = $_POST[$famNew];
					 $imyaNew = "imyaEdit_".$j;
                     $imyaNew =$_POST[$imyaNew];
					 $otchNew = "otchEdit_".$j;
                     $otchNew =$_POST[$otchNew];
     if((isset($famNew))&&(isset($imyaNew))&&(isset($otchNew))){
      $result =mysql_query("INSERT INTO `Otvetstvennoe_lico` ( `id_otvetstvennogo_lica` , `Familiya` , `Imya` , `Otchestvo` , `id_podrazdeleniya_FK` ) VALUES ('', '$famNew', '$imyaNew', '$otchNew', '$podrazdelenie')",$db);}
	  $j++;
  }
}
	
 $url = $_SERVER['PHP_SELF']."?nav=dicRabPod";
echo "<script>
document.location.href='$url';</script>";
?>