
<?php
function historyTeh($db){
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
				 
					 $edit = mysql_query("SELECT * FROM `Tehnicheskoe_sostoyanie_pomeseniya` WHERE `Registracionni_nomer_pomeseniya_FK` = (Select `Registracionni_nomer_pomeseniya` from Pomesenie where Nomer_korpusa_FK  = $Nomer_korpusaEdit and Nomer_komnati = $Nomer_komnatiEdit)",$db);
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
					$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					$Obremenenie = $pom['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Kolvo_mest_komment = $pom['Kolvo_mest_komment'];
					$Structurnoe_podrazdlenie = $pom['Nazvanie_podrazdeleniya'];
					$Rukovoditel_podrazdeleniya = $pom['Rukovoditel'];
					$Otvetstvennoe_lico = $pom['Familiya']." ".$pom['Imya']." ".$pom['Otchestvo'];
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

<title></font></title>
 <link rel='stylesheet' type='text/css' href='sources//privity//styles//style.css'>
   <link rel='stylesheet' type='text/css' href='sources//privity//tablesorter//themes//blue//style.css'>
   <script  type='text/javascript' src='sources//privity//jquery-1.5.1.js'></script>
     <script  type='text/javascript' src='sources//privity//tablesorter//jquery-latest.js'></script>
   <script  type='text/javascript' src='sources//privity//tablesorter//jquery.tablesorter.js'></script>
<script type='text/javascript'>
//$(document).ready(function(){
 // $('.tablesorter tr').hover(
  // function () {
//	$(this).addClass('tr_hover');
	
//	},
  // function (){
//	 $(this).removeClass('tr_hover');
 //  }
 //  );
 
  // $('#tb1').tablesorter();
   
//});
$(document).ready(function(){
	 $('#myTable').tablesorter();
	  $('#tb1').tablesorter();
	
	});

</script>
  
</head>
<body>
<table  id ='tb1'  name ='tb1' class='tablesorter' border=0 width='100%' height='10'><thead>
		 <tr>
		     <th style='width:40px'>№</th>
		     <th style='width:210px'>Окна</th>
			 <th style='width:90px'>Двери</th>
			 <th style='width:160px'>Стены</th>
			 <th style='width:90px'>Пол</th>
			 <th style='width:50px'>Потолок</th>
			 <th style='width:110px'>Наличие&nbsp;перепланировок</th>
			 <th style='width:160px'>Наличие&nbsp;перепланировок(коммент)</th>
			 <th style='width:160px'>Сигнализация&nbsp;пожарная</th>
			 <th style='width:150px'>Cигнализация&nbsp;охранная </th>
			 <th style='width:190px'>Номер&nbsp;санитарного&nbsp;паспорта</th>
                                                         <th style='width:190px'>Дата&nbsp;изменения</th>
		</tr>
		 </thead><tbody>
    ";
                                    $i=1;
		 do{
                                                                                            $today=$pom['EditData'];
				                  $Okna = $pom['Okna'];
echo $pom['editData'];
					$Dveri = $pom['Dveri'];
					$Steni = $pom['Steni'];
					$Potolok = $pom['Potolok'];
					$Pol = $pom['Pol'];
					$Nalichie_pereplanirovok = $pom['Nalichie_pereplanirovok'];
					if($Nalichie_pereplanirovok=="0")$Nalichie_pereplanirovok="нет";
					if($Nalichie_pereplanirovok=="1")$Nalichie_pereplanirovok="да";
					$Nalichie_pereplanirovok_kom = $pom['Nalichie_pereplan_komment']; 
					$Nom_Pas = $pom['Sanitarni_pasport_nomer']; 
					$Сигнализация  = $pom['Signalizaciya_poj'];
					if($Сигнализация=="0")$Сигнализация="нет";
					if($Сигнализация=="1")$Сигнализация="да";
					$Сигнализация2  = $pom['Signalizaciya_ohr'];
					if($Сигнализация2=="0")$Сигнализация2="нет";
					if($Сигнализация2=="1")$Сигнализация2="да";
									
				$pagetext=$pagetext."<tr>
		 <td>$i
		 </td>
		 <td> $Okna
		 </td>
		 <td> $Dveri
		 </td>
		 <td> $Steni
		 </td>
		 <td> $Pol
		 </td>
		 <td> $Potolok
		 </td>
		 <td> $Nalichie_pereplanirovok
		 </td>
		 <td> $Nalichie_pereplanirovok_kom
		 </td>
		 <td> $Сигнализация
		 </td>
		 <td> $Сигнализация2
		 </td>
		 <td> $Nom_Pas
		 </td>
		 <td> $today
		 </td>		
		 </tr>
		 
		 ";
				
				$i++;}
			while($pom = mysql_fetch_array($edit));	
 $pagetext=$pagetext." </tbody> </table>  </form>
  
  </body>
</html>
";

return $pagetext;}

?>