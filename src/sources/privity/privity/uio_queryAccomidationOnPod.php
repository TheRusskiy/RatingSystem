
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'  />
    <title>Система мониторинга деятельности подразделения</font></title>

  <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
   <link rel="stylesheet" type="text/css" href="sources//privity//tablesorter//themes//blue//style.css">
   <script  type="text/javascript" src="sources//privity//jquery-1.5.1.js"></script>
     <script  type="text/javascript" src="sources//privity//tablesorter//jquery-latest.js"></script>
   <script  type="text/javascript" src="sources//privity//tablesorter//jquery.tablesorter.js"></script>
<script type="text/javascript">
//$(document).ready(function(){
 // $(".tablesorter tr").hover(
  // function () {
//	$(this).addClass("tr_hover");
	
//	},
  // function (){
//	 $(this).removeClass("tr_hover");
 //  }
 //  );
 
  // $("#tb1").tablesorter();
   
//});
$(document).ready(function(){
	 $("#myTable").tablesorter();
	  $("#tb1").tablesorter();
	
	});
function ClichPod()
{
	document.getElementById("vid").value = 1;
}
function ClickPlos()
{
	document.getElementById("vid").value = 2;
}
</script>
  
</head>
<body>
<?php 


function Accomintadion($db,$vid,$st,$ot,$do){
$pod = $_POST['Structurnoe_podrazdlenie'];
	$pagetext = "
	
	
	<form  name = 'form1' method=POST  action='".$_SERVER['PHP_SELF']."?nav=search'>
	<input name='vid' id='vid' type='hidden' value=''>
	<table>
	<tr>
	     <input type=submit name='Pod' value='Поиск по подразделению' onClick='ClichPod()'>
		 <select class='input'  type=text style='width: 500px;' name='Structurnoe_podrazdlenie' width=10%  id='Structurnoe_podrazdlenie' >
	<option  value='не выбранно'>не выбрано</option>";
	
          $result2 = mysql_query('SELECT * FROM `Structurnoe_podrazdelenie` ',$db);
          $m = mysql_fetch_array($result2);
          do{
             $pagetext = $pagetext . '<option  value='.$m['id_podrazdeleniya'].'>'.$m['Nazvanie_podrazdeleniya'].'</option>'; 
          }
         while($m = mysql_fetch_array($result2)); 

     $pagetext =$pagetext. "  </select>
	 </tr>
	 <tr>
	 </br>
	 <input type=submit name='Plos' id='Plos' value='Поиск по площади' onClick='ClickPlos()'>
	 <label>От</label>
	 <input name='ot' id='ot' type='text' value='0'/>
	  <label>До</label>
	 <input name='do' id='do' type='text' value='0'/>
	 </tr>
         <table  id ='tb1'  name ='tb1' class='tablesorter'  width='1500px'>
		 <thead>
		 <tr>
		     <th style='width:40px'>№</th>
		     <th style='width:210px'>Адрес&nbsp;здания (помещения)</th>
			 <th style='width:90px'>Вид&nbsp;права</th>
			 <th style='width:160px'>Наименование&nbsp;здания (поме-щения)</th>
			 <th style='width:90px'>Корпус&nbsp;№</th>
			 <th style='width:50px'>Этаж</th>
			 <th style='width:110px'>Комната&nbsp;№</th>
			 <th style='width:160px'>Общая&nbsp;площадь,&nbsp;м2</th>
			 <th style='width:160px'>Категория&nbsp;помещения</th>
			 <th style='width:150px'>Вид&nbsp;использования </th>
			 <th style='width:190px'>Обременение&nbsp;помещения</th>
			 <th style='width:160px'>Режим&nbsp;использования</th>
			 <th style='width:230px'>Количество&nbsp;учебных&nbsp;(рабочих)&nbsp;мест</th>
			 <th style='width:190px'>Структурное&nbsp;подразделение</th>
			 <th style='width:230px'>Техническое&nbsp;состояние&nbsp;помещения</th>
			 <th style='width:190px'>Наличие&nbsp;перепланировок</th>
			 <th style='width:110px'>Сигнализация</th>
			
			
         </tr>
		 </thead><tbody>
		 ";
		// $db = mysql_connect('localhost','Shaman','123');
 //   mysql_select_db('mon',$db);
  
	//$edit=" ";

				 
				
if($vid==1)
{
	 $edit = mysql_query("SELECT Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati, Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya, Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer, Pomesenie.Etag, Pomesenie.Kolvo_uchebnih_rabochih_mest, Pomesenie.Kolvo_mest_komment, Pomesenie.Kategoriya_pomeseniya, Pomesenie.Nomer_komnati, Pomesenie.Registracionni_nomer_pomeseniya, Pomesenie.Nomer_korpusa_FK, Korpus.Adres_zdaniya, Ispolzovnie_pomesheniya.id_podrazdeleniya_FK, Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK, Ispolzovnie_pomesheniya.Vid_ispolzovaniya, Ispolzovnie_pomesheniya.Obremenenie_pomesheniya, Ispolzovnie_pomesheniya.Rejim_ispolzovaniya, Ispolzovnie_pomesheniya.Data_nachala_ispolzovamiya,Ispolzovnie_pomesheniya.id_ispolzovaniya, Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya, Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK, Structurnoe_podrazdelenie.id_podrazdeleniya, Structurnoe_podrazdelenie.Nazvanie_podrazdeleniya, Structurnoe_podrazdelenie.Rukovoditel, Structurnoe_podrazdelenie.telephon, Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK, Tehnicheskoe_sostoyanie_pomeseniya.Okna, Tehnicheskoe_sostoyanie_pomeseniya.Dveri, Tehnicheskoe_sostoyanie_pomeseniya.Steni, Tehnicheskoe_sostoyanie_pomeseniya.Pol, Tehnicheskoe_sostoyanie_pomeseniya.Potolok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplanirovok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplan_komment, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj, Tehnicheskoe_sostoyanie_pomeseniya.Sanitarni_pasport_nomer, Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr, Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania
FROM Korpus
INNER JOIN Pomesenie ON ( Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK ) 
INNER JOIN Ispolzovnie_pomesheniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK ) 
INNER JOIN Structurnoe_podrazdelenie ON ( Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya )
INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK ) 
WHERE Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya='0000-00-00'  and Ispolzovnie_pomesheniya.id_podrazdeleniya_FK='$st' AND Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania
IN (

SELECT id_tehSostoyania
FROM `Tehnicheskoe_sostoyanie_pomeseniya` 
GROUP BY `Registracionni_nomer_pomeseniya_FK` 
) 
GROUP BY Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati",$db);
	 
}
if($vid==2)
{
 if(($ot>=0) and ($do>=0) and ($ot<$do))
	
	{
	 $edit = mysql_query("SELECT Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati, Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya, Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer, Pomesenie.Etag, Pomesenie.Kolvo_uchebnih_rabochih_mest, Pomesenie.Kolvo_mest_komment, Pomesenie.Kategoriya_pomeseniya, Pomesenie.Nomer_komnati, Pomesenie.Registracionni_nomer_pomeseniya, Pomesenie.Nomer_korpusa_FK, Korpus.Adres_zdaniya, Ispolzovnie_pomesheniya.id_podrazdeleniya_FK, Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK, Ispolzovnie_pomesheniya.Vid_ispolzovaniya, Ispolzovnie_pomesheniya.Obremenenie_pomesheniya, Ispolzovnie_pomesheniya.Rejim_ispolzovaniya, Ispolzovnie_pomesheniya.Data_nachala_ispolzovamiya,Ispolzovnie_pomesheniya.id_ispolzovaniya, Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya, Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK, Structurnoe_podrazdelenie.id_podrazdeleniya, Structurnoe_podrazdelenie.Nazvanie_podrazdeleniya, Structurnoe_podrazdelenie.Rukovoditel, Structurnoe_podrazdelenie.telephon, Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK, Tehnicheskoe_sostoyanie_pomeseniya.Okna, Tehnicheskoe_sostoyanie_pomeseniya.Dveri, Tehnicheskoe_sostoyanie_pomeseniya.Steni, Tehnicheskoe_sostoyanie_pomeseniya.Pol, Tehnicheskoe_sostoyanie_pomeseniya.Potolok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplanirovok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplan_komment, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj, Tehnicheskoe_sostoyanie_pomeseniya.Sanitarni_pasport_nomer, Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr, Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania
FROM Korpus
INNER JOIN Pomesenie ON ( Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK ) 
INNER JOIN Ispolzovnie_pomesheniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK ) 
INNER JOIN Structurnoe_podrazdelenie ON ( Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya )
INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK ) 
WHERE (Pomesenie.Obsaya_plosad>=$ot and Pomesenie.Obsaya_plosad<=$do) AND Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania
IN (

SELECT id_tehSostoyania
FROM `Tehnicheskoe_sostoyanie_pomeseniya` 
GROUP BY `Registracionni_nomer_pomeseniya_FK` 
) 
GROUP BY Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati",$db);
	 
}
}
if(isset($edit)){
 
					  $pom = mysql_fetch_array($edit);
					  $i=1;
				  do{
					  $regNomer = $pom['Registracionni_nomer_pomeseniya_FK'];
					 $tehSost = mysql_query("SELECT * FROM `Tehnicheskoe_sostoyanie_pomeseniya` where                                `Registracionni_nomer_pomeseniya_FK` = '$regNomer' order BY `id_tehSostoyania` desc limit 1",$db);
                    $tehPom =  mysql_fetch_array($tehSost);
					$adr = $pom['Adres_zdaniya'];
					$Vid_prava = $pom['Vid_prava'];
					$Naimenovanie_zdaniya = $pom['Naimenovanie_zdaniya'];
					$Nomer_korpusa = $pom['Nomer_korpusa_FK'];
					$Etag = $pom['Etag'];
					$Nomer_komnati = $pom['Nomer_komnati'];
					$Obshaya_ploshad = $pom['Obsaya_plosad'];
					$Categoriya_pomesh = $pom['Kategoriya_pomeseniya'];
					$idIspol= $pom['id_ispolzovaniya'];
					//$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					//$Obremenenie = $pom['Obremenenie_pomesheniya'];
					//$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					if($pom['Data_okonchaniya_ispolzovaniya']=="0000-00-00")
					   $Structurnoe_podrazdlenie = $pom['Nazvanie_podrazdeleniya'];
					else{
					$Structurnoe_podrazdlenie="Не используется";
					}
					$idStruct = $pom['id_podrazdeleniya'];
					$Okna = $tehPom['Okna'];
					$Dveri = $tehPom['Dveri'];
					$Steni = $tehPom['Steni'];
					$Potolok = $tehPom['Potolok'];
					$Pol = $tehPom['Pol'];
					$Nalichie_pereplanirovok = $tehPom['Nalichie_pereplanirovok'];
					if($Nalichie_pereplanirovok=="0")$Nalichie_pereplanirovok="нет";
					if($Nalichie_pereplanirovok=="1")$Nalichie_pereplanirovok="да";
					$Сигнализация  = $tehPom['Signalizaciya_poj'];
					if($Сигнализация=="0")$Сигнализация="нет";
					if($Сигнализация=="1")$Сигнализация="да";
					$Сигнализация2  = $tehPom['Signalizaciya_ohr'];
					if($Сигнализация2=="0")$Сигнализация2="нет";
					if($Сигнализация2=="1")$Сигнализация2="да";
						/*$edit = mysql_query("SELECT * 
FROM Ispolzovnie_pomesheniya
JOIN Otvetstvennoe_lico ON Otvetstvennoe_lico.id_otvetstvennogo_lica = Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK
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
WHERE Nomer_korpusa_FK ='$Nomer_korpusa '
AND Nomer_komnati ='$Nomer_komnati' ) )",$db);*/
if(isset($regNomer)){
$edit2 = mysql_query("SELECT * 
FROM Ispolzovnie_pomesheniya
WHERE Registracionni_nomer_pomeseniya_FK = $regNomer
AND id_ispolzovaniya = ( 
SELECT max( id_ispolzovaniya ) 
FROM Ispolzovnie_pomesheniya
WHERE Registracionni_nomer_pomeseniya_FK = $regNomer )",$db);

	             	$pom2 = mysql_fetch_array($edit2);
					if($pom['Data_okonchaniya_ispolzovaniya']=="0000-00-00")
					{
					$Vid_ispolzovanie = $pom2['Vid_ispolzovaniya'];
					$Obremenenie = $pom2['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom2['Rejim_ispolzovaniya'];
					}
					else
					{
						$Vid_ispolzovanie = "Не используется";
					$Obremenenie = "Не используется";
					$Rejim_ispol = "Не используется";
					}
}
				// $edit3 = mysql_query("Select max(id_ispolzovaniya) as maxId from Ispolzovnie_pomesheniya where Registracionni_nomer_pomeseniya_FK=$regNomer",$db);	
				// $pom3 = mysql_fetch_array($edit3);
				// $max = $pom['maxId'];
				// echo $max."sdfsf".$idIspol;
				if($pom2['id_ispolzovaniya'] == $idIspol)	{
							
				$pagetext=$pagetext."<tr >
		 <td>$i
		 </td>
		 <td>$adr
		 </td>
		 <td>$Naimenovanie_zdaniya
		 </td>
		 <td>$Naimenovanie_zdaniya
		 </td>
		 <td>$Nomer_korpusa
		 </td>
		 <td>$Etag
		 </td>
		 <td>$Nomer_komnati
		 </td>
		 <td>$Obshaya_ploshad
		 </td>
		 <td>$Categoriya_pomesh
		 </td>
		 <td>$Vid_ispolzovanie
		 </td>
		 <td>$Obremenenie
		 </td>
		 <td>$Rejim_ispol
		 </td>
		 <td>$Kolvo_mest
		 </td>
		 <td>$Structurnoe_podrazdlenie
		 </td>
		 <td>Окна-$Okna<br> Двери-$Dveri <br>Стены-$Steni <br>Потолок-$Potolok <br>Пол-$Pol
		 </td>
		 <td>$Nalichie_pereplanirovok
		 </td>
		 <td>Пожарная-$Сигнализация<br> Охранная-$Сигнализация2
		 </td>
		 </tr>
		
		 
					 
		 
		 ";
				}
				$i++;}
			while($pom = mysql_fetch_array($edit));	
}
		 $pagetext=$pagetext."</tbody> </table> 
		 <script>
		
		 var st = document.getElementById('Structurnoe_podrazdlenie');	
	     for ( var i=0; i<st.options.length; i++ ){
		         if (st.options[i].value == '$pod') {
					 st.selectedIndex=i; 
					 break;}}";
					 if(isset($ot))
					   if(isset($do))
					 $pagetext=$pagetext."  
		 document.getElementById('ot').value = '$ot';
		  document.getElementById('do').value = '$do';";
		  $pagetext=$pagetext."
					 </script> </form>
		 ";
	
	return $pagetext;
}

?>

</body>
</html>