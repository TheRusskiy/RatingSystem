<?php



print_r($_POST);
function editKorpus( $db){
$count=$_POST['Count'];
echo $count;
   /* $result2 = mysql_query('SELECT * FROM `Korpus` ',$db);
	
    $m = mysql_fetch_array($result2);
$j=1;
do{ 
	$nomerNew = "nomerEdit".$j;
                   $nomerNew = $_POST[$nomerNew];
                    $adrNew = "adrEdit".$j;
                     $adrNew =$_POST[$adrNew];
                   $nomerOld = $m['Nomer_korpusa'];
                   $adrOld = $m['Adres_zdaniya'];
                $result =mysql_query("UPDATE `Korpus` SET `Adres_zdaniya` = '$adrNew',`Nomer_korpusa`='$nomerNew' 
                                            WHERE `Nomer_korpusa` = '$nomerOld'",$db);
$j++;
}*/


$result2 = mysql_query('DELETE from `Korpus` ',$db);
//while($m = mysql_fetch_array($result2));
$j=1;
  while($j<$count){
	  $nomerNew = "nomerEdit".$j;
      $nomerNew = $_POST[$nomerNew];
      $adrNew = "adrEdit".$j;
      $adrNew =$_POST[$adrNew];
      $nomerOld = $m['Nomer_korpusa'];
      $adrOld = $m['Adres_zdaniya'];
	  if(($nomerNew!='')&($adrNew!=''))
      $result =mysql_query("INSERT INTO `Korpus` ( `Nomer_korpusa` , `Adres_zdaniya` ) VALUES ('$nomerNew', '$adrNew')",$db);
	  $j++;
  }
//include "core/skin.php";
//$id =  $_SESSION['user_id'];
//session_start();
//$_SESSION['user_id']=$id;

//if($_SESSION['user_id']=='2'){
// echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>   ��������&nbsp������������</a>","<br><a href='uio_spravochnikKorpusov.php'>��������� ������� </a>");
// echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>   ��������&nbsp������������</a>","��������� �������");

//}
//else {echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>"
//"<br><a href='uio_otcheti.php'>������</a>","<br><a href='uio_spravochnikKorpusov.php'>��������� ������� </a>");}
 }
	
 $url = $_SERVER['PHP_SELF']."?nav=dicKor";
echo "<script>
document.location.href='$url';
</script>";
?>