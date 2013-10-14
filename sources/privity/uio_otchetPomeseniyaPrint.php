<?php
header("Content-Type: application/force-download"); 
header("Content-Type: application/octet-stream"); 
header("Content-Type: application/download"); 
header("Content-Disposition: attachment;filename=Помещения,состоящие на балансе университета.xls"); 
header("Content-Transfer-Encoding: binary "); 
function xlsBOF() { 
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
    return; 
} 


function xlsEOF() { 
    echo pack("ss", 0x0A, 0x00); 
    return; 
} 

function xlsWriteNumber($Row, $Col, $Value) { 
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
    echo pack("d", $Value); 
    return; 
} 

function xlsWriteLabel($Row, $Col, $Value ) { 
    $L = strlen($Value); 
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
    echo $Value; 
    return; 
}
xlsBOF(); 

$i = 0;
xlsWriteLabel(intval($i),0,"Адрес здания(поме-щения)"); 
xlsWriteLabel(intval($i),1,"Вид права");
xlsWriteLabel(intval($i),2,"Наименование здания (поме-щения)");
xlsWriteLabel(intval($i),3,"Корпус №");
xlsWriteLabel(intval($i),4,"Этаж");
xlsWriteLabel(intval($i),5,"Комната №");
xlsWriteLabel(intval($i),6,"Общая площадь, м2");
xlsWriteLabel(intval($i),7,"Категория помещения");
xlsWriteLabel(intval($i),8,"Вид использования");
xlsWriteLabel(intval($i),9,"Обременение помещения");
xlsWriteLabel(intval($i),10,"Режим использования");
xlsWriteLabel(intval($i),11,"Количество учебных (рабочих) мест");
xlsWriteLabel(intval($i),12,"Структурное подразделение");
xlsWriteLabel(intval($i),13,"Техническое состояние помещения");
xlsWriteLabel(intval($i),14,"Наличие перепланировок");
xlsWriteLabel(intval($i),15,"Сигнализация");
$i++;


include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);

 
					 $edit = mysql_query("SELECT Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati, Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya, Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer, Pomesenie.Etag, Pomesenie.Kolvo_uchebnih_rabochih_mest, Pomesenie.Kolvo_mest_komment, Pomesenie.Kategoriya_pomeseniya, Pomesenie.Nomer_komnati, Pomesenie.Registracionni_nomer_pomeseniya, Pomesenie.Nomer_korpusa_FK, Korpus.Adres_zdaniya, Ispolzovnie_pomesheniya.id_podrazdeleniya_FK, Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK, Ispolzovnie_pomesheniya.Vid_ispolzovaniya, Ispolzovnie_pomesheniya.Obremenenie_pomesheniya, Ispolzovnie_pomesheniya.Rejim_ispolzovaniya, Ispolzovnie_pomesheniya.Data_nachala_ispolzovamiya, Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya, Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK, Structurnoe_podrazdelenie.id_podrazdeleniya, Structurnoe_podrazdelenie.Nazvanie_podrazdeleniya, Structurnoe_podrazdelenie.Rukovoditel, Structurnoe_podrazdelenie.telephon, Otvetstvennoe_lico.id_otvetstvennogo_lica, Otvetstvennoe_lico.Familiya, Otvetstvennoe_lico.Imya, Otvetstvennoe_lico.Otchestvo, Otvetstvennoe_lico.id_podrazdeleniya_FK, Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK, Tehnicheskoe_sostoyanie_pomeseniya.Okna, Tehnicheskoe_sostoyanie_pomeseniya.Dveri, Tehnicheskoe_sostoyanie_pomeseniya.Steni, Tehnicheskoe_sostoyanie_pomeseniya.Pol, Tehnicheskoe_sostoyanie_pomeseniya.Potolok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplanirovok, Tehnicheskoe_sostoyanie_pomeseniya.Nalichie_pereplan_komment, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_poj, Tehnicheskoe_sostoyanie_pomeseniya.Sanitarni_pasport_nomer, Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK, Tehnicheskoe_sostoyanie_pomeseniya.Signalizaciya_ohr, Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania
FROM Korpus
INNER JOIN Pomesenie ON ( Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK ) 
INNER JOIN Ispolzovnie_pomesheniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK ) 
INNER JOIN Structurnoe_podrazdelenie ON ( Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya ) 
INNER JOIN Otvetstvennoe_lico ON ( Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK = Otvetstvennoe_lico.id_otvetstvennogo_lica ) 
AND (
Structurnoe_podrazdelenie.id_podrazdeleniya = Otvetstvennoe_lico.id_podrazdeleniya_FK
)
INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON ( Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK ) 
WHERE Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania
IN (

SELECT id_tehSostoyania
FROM `Tehnicheskoe_sostoyanie_pomeseniya` 
GROUP BY `Registracionni_nomer_pomeseniya_FK` 
)
GROUP BY Pomesenie.Nomer_korpusa_FK, Pomesenie.Nomer_komnati",$db);


 
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
					//$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					//$Obremenenie = $pom['Obremenenie_pomesheniya'];
					//$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Structurnoe_podrazdlenie = $pom['Nazvanie_podrazdeleniya'];
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
						$edit = mysql_query("SELECT * 
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
AND Nomer_komnati ='$Nomer_komnati' ) )",$db);
	             					$pom = mysql_fetch_array($edit);
					
					$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					$Obremenenie = $pom['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
xlsWriteLabel(intval($i),0,$adr); 
xlsWriteLabel(intval($i),1,$Vid_prava);
xlsWriteLabel(intval($i),2,$Naimenovanie_zdaniya);
xlsWriteLabel(intval($i),3,$Nomer_korpusa);
xlsWriteLabel(intval($i),4,$Etag);
xlsWriteLabel(intval($i),5,$Nomer_komnati);
xlsWriteLabel(intval($i),6,$Obshaya_ploshad);
xlsWriteLabel(intval($i),7,$Categoriya_pomesh);
xlsWriteLabel(intval($i),8,$Vid_ispolzovanie);
xlsWriteLabel(intval($i),9,$Obremenenie);
xlsWriteLabel(intval($i),10,$Rejim_ispol);
xlsWriteLabel(intval($i),11,$Kolvo_mest);
xlsWriteLabel(intval($i),12,$Structurnoe_podrazdlenie);
xlsWriteLabel(intval($i),13,"Окна-".$Okna." Двери-".$Dveri." Стены-".$Steni." Потолок-".$Potolok." Пол-".$Pol);
xlsWriteLabel(intval($i),14,$Nalichie_pereplanirovok);

xlsWriteLabel(intval($i),15,"Пожарная-".$Сигнализация." Охранная-".$Сигнализация2);
	$i++;}
while($pom = mysql_fetch_array($edit));
//}

xlsEOF(); 
?>