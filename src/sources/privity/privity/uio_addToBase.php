<?php

//include "core/skin.php";



//$base = $_POST['Uchastnik_kom[]'];
//print_r($_POST);
//print_r($GLOBALS);
function addTobase($db){
$Uchastnik = $_POST["Uchastnik_kom"];
$dataNachalaEdit = $_POST["dataNachalaEdit"];
$PodrazdeleieEdit = $_POST['Podrazdelenie'];

$Arendator = $_POST['Arenda'];
$oldKor=$_POST['nomerKor'];
$oldKom=$_POST['nomerKom'];

$Vid_prava = $_POST['Vid_prava'];
$Sootvetstvie = $_POST['Sootvetstvie'];
$Naimenovanie_zdaniya = $_POST['Naimenovanie_zdaniya'];
$Nomer_korpusa = $_POST['Nomer_korpusa'];
//if(isset($_POST['Etag']))
$Etag = $_POST['Etag2'];
//else $Etag = $_POST['Etag2'];

$Nomer_komnati = $_POST['Nomer_komnati'];
$Nomer_tehpasporta = $_POST['Nomer_tehpasporta'];
$Obshaya_ploshad = $_POST['Obshaya_ploshad'];
$Categoriya_pomesh = $_POST['Categoriya_pomesh'];
$Naznachenie_pomesh = $_POST['Naznachenie_pomesh'];
$Vid_ispolzovanie = $_POST['Vid_ispolzovanie'];
//echo $Vid_ispolzovanie;
$Obremenenie = $_POST['Obremenenie'];
$Rejim_ispol = $_POST['Rejim_ispol'];
//echo $Rejim_ispol."   ".$_POST['Rejim_ispol'];
$Kolvo_mest = $_POST['Kol-vo_mest'];
$Kolvo_mest_komment = $_POST['Kol-vo_mest_komment'];
$Structurnoe_podrazdlenie = $_POST['Structurnoe_podrazdlenie'];
if (isset($Structurnoe_podrazdlenie)){}
else $Structurnoe_podrazdlenie=$PodrazdeleieEdit;
$Rukovoditel_podrazdeleniya = $_POST['Rukovoditel_podrazdeleniya'];
$Otvetstvennoe_lico = $_POST['Otvetstvennoe_lico'];
$Telefon = $_POST['Telefon'];
$Okna = $_POST['Okna'];
$Dveri = $_POST['Dveri'];
$Steni = $_POST['Steni'];
$Potolok = $_POST['Potolok'];
$Pol = $_POST['Pol'];
$Nalichie_pereplanirovok = $_POST['Nalichie_pereplanirovok'];
//echo $Nalichie_pereplanirovok. "   ".$_POST['Nalichie_pereplanirovok'];
$Nalichie_pereplanirovok_komment = $_POST['Nalichie_pereplanirovok_komment'];
$Сигнализация=0;
$Сигнализация2=0;
if(isset($_POST['Сигнализация']))$Сигнализация  = $_POST['Сигнализация'];
else	$Сигнализация=0;										   
if(isset($_POST['Сигнализация2']))$Сигнализация2  = $_POST['Сигнализация2'];
else	$Сигнализация2=0;
	
$Zamechaniya = $_POST['Zamechaniya'];
$Predlojeniya = $_POST['Predlojeniya'];
$Data = $_POST['Data'];
//$Uchastnik = $_POST['Uchastnik'];
$Data_nachala = $_POST['Data_nachala'];
$Data_okonchaniya  = $_POST['Data_okonchaniya'];
if($_POST['Data_okonchaniya']=="") $Data_okonchaniya="0000-00-00";
else	$Data_okonchaniya  = $_POST['Data_okonchaniya'];

//$Data_okonchaniya = $_POST['Data_okonchaniya'];
$San_pasport = $_POST['San_pasport'];
 // $db = mysql_connect($CONFS['sql_host'] 	,$CONFS['sql_user'] ,$CONFS['sql_pass'] );
   // mysql_select_db($CONFS['sql_database'] ,$db);
if($_POST['del']=='Удалить данные о помещение'){
	 $result_pom = mysql_query("SELECT * FROM Pomesenie WHERE Nomer_komnati ='$oldKom' and Nomer_korpusa_FK ='$oldKor'",$db);
	  
	  $m = mysql_fetch_array($result_pom);
	  do{
		 
	  $nomer_pom=$m['Registracionni_nomer_pomeseniya']; 
	  }
	  while($m = mysql_fetch_array($result_pom));
	  $result1 = mysql_query("SELECT Nomer_inv_komissii_FK  FROM Tehnicheskoe_sostoyanie_pomeseniya where  Registracionni_nomer_pomeseniya_FK='$nomer_pom'",$db);
	  $m = mysql_fetch_array($result1);
	  do{
		$id_inv_kom=$m['Nomer_inv_komissii_FK']; 
	  }while($m = mysql_fetch_array($result1));
	  
	  
	  $result1 = mysql_query("DELETE FROM Pomesenie where Registracionni_nomer_pomeseniya=$nomer_pom",$db);
	
	    $result2 = mysql_query("DELETE FROM Ispolzovnie_pomesheniya where Registracionni_nomer_pomeseniya_FK=$nomer_pom",$db);
	
	    $result3 = mysql_query("DELETE FROM Tehnicheskoe_sostoyanie_pomeseniya where Registracionni_nomer_pomeseniya_FK=$nomer_pom",$db);
	  
	    $result4 = mysql_query("DELETE FROM Otmetka_invent_komissii where Nomer_inv_komissii=$id_inv_kom",$db);
	
	    $result5 = mysql_query("DELETE FROM Uchastnik_inv_komissii_has_Otmetka_invent_komissii where  Nomer_inv_komissii_FK  =$id_inv_kom",$db);
	
	 $resultAdd ='Помещение удалено';
	  $url = $_SERVER['PHP_SELF']."?nav=edit";
echo "<script>
document.location.href='$url';
</script>";
	
}
if($_POST['add']=='Добавить данные'){
	$flag='false';
	$proverka = mysql_query("SELECT * FROM Pomesenie WHERE Nomer_komnati ='$Nomer_komnati' and Nomer_korpusa_FK ='$Nomer_korpusa'");
	if (mysql_num_rows($proverka)>0) {
		$flag='true';
	
	//  while($m = mysql_fetch_array($proverka));
	//	$proverka = mysql_query("select Data_okonchaniya_ispolzovaniya from Ispolzovnie_pomesheniya join Pomesenie where Nomer_komnati ='$Nomer_komnati' and    Nomer_korpusa_FK ='$Nomer_korpusa' ",$db);
	//	$pr = mysql_fetch_array($proverka);
	//	 do{

		//	 $dataO=$pr['Data_okonchaniya_ispolzovaniya']; 
			 
	 //     }while($pr = mysql_fetch_array($proverka));
		
	//	if ((mysql_num_rows($proverka)>0)&&($dataO!='0000-00-00')) { $flag = 'false';} else {$flag='true';};
	}
	
	if($flag=='false'){
	
	
	 
	  $result1 = mysql_query("SELECT * FROM Structurnoe_podrazdelenie where Nazvanie_podrazdeleniya='$Structurnoe_podrazdlenie' ORDER BY id_podrazdeleniya DESC",$db);
	  $m = mysql_fetch_array($result1);
	//  do{
		$id_podrazdeleniya=$m['id_podrazdeleniya']; 
	 // }while($m = mysql_fetch_array($result1));
	
	   $result2 = mysql_query("INSERT INTO `Otmetka_invent_komissii` ( `Nomer_inv_komissii` , `Zamechaniya_invent_komissii` , `Predlojeniya` , `Data_invent` ) 
	  VALUES ('', '$Zamechaniya', '$Predlojeniya', '$Data')",$db);
	
	  $result3 = mysql_query("SELECT * FROM Otmetka_invent_komissii ORDER BY Nomer_inv_komissii DESC",$db);
	  $m2 = mysql_fetch_array($result3);
	 // do{
		$nomer=$m2['Nomer_inv_komissii']; 
	//  }while($m2 = mysql_fetch_array($result3));
	  
	
	for($i=0;$i<count($Uchastnik);$i++){
	  $result4 = mysql_query("INSERT INTO `Uchastnik_inv_komissii_has_Otmetka_invent_komissii` ( `id_uchastnika_inv_komissii_FK` , `Nomer_inv_komissii_FK` )   VALUES ('$Uchastnik[$i]', '$nomer')",$db);
	}
	  
	
	  $result5 = mysql_query("INSERT INTO `Pomesenie` ( `Registracionni_nomer_pomeseniya` , `Vid_prava` , `V_sootvetstvii_s` , `Naznachenie_pomeseniya` , `Naimenovanie_zdaniya` , `Obsaya_plosad` , `Po_tehpasportu_nomer` , `Etag` , `Kolvo_uchebnih_rabochih_mest` , `Kolvo_mest_komment` , `Kategoriya_pomeseniya` , `Nomer_komnati` , `Nomer_korpusa_FK` ) 
	  VALUES ('', '$Vid_prava', '$Sootvetstvie', '$Naznachenie_pomesh', '$Naimenovanie_zdaniya', '$Obshaya_ploshad', '$Nomer_tehpasporta', '$Etag', '$Kolvo_mest', '$Kolvo_mest_komment', '$Categoriya_pomesh', '$Nomer_komnati', '$Nomer_korpusa')",$db);
	  $result_pom = mysql_query("SELECT * FROM Pomesenie ORDER BY `Registracionni_nomer_pomeseniya` Desc",$db);
	  $m = mysql_fetch_array($result_pom);
	//  do{
	  $nomer_pom=$m['Registracionni_nomer_pomeseniya']; 
	// }
	//  while($m = mysql_fetch_array($result_pom));
	$today = date("y.m.d"); 
	
	  $result5 = mysql_query("INSERT INTO `Tehnicheskoe_sostoyanie_pomeseniya` ( `Registracionni_nomer_pomeseniya_FK` , `Okna` , `Dveri` , `Steni` , `Pol` , `Potolok` , `Nalichie_pereplanirovok` , `Nalichie_pereplan_komment` , `Signalizaciya_poj`,`Signalizaciya_ohr` , `Sanitarni_pasport_nomer` , `Nomer_inv_komissii_FK`,`editData` ) 
	  VALUES ('$nomer_pom', '$Okna', '$Dveri', '$Steni', '$Pol', '$Potolok', '$Nalichie_pereplanirovok', '$Nalichie_pereplanirovok_komment', '$Сигнализация','$Сигнализация2', '$San_pasport', '$nomer','$today')",$db);
	// if($result5) echo "Dobavleno3";
 
	  echo
	  $result6 = mysql_query("INSERT INTO `Ispolzovnie_pomesheniya` ( `id_podrazdeleniya_FK` , `Registracionni_nomer_pomeseniya_FK` , `Vid_ispolzovaniya` , `Obremenenie_pomesheniya` , `Rejim_ispolzovaniya` , `Data_nachala_ispolzovamiya` , `Data_okonchaniya_ispolzovaniya` , `id_otvetstvennogo_lica_FK`,`id_Arendatora` ) 
	  VALUES ('$Structurnoe_podrazdlenie', '$nomer_pom', '$Vid_ispolzovanie', '$Obremenenie', '$Rejim_ispol', '$Data_nachala', '$Data_okonchaniya', '$Otvetstvennoe_lico','$Arendator')",$db);
	//  if($result6) echo "Dobavleno4";
	$resultAdd ='Данные добавлены';
	 $url = $_SERVER['PHP_SELF']."?nav=dob";
echo "<script>
document.location.href='$url';
</script>";


} else {$resultAdd= "Данное уже добавлено в базу.Чтобы отредактировать данные о помещенение,войти в меню редактирование.";}
}


if($_POST['add']=="Внести изменения")
	   {
		   $flag='false';
	       $proverka = mysql_query("SELECT * FROM Pomesenie WHERE Nomer_komnati ='$Nomer_komnati' and Nomer_korpusa_FK ='$oldKor'");
	    if (mysql_num_rows($proverka)>0) {
		
	        while($m = mysql_fetch_array($proverka));
	        	$proverka = mysql_query("select Data_okonchaniya_ispolzovaniya from Ispolzovnie_pomesheniya join Pomesenie where Nomer_komnati ='$Nomer_komnati' and    Nomer_korpusa_FK ='$Nomer_korpusa' ",$db);
	    	$pr = mysql_fetch_array($proverka);
	    	 do{
			    $dataO=$pr['Data_okonchaniya_ispolzovaniya']; 
			 
	             }while($pr = mysql_fetch_array($proverka));
		
		         if ((mysql_num_rows($proverka)>0)&&($dataO!='0000-00-00')) { $flag = 'false';} else {$flag='true';};
	}
	if($flag=='true')
	   if($oldKom==$Nomer_komnati)
	       $flag='false';
	if($flag=='false'){
	   $reg_nomer = mysql_query("SELECT Registracionni_nomer_pomeseniya FROM Pomesenie WHERE Nomer_komnati ='$oldKom' and Nomer_korpusa_FK ='$oldKor'");
	   $reg2 = mysql_fetch_array($reg_nomer);
	    do{
	       $reg=$reg2['Registracionni_nomer_pomeseniya'];
	   }while($m = mysql_fetch_array($reg_nomer));
	 
	   
	   $resultAdd=$reg;
	   
	   $result1 = mysql_query("SELECT * FROM Structurnoe_podrazdelenie where Nazvanie_podrazdeleniya='$Structurnoe_podrazdlenie'",$db);
	  $m = mysql_fetch_array($result1);
	  do{
		$id_podrazdeleniya=$m['id_podrazdeleniya']; 
	  }while($m = mysql_fetch_array($result1));
	
	$result1 = mysql_query("SELECT Nomer_inv_komissii_FK  FROM Tehnicheskoe_sostoyanie_pomeseniya where  Registracionni_nomer_pomeseniya_FK='$reg'",$db);
	  $m = mysql_fetch_array($result1);
	  do{
		$id_inv_kom=$m['Nomer_inv_komissii_FK']; 
	  }while($m = mysql_fetch_array($result1));
	//  echo $Data." rrrrrrr";
	   $result2 = mysql_query("Update `Otmetka_invent_komissii` Set   `Zamechaniya_invent_komissii` = '$Zamechaniya' , `Predlojeniya`='$Predlojeniya', `Data_invent` ='$Data' where Nomer_inv_komissii = '$id_inv_kom'",$db);
	 
	 
	   $result2 = mysql_query("DELETE FROM `Uchastnik_inv_komissii_has_Otmetka_invent_komissii` WHERE `Nomer_inv_komissii_FK` = '$id_inv_kom'",$db);
	  
		
	for($i=0;$i<count($Uchastnik);$i++){
	  $result4 = mysql_query("INSERT INTO `Uchastnik_inv_komissii_has_Otmetka_invent_komissii` ( `id_uchastnika_inv_komissii_FK` , `Nomer_inv_komissii_FK` )   VALUES ('$Uchastnik[$i]', '$id_inv_kom')",$db);
	}
	  
	
	  $result5 = mysql_query("Update `Pomesenie` Set  `Nomer_komnati` ='$Nomer_komnati',`Nomer_korpusa_FK` = '$oldKor',`Vid_prava`= '$Vid_prava', `V_sootvetstvii_s` ='$Sootvetstvie', `Naznachenie_pomeseniya`= '$Naznachenie_pomesh', `Naimenovanie_zdaniya`='$Naimenovanie_zdaniya', `Obsaya_plosad`='$Obshaya_ploshad' , `Po_tehpasportu_nomer`='$Nomer_tehpasporta' , `Kolvo_uchebnih_rabochih_mest`='$Kolvo_mest' , `Kolvo_mest_komment`='$Kolvo_mest_komment' , `Kategoriya_pomeseniya`='$Categoriya_pomesh' where   Registracionni_nomer_pomeseniya='$reg'
	  ",$db);
	  
	//  if($result5)echo "update";
	$today = date("y.m.d"); 
 $result5 =  mysql_query("select *  from Tehnicheskoe_sostoyanie_pomeseniya where (
(Registracionni_nomer_pomeseniya_FK = '$reg')
 and
(Okna = '$Okna')  
and (Dveri  = '$Dveri') 
 and (Steni = '$Steni')
 and (Pol = '$Pol') and
(Potolok  = '$Potolok')  
and (Nalichie_pereplanirovok = '$Nalichie_pereplanirovok') and
(Nalichie_pereplan_komment  = '$Nalichie_pereplanirovok_komment')  and
(Signalizaciya_poj  = '$Сигнализация')  and (Sanitarni_pasport_nomer  = '$San_pasport')  and
(Nomer_inv_komissii_FK = '$id_inv_kom')  and
(Signalizaciya_ohr  = '$Сигнализация2') and
 (id_tehSostoyania =(select max(`id_tehSostoyania`) from Tehnicheskoe_sostoyanie_pomeseniya where `Registracionni_nomer_pomeseniya_FK` = '$reg'))) ",$db);
 $count = mysql_num_rows($result5);
 if ($count == 0)
 {

	  $result5 = mysql_query("INSERT INTO `Tehnicheskoe_sostoyanie_pomeseniya` ( `Registracionni_nomer_pomeseniya_FK` , `Okna` , `Dveri` , `Steni` , `Pol` , `Potolok` , `Nalichie_pereplanirovok` , `Nalichie_pereplan_komment` , `Signalizaciya_poj`,`Signalizaciya_ohr` , `Sanitarni_pasport_nomer` , `Nomer_inv_komissii_FK`,`editData` ) 
	  VALUES ('$reg', '$Okna', '$Dveri', '$Steni', '$Pol', '$Potolok', '$Nalichie_pereplanirovok', '$Nalichie_pereplanirovok_komment', '$Сигнализация','$Сигнализация2', '$San_pasport', '$id_inv_kom','$today')",$db);
	// if($result5) echo "Dobavleno3";
 }
	//$result5 = mysql_query("INSERT INTO `Tehnicheskoe_sostoyanie_pomeseniya` ( `Registracionni_nomer_pomeseniya_FK` , `Okna` , `Dveri` , `Steni` , `Pol` , `Potolok` , `Nalichie_pereplanirovok` , `Nalichie_pereplan_komment` , `Signalizaciya_poj`,`Signalizaciya_ohr` , `Sanitarni_pasport_nomer` , `Nomer_inv_komissii_FK`,`editData` ) 
//	  VALUES ('$reg', '$Okna', '$Dveri', '$Steni', '$Pol', '$Potolok', '$Nalichie_pereplanirovok', '$Nalichie_pereplanirovok_komment', '$Сигнализация','$Сигнализация2', '$San_pasport', '$id_inv_kom','$today')",$db);
	//  echo $result5." $result5";

	  
	//  $result5 = mysql_query("Update `Tehnicheskoe_sostoyanie_pomeseniya` Set  `Okna`= '$Okna', `Dveri`='$Dveri' , `Steni`='$Steni' , `Pol`= '$Pol', `Potolok`= '$Potolok', `Nalichie_pereplanirovok`='$Nalichie_pereplanirovok' , `Nalichie_pereplan_komment` ='$Nalichie_pereplanirovok_komment', `Signalizaciya_poj`='$Сигнализация',`Signalizaciya_ohr` ='$Сигнализация2', `Sanitarni_pasport_nomer`='$San_pasport'  where Registracionni_nomer_pomeseniya_FK='$reg'",$db);
	
	  
	  
	//  $result6 = mysql_query("Update `Ispolzovnie_pomesheniya` set `id_podrazdeleniya_FK` ='$Structurnoe_podrazdlenie',  `Vid_ispolzovaniya`='$Vid_ispolzovanie' , `Obremenenie_pomesheniya`= '$Obremenenie', `Rejim_ispolzovaniya`= '$Rejim_ispol', `Data_nachala_ispolzovamiya`= '$Data_nachala', `Data_okonchaniya_ispolzovaniya`='$Data_okonchaniya' , `id_otvetstvennogo_lica_FK`='$Otvetstvennoe_lico' where `Registracionni_nomer_pomeseniya_FK`='$reg'
	 // ",$db);
	 //echo $Data_okonchaniya;
	  if(($Data_okonchaniya != "") and ($Data_okonchaniya != "0000-00-00"))
	  {
		 $result6 = mysql_query("Update `Ispolzovnie_pomesheniya` set  `Data_okonchaniya_ispolzovaniya`='$Data_okonchaniya'  where `Registracionni_nomer_pomeseniya_FK`='$reg' ",$db); 
		 echo $_POST['Podrazdelenie'];
		 if($_POST['Podrazdelenie'] != $Structurnoe_podrazdlenie ){
		 $result6 = mysql_query("INSERT INTO `Ispolzovnie_pomesheniya`(`id_podrazdeleniya_FK`,`Vid_ispolzovaniya`,`Obremenenie_pomesheniya`,`Rejim_ispolzovaniya`,`Data_nachala_ispolzovamiya`,`Data_okonchaniya_ispolzovaniya`,`id_otvetstvennogo_lica_FK`,`Registracionni_nomer_pomeseniya_FK`,`id_Arendatora`) VALUES('$Structurnoe_podrazdlenie','$Vid_ispolzovanie' , '$Obremenenie',  '$Rejim_ispol',  '$Data_nachala', '0000-00-00' , '$Otvetstvennoe_lico','$reg','$Arendator') ",$db);}
 
	  }
	  else
	  {
		  //echo "data    ".$dataNachalaEdit."   ".$Data_okonchaniya;
		  $result6 = mysql_query("Select * from `Ispolzovnie_pomesheniya` where (
		  (`id_podrazdeleniya_FK` = '$Structurnoe_podrazdlenie')  and 
		  (`Vid_ispolzovaniya` = '$Vid_ispolzovanie') and
		  (`Obremenenie_pomesheniya` = '$Obremenenie') and 
		  (`Rejim_ispolzovaniya` = '$Rejim_ispol') and 
		  (`Data_nachala_ispolzovamiya` = '$dataNachalaEdit') and 
		  (`Data_okonchaniya_ispolzovaniya` = '$Data_okonchaniya') and 
		  (`id_otvetstvennogo_lica_FK` = '$Otvetstvennoe_lico' )and 
		  (`Registracionni_nomer_pomeseniya_FK` = '$reg' )and
		 ( 'id_ispolzovaniya' = (Select max(id_ispolzovaniya) from `Ispolzovnie_pomesheniya` where `Registracionni_nomer_pomeseniya_FK` = '$reg' )))
		   ",$db);
		  
		$count = mysql_num_rows($result6);
		//echo "count  ".$count;
 if ($count == 0)
 {  
	  $result6 = mysql_query("INSERT INTO `Ispolzovnie_pomesheniya`(`id_podrazdeleniya_FK`,`Vid_ispolzovaniya`,`Obremenenie_pomesheniya`,`Rejim_ispolzovaniya`,`Data_nachala_ispolzovamiya`,`Data_okonchaniya_ispolzovaniya`,`id_otvetstvennogo_lica_FK`,`Registracionni_nomer_pomeseniya_FK`,`id_Arendatora`) VALUES('$Structurnoe_podrazdlenie','$Vid_ispolzovanie' , '$Obremenenie',  '$Rejim_ispol',  '$Data_nachala', '$Data_okonchaniya' , '$Otvetstvennoe_lico','$reg','$Arendator') ",$db);
 }
	//echo $result6." $result6";
 //  echo "EDITTTTT";
	  }
   $resultAdd ='Изменения внесены'; }
   else {$resultAdd= "Данное помещение уже существует.";}

	
}

//$resultAdd ='Данные не добавленны,так как такое помещение уже существует и еще используется';
 $_POST['result']=$resultAdd;
 $_GET['nav']="result";
 $url = $_SERVER['PHP_SELF']."?nav=edit";
echo "<script>
document.location.href='$url';
</script>"
;
 //echo fSkin ("Управление имущественными отношениями",$items,"$resultAdd");
}
 $url = $_SERVER['PHP_SELF']."?nav=editForm";

?>