<?php
//print_r($_POST);
//$podrazdelenie = $_POST['Structurnoe_podrazdlenie'];
function editUch($db){
$count=$_POST['newStroka'];

    $result2 = mysql_query("SELECT id_uchastnika_inv_komissii,Familiya,Imya,Otchestvo FROM `Uchastnik_inv_komissii`",$db);
	
    $m = mysql_fetch_array($result2);
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
		 $id=$m['id_uchastnika_inv_komissii'];
		 if((isset($famNew))&&(isset($imyaNew))&&(isset($otchNew)))
			$result =mysql_query("UPDATE `Uchastnik_inv_komissii` SET `Familiya` =   '$famNew',`Imya`='$imyaNew',`Otchestvo`='$otchNew' 
								WHERE `id_uchastnika_inv_komissii` = '$id'",$db);
		 else {$result =mysql_query("Delete from `Uchastnik_inv_komissii` 
								WHERE `id_uchastnika_inv_komissii` = '$id'",$db);}
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
    
      $result =mysql_query("INSERT INTO `Uchastnik_inv_komissii` ( `id_uchastnika_inv_komissii` , `Familiya` , `Imya` , `Otchestvo`  ) VALUES ('', '$famNew', '$imyaNew', '$otchNew')",$db);
	  $j++;
  }

}
$url = $_SERVER['PHP_SELF']."?nav=dicUch";
echo "<script>
document.location.href='$url';</script>";
?>