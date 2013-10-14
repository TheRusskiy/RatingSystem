<?php
//print_r($_POST);

function editArenda($db){
$count=$_POST['newStroka'];

    $result2 = mysql_query("SELECT  id_arendatora,Nazvanie ,Adres ,Rekviziti  FROM `Arendatory`",$db);
	
    $m = mysql_fetch_array($result2);
	$rows=mysql_num_rows($result2);
	echo " count  ".$rows;
$j=0;
if($rows>0){


do{ 
		 $famNew = "famEdit_".$j;
		 $famNew = $_POST[$famNew];
		 $imyaNew = "imyaEdit_".$j;
		 $imyaNew =$_POST[$imyaNew];
		 $otchNew = "otchEdit_".$j;
		 $otchNew =$_POST[$otchNew];
		 $famOld = $m['Nazvanie'];
		 $imyaOld = $m['Adres'];
		 $otchOld = $m['Rekviziti'];
		 $id=$m['id_arendatora'];
		 echo "id ".$id;
		 if((isset($famNew))&&(isset($imyaNew))&&(isset($otchNew)))
			$result =mysql_query("UPDATE `Arendatory` SET `Nazvanie` =   '$famNew',
			`Adres`='$imyaNew',`Rekviziti`='$otchNew' 
								WHERE `id_arendatora` = '$id'",$db);
		 else {$result =mysql_query("Delete from `Arendatory` 
								WHERE `id_arendatora` = '$id'",$db);}
$j++;
}
while($m = mysql_fetch_array($result2));
}

  while($j<$count){
	 
	  
	                 $famNew = "famEdit_".$j;
					 $famNew = $_POST[$famNew];
					 $imyaNew = "imyaEdit_".$j;
                     $imyaNew =$_POST[$imyaNew];
					 $otchNew = "otchEdit_".$j;
                     $otchNew =$_POST[$otchNew];
    echo "$otchNew";
      $result =mysql_query("INSERT INTO `Arendatory`(`Nazvanie`,`Adres`,`Rekviziti`) VALUES('$famNew','$imyaNew','$otchNew')",$db);
	  $j++;
	  
  }

}
$url = $_SERVER['PHP_SELF']."?nav=dicArenda";
echo "<script>
document.location.href='$url';</script>";
?>
