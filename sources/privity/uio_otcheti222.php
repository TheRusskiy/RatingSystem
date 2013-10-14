


<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'  />
    <title>Система мониторинга деятельности подразделения</font></title>
  <link type=text/css href=/styles/common.css rel=stylesheet>
  <script language='JavaScript'>
//<!-- hide

// -->
</script>
</head>
<body>
<?php 
function Form(){
	$pagetext = "<form  name = 'form1' method=POST action='uio_editSotrudniki.php'  >
	
	 </select>
         <table border=1 width=100 height=10 id ='tb1' name='tb1'>
		 <tr>
		    <td width=5%>№</td>
		    <td width=5%>Адрес&nbsp;здания (поме-щения)</td>
			<td width=5%>Корпус&nbsp;№</td>
			<td width=5%>Этаж</td>
			<td width=5%>Комната&nbsp;№</td>
			<td width=5%>Сигнализация</td>
			
			
         </tr>
		 ";
		 $db = mysql_connect('localhost','Shaman','123');
    mysql_select_db('mon',$db);
  
	
	
				 
					 $edit = mysql_query("SELECT Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati, Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya,Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer,
	Pomesenie.Etag,  Pomesenie.Kolvo_uchebnih_rabochih_mest,  Pomesenie.Kolvo_mest_komment,  Pomesenie.Kategoriya_pomeseniya,
	Pomesenie.Nomer_komnati,  Pomesenie.Registracionni_nomer_pomeseniya,  Pomesenie.Nomer_korpusa_FK,  Korpus.Adres_zdaniya,
	Ispolzovnie_pomesheniya.id_podrazdeleniya_FK,  Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK,
	Ispolzovnie_pomesheniya.Vid_ispolzovaniya,  Ispolzovnie_pomesheniya.Obremenenie_pomesheniya,  Ispolzovnie_pomesheniya.Rejim_ispolzovaniya,
	Ispolzovnie_pomesheniya.Data_nachala_ispolzovamiya,  Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya,  Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK,  Structurnoe_podrazdelenie.id_podrazdeleniya,  Structurnoe_podrazdelenie.Nazvanie_podrazdeleniya,  Structurnoe_podrazdelenie.Rukovoditel,  Structurnoe_podrazdelenie.telephon,
	Otvetstvennoe_lico.id_otvetstvennogo_lica,  Otvetstvennoe_lico.Familiya,  Otvetstvennoe_lico.Imya,  Otvetstvennoe_lico.Otchestvo,
	Otvetstvennoe_lico.id_podrazdeleniya_FK,  
	Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK,
	Tehnicheskoe_sostoyanie_pomeseniya.Okna,  Tehnicheskoe_sostoyanie_pomeseniya.Dveri,  Tehnicheskoe_sostoyanie_pomeseniya.Steni,
	Tehnicheskoe_sostoyanie_pomeseniya.Pol,  Tehnicheskoe_sostoyanie_pomeseniya.Potolok,  Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplanirovok,  Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplan_komment,
	Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj,  Tehnicheskoe_sostoyanie_pomeseniya.Sanitarni_pasport_nomer,
	Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK,  Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr
  FROM
	Korpus
	INNER JOIN Pomesenie ON (Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK)
	INNER JOIN Ispolzovnie_pomesheniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK)
	INNER JOIN Structurnoe_podrazdelenie ON (Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya)
	INNER JOIN Otvetstvennoe_lico ON (Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK = Otvetstvennoe_lico.id_otvetstvennogo_lica)
	AND (Structurnoe_podrazdelenie.id_podrazdeleniya = Otvetstvennoe_lico.id_podrazdeleniya_FK)
	INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK)

	WHERE (Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya='0000-00-00') AND (Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr='0') AND (Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj='0' )",$db);
					  $pom = mysql_fetch_array($edit);
					  $i=1;
				  do{
					$adr = $pom['Adres_zdaniya'];
					$Vid_prava = $pom['Vid_prava'];
					$Naimenovanie_zdaniya = $pom['Naimenovanie_zdaniya'];
					$Nomer_korpusa = $pom['Nomer_korpusa_FK'];
					$Etag = $pom['Etag'];
					$Nomer_komnati = $pom['Nomer_komnati'];
					$Obshaya_ploshad = $pom['Obsaya_plosad'];
					$Categoriya_pomesh = $pom['Kategoriya_pomeseniya'];
					$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					$Obremenenie = $pom['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Structurnoe_podrazdlenie = $pom['Nazvanie_podrazdeleniya'];
				    $Okna = $pom['Okna'];
					$Dveri = $pom['Dveri'];
					$Steni = $pom['Steni'];
					$Potolok = $pom['Potolok'];
					$Pol = $pom['Pol'];
					$Nalichie_pereplanirovok = $pom['Nalichie_pereplanirovok'];
					if($Nalichie_pereplanirovok=="0")$Nalichie_pereplanirovok="нет";
					if($Nalichie_pereplanirovok=="1")$Nalichie_pereplanirovok="да";
					$Сигнализация  = $pom['Signalizaciya_poj'];
					if($Сигнализация=="0")$Сигнализация="нет";
					if($Сигнализация=="1")$Сигнализация="да";
					$Сигнализация2  = $pom['Signalizaciya_ohr'];
					if($Сигнализация2=="0")$Сигнализация2="нет";
					if($Сигнализация2=="1")$Сигнализация2="да";
									
				$pagetext=$pagetext."<tr>
		 <td>$i
		 </td>
		 <td>$adr
		 </td>
		 <td>$Nomer_korpusa
		 </td>
		 <td>$Etag
		 </td>
		 <td>$Nomer_komnati
		 </td>
		
		 <td>Пожарная-$Сигнализация<br> Охранная-$Сигнализация2
		 </td>
		 </tr>
		 
		 ";
				
				$i++;}
			while($pom = mysql_fetch_array($edit));	
		
		 $pagetext=$pagetext."  </table>  </form>";
	
	return $pagetext;
}

?>
<?php
include "core/skin.php";
if($_SESSION['user_id']=='2'){
 echo fSkin ("Управление имущественными отношениями","<br><a href='uio_spravochniki.php'>   Введение&nbspсправочников</a>",Form());
}
else { echo fSkin ("Управление имущественными отношениями","<br><a href='uio_inventarizaciya.php'>Инвентаризация </a>"."<br><a href='uio_otcheti.php'>Отчеты</a>",Form());
}

?>