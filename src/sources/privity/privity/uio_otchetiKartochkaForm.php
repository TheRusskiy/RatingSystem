
<?php
function kartochka($db){
    if (isset($_POST['Nomer_komnatiEdit']))
	    $Nomer_komnatiEdit=$_POST['Nomer_komnatiEdit'];
		else {$Nomer_komnatiEdit=$_GET['Nomer_komnatiEdit'];}
	if (isset($_POST['Nomer_korpusaEdit']))
	   $Nomer_korpusaEdit=$_POST['Nomer_korpusaEdit'];
	else  $Nomer_korpusaEdit=$_GET['Nomer_korpusaEdit'];
	//echo "ffffffffffffff    ".$Nomer_korpusaEdit;
	//echo "ffffffffffffff    ".$Nomer_komnatiEdit;
      if(isset($Nomer_komnatiEdit)){
			 if(isset($Nomer_korpusaEdit)){
				 
					 $edit = mysql_query("SELECT  Arendatory.id_arendatora, Arendatory.Nazvanie,Arendatory.Adres, Arendatory.Rekviziti ,Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya,Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer,
	Pomesenie.Etag,  Pomesenie.Kolvo_uchebnih_rabochih_mest,  Pomesenie.Kolvo_mest_komment,  Pomesenie.Kategoriya_pomeseniya,
	Pomesenie.Nomer_komnati,  Pomesenie.Registracionni_nomer_pomeseniya,  Pomesenie.Nomer_korpusa_FK,  Korpus.Adres_zdaniya,
	Ispolzovnie_pomesheniya.id_podrazdeleniya_FK,  Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK,
	Ispolzovnie_pomesheniya.Vid_ispolzovaniya,  Ispolzovnie_pomesheniya.Obremenenie_pomesheniya,  Ispolzovnie_pomesheniya.Rejim_ispolzovaniya,
	Ispolzovnie_pomesheniya.Data_nachala_ispolzovamiya,  Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya,  Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK,  Structurnoe_podrazdelenie.id_podrazdeleniya,  Structurnoe_podrazdelenie.Nazvanie_podrazdeleniya,  Structurnoe_podrazdelenie.Rukovoditel,  Structurnoe_podrazdelenie.telephon,
	Otvetstvennoe_lico.id_otvetstvennogo_lica,  Otvetstvennoe_lico.Familiya as otFam,  Otvetstvennoe_lico.Imya as otIm,  Otvetstvennoe_lico.Otchestvo as otOt,
	Otvetstvennoe_lico.id_podrazdeleniya_FK,  
	Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK,
	Tehnicheskoe_sostoyanie_pomeseniya.Okna,  Tehnicheskoe_sostoyanie_pomeseniya.Dveri,  Tehnicheskoe_sostoyanie_pomeseniya.Steni,
	Tehnicheskoe_sostoyanie_pomeseniya.Pol,  Tehnicheskoe_sostoyanie_pomeseniya.Potolok,  Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplanirovok,  Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplan_komment,
	Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj,  Tehnicheskoe_sostoyanie_pomeseniya.Sanitarni_pasport_nomer,
	Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK,  Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr,
	Otmetka_invent_komissii.Nomer_inv_komissii,  Otmetka_invent_komissii.Zamechaniya_invent_komissii,
	Otmetka_invent_komissii.Predlojeniya,  Otmetka_invent_komissii.Data_invent,  Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK, Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK,  Uchastnik_inv_komissii.id_uchastnika_inv_komissii,
	Uchastnik_inv_komissii.Familiya,  Uchastnik_inv_komissii.Imya,  Uchastnik_inv_komissii.Otchestvo
  FROM
	Korpus
	INNER JOIN Pomesenie ON (Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK)
	INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK)
	INNER JOIN Otmetka_invent_komissii ON (Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK = Otmetka_invent_komissii.Nomer_inv_komissii)
	INNER JOIN Uchastnik_inv_komissii_has_Otmetka_invent_komissii ON (Otmetka_invent_komissii.Nomer_inv_komissii = Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK)
	INNER JOIN Uchastnik_inv_komissii ON (Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK = Uchastnik_inv_komissii.id_uchastnika_inv_komissii)
	Left JOIN Ispolzovnie_pomesheniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK)
	
	left JOIN Structurnoe_podrazdelenie ON (Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya)
	left JOIN Otvetstvennoe_lico ON (Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK = Otvetstvennoe_lico.id_otvetstvennogo_lica)
	AND (Structurnoe_podrazdelenie.id_podrazdeleniya = Otvetstvennoe_lico.id_podrazdeleniya_FK)
	left JOIN Arendatory ON (Ispolzovnie_pomesheniya.id_Arendatora = Arendatory.id_arendatora)
	
	WHERE Pomesenie.Nomer_komnati='$Nomer_komnatiEdit' AND Pomesenie.Nomer_korpusa_FK='$Nomer_korpusaEdit' AND Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya='00.00.0000' order by Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania desc limit 1",$db);
	 $rows=mysql_num_rows($edit);
	     		 if($rows > 0)
				 {
					$pom = mysql_fetch_array($edit);
					$ArendatorNazvanie = $pom['Nazvanie'];
					$ArendatorAdres = $pom['Adres'];
					$ArendatorRekviziti = $pom['Rekviziti'];
					$Vid_prava = $pom['Vid_prava'];
					$Sootvetstvie = $pom['V_sootvetstvii_s'];
					$Naimenovanie_zdaniya = $pom['Naimenovanie_zdaniya'];
					$Nomer_korpusa = $Nomer_korpusaEdit;
					$Etag = $pom['Etag'];
					$Nomer_komnati = $Nomer_komnatiEdit;
					$Nomer_tehpasporta = $pom['Po_tehpasportu_nomer'];
					$Obshaya_ploshad = $pom['Obsaya_plosad'];
					$Adres_zdaniya=$pom['Adres_zdaniya'];
					$Categoriya_pomesh = $pom['Kategoriya_pomeseniya'];
					$Naznachenie_pomesh = $pom['Naznachenie_pomeseniya'];
					//$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					//$Obremenenie = $pom['Obremenenie_pomesheniya'];
					//$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Kolvo_mest_komment = $pom['Kolvo_mest_komment'];
					$Structurnoe_podrazdlenie = $pom['Nazvanie_podrazdeleniya'];
					$Rukovoditel_podrazdeleniya = $pom['Rukovoditel'];
					//$Otvetstvennoe_lico = $pom['otFam']." ".$pom['otIm']." ".$pom['otOt'];
					$Telefon = $pom['telephon'];
					$Okna = $pom['Okna'];
					$Dveri = $pom['Dveri'];
					$Steni = $pom['Steni'];
					$Potolok = $pom['Potolok'];
					$Pol = $pom['Pol'];
					$Nalichie_pereplanirovok = $pom['Nalichie_pereplanirovok'];
					if($Nalichie_pereplanirovok=='1') $Nalichie_pereplanirovok='да';
					else $Nalichie_pereplanirovok='нет';
					
					$Nalichie_pereplanirovok_komment = $pom['Nalichie_pereplan_komment'];
					
					
					$Сигнализация  = $pom['Signalizaciya_poj'];
					if($Сигнализация=="0")$Сигнализация="нет";
					if($Сигнализация=="1")$Сигнализация="да";
					$Сигнализация2  = $pom['Signalizaciya_ohr'];
					if($Сигнализация2=="0")$Сигнализация2="нет";
					if($Сигнализация2=="1")$Сигнализация2="да";
					$Zamechaniya = $pom['Zamechaniya_invent_komissii'];
					$Predlojeniya = $pom['Predlojeniya'];
					$Data = $pom['Data_invent'];
					
					$Data_nachala = $pom['Data_nachala_ispolzovamiya'];
					$Data_okonchaniya = $pom['Data_okonchaniya_ispolzovaniya'];
					if($Data_okonchaniya=='00.00.0000')$Data_okonchaniya='';
					$San_pasport = $pom['Sanitarni_pasport_nomer'];
					$edit = mysql_query("SELECT * 
FROM Ispolzovnie_pomesheniya
Left JOIN Otvetstvennoe_lico ON Otvetstvennoe_lico.id_otvetstvennogo_lica = Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK
WHERE Registracionni_nomer_pomeseniya_FK = ( 
SELECT Registracionni_nomer_pomeseniya
FROM Pomesenie
WHERE Nomer_korpusa_FK =1
AND Nomer_komnati =1 ) 
AND id_ispolzovaniya = ( 
SELECT max( id_ispolzovaniya ) 
FROM Ispolzovnie_pomesheniya
WHERE Registracionni_nomer_pomeseniya_FK = ( 
SELECT Registracionni_nomer_pomeseniya
FROM Pomesenie
WHERE Nomer_korpusa_FK ='$Nomer_korpusaEdit'
AND Nomer_komnati ='$Nomer_komnatiEdit' ) )",$db);
	             					$pom = mysql_fetch_array($edit);
					
					$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					$Obremenenie = $pom['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					
					
					$Otvetstvennoe_lico = $pom['Familiya']." ".$pom['Imya']." ".$pom['Otchestvo'];
					}
				 else {
				 $edit = mysql_query("SELECT Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya, Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer, Pomesenie.Etag, Pomesenie.Kolvo_uchebnih_rabochih_mest, Pomesenie.Kolvo_mest_komment, Pomesenie.Kategoriya_pomeseniya, Pomesenie.Nomer_komnati, Pomesenie.Registracionni_nomer_pomeseniya, Pomesenie.Nomer_korpusa_FK, Korpus.Adres_zdaniya, Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK, Tehnicheskoe_sostoyanie_pomeseniya.Okna, Tehnicheskoe_sostoyanie_pomeseniya.Dveri, Tehnicheskoe_sostoyanie_pomeseniya.Steni, Tehnicheskoe_sostoyanie_pomeseniya.Pol, Tehnicheskoe_sostoyanie_pomeseniya.Potolok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplanirovok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplan_komment, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj, Tehnicheskoe_sostoyanie_pomeseniya.Sanitarni_pasport_nomer, Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr, Otmetka_invent_komissii.Nomer_inv_komissii, Otmetka_invent_komissii.Zamechaniya_invent_komissii, Otmetka_invent_komissii.Predlojeniya, Otmetka_invent_komissii.Data_invent, Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK, Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK, Uchastnik_inv_komissii.id_uchastnika_inv_komissii, Uchastnik_inv_komissii.Familiya, Uchastnik_inv_komissii.Imya, Uchastnik_inv_komissii.Otchestvo
FROM Korpus
INNER JOIN Pomesenie ON ( Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK ) 
INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK ) 
INNER JOIN Otmetka_invent_komissii ON ( Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK = Otmetka_invent_komissii.Nomer_inv_komissii ) 
INNER JOIN Uchastnik_inv_komissii_has_Otmetka_invent_komissii ON ( Otmetka_invent_komissii.Nomer_inv_komissii = Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK ) 
INNER JOIN Uchastnik_inv_komissii ON ( Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK = Uchastnik_inv_komissii.id_uchastnika_inv_komissii ) 

	WHERE Pomesenie.Nomer_komnati='$Nomer_komnatiEdit' AND Pomesenie.Nomer_korpusa_FK='$Nomer_korpusaEdit' order by Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania desc limit 1",$db); 
	
					$pom = mysql_fetch_array($edit);
					$Vid_prava = $pom['Vid_prava'];
					$Sootvetstvie = $pom['V_sootvetstvii_s'];
					$Naimenovanie_zdaniya = $pom['Naimenovanie_zdaniya'];
					$Nomer_korpusa = $Nomer_korpusaEdit;
					$Etag = $pom['Etag'];
					$Nomer_komnati = $Nomer_komnatiEdit;
					$Nomer_tehpasporta = $pom['Po_tehpasportu_nomer'];
					$Obshaya_ploshad = $pom['Obsaya_plosad'];
					$Adres_zdaniya=$pom['Adres_zdaniya'];
					$Categoriya_pomesh = $pom['Kategoriya_pomeseniya'];
					$Naznachenie_pomesh = $pom['Naznachenie_pomeseniya'];
					
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Kolvo_mest_komment = $pom['Kolvo_mest_komment'];
					
					$Okna = $pom['Okna'];
					$Dveri = $pom['Dveri'];
					$Steni = $pom['Steni'];
					$Potolok = $pom['Potolok'];
					$Pol = $pom['Pol'];
					$Nalichie_pereplanirovok = $pom['Nalichie_pereplanirovok'];
					if($Nalichie_pereplanirovok=='1') $Nalichie_pereplanirovok='да';
					else $Nalichie_pereplanirovok='нет';
					
					$Nalichie_pereplanirovok_komment = $pom['Nalichie_pereplan_komment'];
					
					
					$Сигнализация  = $pom['Signalizaciya_poj'];
					if($Сигнализация=="0")$Сигнализация="нет";
					if($Сигнализация=="1")$Сигнализация="да";
					$Сигнализация2  = $pom['Signalizaciya_ohr'];
					if($Сигнализация2=="0")$Сигнализация2="нет";
					if($Сигнализация2=="1")$Сигнализация2="да";
					$Zamechaniya = $pom['Zamechaniya_invent_komissii'];
					$Predlojeniya = $pom['Predlojeniya'];
					$Data = $pom['Data_invent'];
					
					$Data_nachala = $pom['Data_nachala_ispolzovamiya'];
					$Data_okonchaniya = $pom['Data_okonchaniya_ispolzovaniya'];
					if($Data_okonchaniya=='00.00.0000')$Data_okonchaniya='';
					$San_pasport = $pom['Sanitarni_pasport_nomer'];
				 }
			//	 $Uchastnik = $pom["Uchastnik_kom"];
				// do{
			//	    $fam = $pom["Familiya"];
			//	   $imya=$pom["Imya"];
			//	    $otch = $pom["Otchestvo"];
			//		$uchastnik[]=$fam." ".$imya." ".$otch;
			//	 }
			//	 while($pom = mysql_fetch_array($edit));
			
			 }
	}
	
$pagetext = "<html>

<head>

<title>Система мониторинга деятельности подразделения</font></title>
 
  
</head>
<body>
<table border=0 width='100%' height='10'>
 <tr>
    <td height='48' colspan='2'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1 Месторасположение помещения</strong></td>
    <td>&nbsp;</td>
    
  </tr>
   <tr>
    <td ><label>Адрес здания&nbsp;<ins>&nbsp;&nbsp;$Adres_zdaniya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</ins></label></td>
   
   </tr>
  <tr>
  
   </tr>
    <tr>
    <td ><label>Вид права&nbsp;&nbsp<ins>&nbsp;&nbsp;$Vid_prava&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</ins></label><label>&nbsp;&nbsp;В соответсвии с&nbsp;<ins>&nbsp;&nbsp;$Sootvetstvie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</ins></label>
    </td>
   </tr>
   
   </tr>
    <tr>
    <td ><label>Наименование здания(помещения)&nbsp;</label>
    <ins>&nbsp;&nbsp;$Naimenovanie_zdaniya&nbsp;&nbsp;&nbsp;&nbsp;</ins>
	</td>
   </tr>
   
   
    <td><label>Корпус №&nbsp;<ins>&nbsp;&nbsp;$Nomer_korpusaEdit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</ins></label>&nbsp;&nbsp;<label>Этаж&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Etag&nbsp;&nbsp;</ins><label>&nbsp;&nbsp;Комната №</label><ins>&nbsp;&nbsp;$Nomer_komnatiEdit&nbsp;&nbsp;</ins><label>&nbsp;&nbsp;По техпаспорту №&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Nomer_tehpasporta&nbsp;&nbsp;</ins></td>
    
   </tr>
     <tr>
    <td ><label>Общая площадь,м2&nbsp;&nbsp;</label><ins>
    &nbsp;&nbsp;$Obshaya_ploshad&nbsp;&nbsp;</ins>
	</td>
   </tr>
   <tr>
  <td height='60' colspan='2'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2 Использование помещения</strong></td>
    <td>&nbsp;</td>
   
  </tr>
    <tr>
    <td ><label>Категория помещения&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Categoriya_pomesh&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Назначение помещения&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Naznachenie_pomesh&nbsp;&nbsp;</ins></td>
  
   </tr>
    <tr>
    <td ><label>Вид использования&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Vid_ispolzovanie&nbsp;&nbsp;</ins></td>
    <td >
	</td>
   </tr>
    <tr>
    <td ><label>Обременение помещения&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Obremenenie&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Арендатор&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$ArendatorNazvanie&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Адрес&nbsp;арендатора&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$ArendatorAdres&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Реквизиты&nbsp;арендатора&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$ArendatorRekviziti&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Режим использования&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Rejim_ispol&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Дата начала использования&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Data_nachala&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Дата окончания использования&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Data_okonchaniya&nbsp;&nbsp;</ins></td>
  
   </tr>
    <tr>
    <td ><label>Количество учебных (рабочих) мест&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Kolvo_mest&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Количество учебных (рабочих) мест - комментарии&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Kolvo_mest_komment&nbsp;&nbsp;</ins></td>
    
	<tr>
	  <td height='57' colspan='2'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3 Структурное подразделение, эксплуатирующее помещение</strong></td>
    <td>&nbsp;</td>
    
  </tr>
   </tr>
    <tr>
    <td ><label>Структурное подразделение&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Structurnoe_podrazdlenie&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Руководитель подразделения&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Rukovoditel_podrazdeleniya&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Ответственное лицо&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Otvetstvennoe_lico&nbsp;&nbsp;</ins></td>
    <td >
	</td>
   </tr>
    <tr>
    <td ><label>Телефон&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Telefon&nbsp;&nbsp;</ins></td>
    
   </tr>
   <tr>
    <td height='53' colspan='2'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4 Техническое состояние</strong> <strong>помещения</strong></td>
    <td>&nbsp;</td>
   </tr>
    <tr>
    <td ><label>Техническое состояние помещения:</label></td>
    
   </tr> 
  </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-окна&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Okna&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-двери&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Dveri&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-стены&nbsp;&nbsp; </label><ins>&nbsp;&nbsp;$Steni&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-потолок&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Potolok&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-пол&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Pol&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Наличие перепланировок&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Nalichie_pereplanirovok&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Наличие перепланировок - комментарии&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Nalichie_pereplanirovok_komment&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Номер санитарного паспорта&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$San_pasport&nbsp&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Сигнализация:</label></td>
   </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-пожарная </label><ins>&nbsp;&nbsp;$Сигнализация&nbsp&nbsp;</ins></td>
    
	
  
   </tr>
    <tr>
    <td ><label>&nbsp;&nbsp;&nbsp;&nbsp;-охранная&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Сигнализация2&nbsp;&nbsp;</ins></td>
	</tr>
	
	
   </tr>
   <tr>
    <td height='55'  colspan='2'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5 Отметки инвентаризационной комиссии</strong></td>
    
    
  </tr>
    <tr>
    <td ><label>Замечания инвентаризаци-онной комиссии&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Zamechaniya&nbsp;&nbsp;</ins></td>
    
   </tr>
    <tr>
    <td ><label>Предложения&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Predlojeniya&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Дата инвентаризации&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;$Data&nbsp;&nbsp;</ins></td>
   
   </tr>
    <tr>
    <td ><label>Участники инвентаризационной комиссии&nbsp;&nbsp;</label><ins>&nbsp;&nbsp;
    ";
	 $edit = mysql_query("SELECT Uchastnik_inv_komissii.Familiya, Uchastnik_inv_komissii.Imya, Uchastnik_inv_komissii.Otchestvo
FROM Korpus
INNER JOIN Pomesenie ON ( Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK ) 
INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK ) 
INNER JOIN Otmetka_invent_komissii ON ( Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK = Otmetka_invent_komissii.Nomer_inv_komissii ) 
INNER JOIN Uchastnik_inv_komissii_has_Otmetka_invent_komissii ON ( Otmetka_invent_komissii.Nomer_inv_komissii = Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK ) 
INNER JOIN Uchastnik_inv_komissii ON ( Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK = Uchastnik_inv_komissii.id_uchastnika_inv_komissii ) 

	WHERE Pomesenie.Nomer_komnati='$Nomer_komnatiEdit' AND Pomesenie.Nomer_korpusa_FK='$Nomer_korpusaEdit'",$db); 
	$pom = mysql_fetch_array($edit);
                                    $i=0;
		 do{
				    $fam = $pom["Familiya"];
				   $imya=$pom["Imya"];
				    $otch = $pom["Otchestvo"];
                                                                              if($i>0)$uchastniki=$uchastniki.",";
					$uchastniki=$uchastniki." ".$fam." ".$imya." ".$otch;
			                       $i++;
				 }
				 while($pom = mysql_fetch_array($edit));
$pagetext =$pagetext.	"$uchastniki&nbsp;&nbsp;</ins></td>
   </tr>
  </body>
</html>
";

return $pagetext;}

?>

