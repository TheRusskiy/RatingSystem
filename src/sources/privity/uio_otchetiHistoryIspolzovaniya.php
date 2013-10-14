<?php
function historyIspolzovaniya($db){
    if (isset($_POST['Nomer_komnatiEdit']))
	    $Nomer_komnatiEdit=$_POST['Nomer_komnatiEdit'];
		else {$Nomer_komnatiEdit=$_GET['Nomer_komnatiEdit'];}
	if (isset($_POST['Nomer_korpusaEdit']))
	   $Nomer_korpusaEdit=$_POST['Nomer_korpusaEdit'];
	else  $Nomer_korpusaEdit=$_GET['Nomer_korpusaEdit'];
	if(isset($Nomer_komnatiEdit)){
			 if(isset($Nomer_korpusaEdit)){
				 
					 $edit = mysql_query("SELECT s.Nazvanie_podrazdeleniya,s.Rukovoditel, s.telephon, i.Vid_ispolzovaniya, i.Obremenenie_pomesheniya, i.Rejim_ispolzovaniya, i.Data_nachala_ispolzovamiya, i.Data_okonchaniya_ispolzovaniya FROM `Ispolzovnie_pomesheniya` i JOIN Structurnoe_podrazdelenie s on s.id_podrazdeleniya =i.id_podrazdeleniya_FK  WHERE `Registracionni_nomer_pomeseniya_FK` = (Select `Registracionni_nomer_pomeseniya` from Pomesenie where Nomer_korpusa_FK  = $Nomer_korpusaEdit and Nomer_komnati = $Nomer_komnatiEdit)",$db);
					
					$pom = mysql_fetch_array($edit);
					
					$today =  $pom['editData'];
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
					if($Data_okonchaniya=='0000-00-00')$Data_okonchaniya='';
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
		     <th style='width:210px'>Структурное&nbsp;подразделение</th>
			 <th style='width:90px'>Руководитель&nbsp;подразделения</th>
			 <th style='width:160px'>Телефон&nbsp;подразделения</th>
			 <th style='width:90px'>Вид&nbsp;использования</th>
			 <th style='width:50px'>Обременение</th>
			 <th style='width:110px'>Режим&nbsp;использования</th>
			 <th style='width:160px'>Дата&nbsp;начала&nbsp;использования</th>
			 <th style='width:160px'>Дата&nbsp;окончания&nbsp;использования</th>
			 
		</tr>
		 </thead><tbody>
    ";
                                    $i=1;
		 do{
                                                                                         
				    $Structurnoe_podrazdlenie = $pom['Nazvanie_podrazdeleniya'];
					$Rukovoditel_podrazdeleniya = $pom['Rukovoditel'];
					$Telefon = $pom['telephon'];
					$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					$Obremenenie = $pom['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Data_nachala = $pom['Data_nachala_ispolzovamiya'];
					$Data_okonchaniya = $pom['Data_okonchaniya_ispolzovaniya'];
					if($Data_okonchaniya=='00.00.0000')$Data_okonchaniya='Используется в данный момент';
									
				$pagetext=$pagetext."<tr>
		 <td>$i
		 </td>
		 <td> $Structurnoe_podrazdlenie
		 </td>
		 <td> $Rukovoditel_podrazdeleniya
		 </td>
		 <td> $Telefon
		 </td>
		 <td> $Vid_ispolzovanie
		 </td>
		 <td> $Obremenenie
		 </td>
		 <td> $Rejim_ispol
		 </td>
		 <td> $Data_nachala
		 </td>
		 <td> $Data_okonchaniya
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
