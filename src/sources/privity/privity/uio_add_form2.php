<?php 
include "config.php";
 $db = mysql_connect($CONFS['sql_host'] 	,$CONFS['sql_user'] ,$CONFS['sql_pass'] );
    mysql_select_db($CONFS['sql_database'] ,$db);

	$Nomer_komnatiEdit=$_POST['Nomer_komnatiEdit'];
	$Nomer_korpusaEdit=$_POST['Nomer_korpusaEdit'];
	if(isset($Nomer_komnatiEdit)){
			 if(isset($Nomer_korpusaEdit)){
				
					 $edit = mysql_query("SELECT 
	  Uchastnik_inv_komissii.id_uchastnika_inv_komissii,Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK ,
	Uchastnik_inv_komissii.Familiya,  Uchastnik_inv_komissii.Imya,  Uchastnik_inv_komissii.Otchestvo
  FROM
	Korpus
	INNER JOIN Pomesenie ON (Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK)
	INNER JOIN Ispolzovnie_pomesheniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK)
	INNER JOIN Structurnoe_podrazdelenie ON (Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya)
	Left JOIN Otvetstvennoe_lico ON (Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK = Otvetstvennoe_lico.id_otvetstvennogo_lica)
	AND (Structurnoe_podrazdelenie.id_podrazdeleniya = Otvetstvennoe_lico.id_podrazdeleniya_FK)
	INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK)
	INNER JOIN Otmetka_invent_komissii ON (Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK = Otmetka_invent_komissii.Nomer_inv_komissii)
	INNER JOIN Uchastnik_inv_komissii_has_Otmetka_invent_komissii ON (Otmetka_invent_komissii.Nomer_inv_komissii = Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK)
	INNER JOIN Uchastnik_inv_komissii ON (Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK = Uchastnik_inv_komissii.id_uchastnika_inv_komissii)
	WHERE Pomesenie.Nomer_komnati='$Nomer_komnatiEdit' AND Pomesenie.Nomer_korpusa_FK='$Nomer_korpusaEdit'",$db);
				$rows=mysql_num_rows($edit);	
				 do{
				    $fam = $pom["Familiya"];
                    $Otvetstvennoe_lico = $pom["id_otvetstvennogo_lica_FK"];
				   $imya=$pom["Imya"];
				    $otch = $pom["Otchestvo"];
					$uchastnik[]= $pom["id_uchastnika_inv_komissii"];
				 }
				 while($pom = mysql_fetch_array($edit));
				
		
				 }
	}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
<title>Система мониторинга деятельности подразделения</font></title>
    <head>
     <link type="text/css" href="sources//privity//latest.css" rel="Stylesheet" />
 <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
    <script  type="text/javascript" src="sources//privity//jquery-1.5.1.js"></script>
    <script  type="text/javascript" src="sources//privity//ui.datepicker.js"></script>
     
    <script  type="text/javascript" >
<!-- hide
var jq = jQuery.noConflict();
jq(document).ready(function(){
	
	jq(".datepickerTimeField").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        firstDay: 1, 
		changeFirstDay: true,
        navigationAsDateFormat:true,
        duration: 0});// отключаем эффект появления
		
});

var n = new Array();
var otvetst;
<?php if($rows>0){
        echo "otvetst = '$Otvetstvennoe_lico';";
	//foreach($uchastnik as $id=>$value) echo "n[$id] = '$uchastnik[$id]';";
        for($j=1;$j<=$rows;$j++){ 
               echo "n[$j] = '$uchastnik[$j]';";
         
        }
		}

 ?>

//-------------------------------------Отметка выбранных участников для добавления в базу-------------------------------------------
function Uchastnik(){
	
	var objSel = document.getElementById("Uchastnik_kom[]");
    for (var key in objSel.options) {
      objSel.options[key].selected='true';
    }
}
///---------------------------------------------------Проверки выбора сигнализации----------------------------------
function Signalizaciya(){
  document.form1.Сигнализация.checked = false;
  document.form1.Сигнализация2.checked = false;
}

function Signalizaciya2(){
  document.form1.Сигнализация3.checked = false;
}
//--------------------------------------Добавляет адрес корпуса в поле----------------------------------------------------------------
function pressKorpus() {
	/*$(".datepickerTimeField").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        firstDay: 1, changeFirstDay: false,
        navigationAsDateFormat: false,
        duration: 0,// отключаем эффект появления
});*/
	//$(".datepickerTimeField").hide();
//text());// == 'Внести изменения')alert('asd');
	//j("#Obshaya_ploshad").hide();
  www = document.form1.Nomer_korpusa.selectedIndex;
  www=document.getElementById("Nomer_korpusa").value;
  getAdres('/sources/privity/uio_queryAdresKorpusa.php?korpus='+www);
  }
  
  

//--------------------------------------------------Добавление участника в список участников--------------------------------------
function DobavitUchastnika(){
	var objSel = document.getElementById("Uchastnik_kom[]");
	var uchastnik = document.getElementById("ViborUchastnik_kom");	
	var flag = 'false';
	var i=0;
	for (var key in objSel.options) {
	//for (var i=0;i<objSel.length;i++){// in objSel.options)	
	    var val = objSel.options[key].value;
	    if(val == uchastnik.options[uchastnik.selectedIndex].value){ flag ='true';}
	}
	if(flag=='false'){
	  objSel.options[objSel.length] = new Option(uchastnik.options[uchastnik.selectedIndex].text, uchastnik.options[uchastnik.selectedIndex].value);
	}
	//controlEdits(); 
	
}

//-------------------------------Получение адреса по номеру корпуса---------------------------------------------------------------
function getAdres(sURL){
	
	document.form1.adr.value = loadHTML3(sURL);

	
}
///--------------------------------Запрос на сервер и возвращает строку-----------------------------------------------------------
function loadHTML3(sURL)
{
  var request=null;
  if(!request) try {
    request=new ActiveXObject('Msxml2.XMLHTTP');
  } catch (e){}
  if(!request) try {
    request=new ActiveXObject('Microsoft.XMLHTTP');
  } catch (e){}
  if(!request) try {
    request=new XMLHttpRequest();
  } catch (e){}
  if(!request)
     return "";
	
  request.open('GET', sURL, false);
  request.send(null);
return request.responseText;
}
//-------------------Запрос на сервер о подразделение и возвращает XML -------------------------------------------------------------
function loadXMLDoc4( method, url ){
  if ( window.XMLHttpRequest ) {
    req = new XMLHttpRequest();
   	req.onreadystatechange = processReqChange4;
    req.open(method, url, true);
    req.send(null);
	} else if ( window.ActiveXObject ) {
    req = new ActiveXObject( "Microsoft.XMLHTTP" );
    if ( req ) {
	  //alert(reg.status);	
      req.open( method, url, true );
	  req.onreadystatechange = processReqChange4;
      req.send(null);
	}
  }
}

function processReqChange4() {
  if ( req.readyState == 4 ) {
    if ( req.status == 200 )
	   getLica4(req.responseXML.documentElement);
    else
      alert("There was a problem retrieving the XML data:\n" + req.statusText);
  }
}

function onChangeMy() {
	alert("asd");
	//document.form1.Telefon.value = loadHTML("/sources/privity/uio_queryTelefonPod.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value); 
	//document.form1.Rukovoditel_podrazdeleniya.value = loadHTML("/sources/privity/uio_queryRukovPod.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value);
	//var url = "/sources/privity/uio_queryOtvLica.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value;
	//loadXMLDoc( "get", url );
}
var lico;
function onChangeMy3()
{var d = new Date();

	  document.form1.Telefon.value = loadHTML3("/sources/privity/uio_queryTelefonPod.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value); 
	document.form1.Rukovoditel_podrazdeleniya.value = loadHTML3("/sources/privity/uio_queryRukovPod.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value);
	var url = "/sources/privity/uio_queryOtvLica.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value;
	loadXMLDoc4( "get", url );
	//alert()
	if(jq("#Podrazdelenie").val()!=""){
	
	if(jq("#Podrazdelenie").val()==jq("#Structurnoe_podrazdlenie").val())
	{
		document.getElementById("Data_nachala").value =document.getElementById("dataNachalaEdit").value;
		document.getElementById("Data_okonchaniya").value = "0000-00-00";
	   jq("#Data_okonchaniya").show(500);
		jq("#div_label_data_end").show(500);
	}
	else
	{
		jq("#Data_okonchaniya").hide(500);
		jq("#div_label_data_end").hide(500);
		var  data = d.getFullYear()+"-"+d.getMonth()+"-"+d.getDate();
		document.getElementById("Data_nachala").value = data;
		document.getElementById("Data_okonchaniya").value = data;
	   jq("#Data_okonchaniya").val()= data;	
	}
	}
	
}

function getLica4( xml ) {
   var Lica = xml.getElementsByTagName( 'otv_lico' );
   var _select = document.getElementById("Otvetstvennoe_lico");
  _select.innerHTML = ""; 
  var option = document.createElement( "option" );
     var optionText = document.createTextNode( "не выбрано" );
     option.appendChild( optionText );
     _select.appendChild( option );
   for ( i=0; i<Lica.length; i++ ) { 
     var option = document.createElement("option" );
     var optionText = document.createTextNode(Lica[i].firstChild.data );
     option.appendChild( optionText );
     option.setAttribute("value",Lica[i].getAttribute("value") );
     _select.appendChild(option);
   }
   var o = document.getElementById('Otvetstvennoe_lico');
   for ( var i=0; i<o.options.length; i++ ){
         if (o.options[i].value == otvetst) {o.selectedIndex=i;break;}}
} 
//-------------------------------------------Контроль ввода текста-----------------------------------------------------------------
function control(edit){
	edit.style.color='black';
	var flag=false;
	for(var i=0;i<edit.value.length;i++){
		switch (edit.value[i])
		{
			case '/':{flag=true;edit.style.color='red';}
		    case '':{flag=true;edit.style.color='red';}
			//case ".":{flag=true;edit.style.color='red';}
			//case ",":{flag=true;edit.style.color='red';}
			//case ''':{flag=true;edit.style.color='red';}
			//case '"':{flag=true;edit.style.color='red';}
			case ']':{flag=true;edit.style.color='red';}
			case '[':{flag=true;edit.style.color='red';}
			case '{':{flag=true;edit.style.color='red';}
			case '}':{flag=true;edit.style.color='red';}
			case '|':{flag=true;edit.style.color='red';}
			case '@':{flag=true;edit.style.color='red';}
			case '!':{flag=true;edit.style.color='red';}
			case '#':{flag=true;edit.style.color='red';}
			case '$':{flag=true;edit.style.color='red';}
			case '%':{flag=true;edit.style.color='red';}
			case '^':{flag=true;edit.style.color='red';}
			case '&':{flag=true;edit.style.color='red';}
			case '*':{flag=true;edit.style.color='red';}
			case '(':{flag=true;edit.style.color='red';}
			case ')':{flag=true;edit.style.color='red';}
			case '№':{flag=true;edit.style.color='red';}
			case ';':{flag=true;edit.style.color='red';}
			case ':':{flag=true;edit.style.color='red';}
			case '?':{flag=true;edit.style.color='red';}
			case '*':{flag=true;edit.style.color='red';}
		    
		}
		 
	}
	form1.add.disabled=true;
	if(flag){
		var name = 'div_'+edit.name;
		document.getElementById(name).innerHTML=" <div  style='font-size:12'><i>Можно вводить только числа и буквы</i></div>";
		form1.add.disabled=true;}
	else {
		form1.add.disabled=false;
		var name = 'div_'+edit.name;
		document.getElementById(name).innerHTML='';
		
//	controlEdits();
      }
}
function controlEdits(){
  
  var flag=false;
  form1.add.disabled=false;
	
return flag;
}



//---------------------------------------Проверка вбора списков-----------------------------------------
function dataSelect() {
	var flag=true;
	var n = jq("#Nomer_korpusa option").index(jq("#Nomer_korpusa option:selected"));
	if(n!=0) jq("#div_Nomer_korpusa").html("");
	else  
	{
		jq("#div_Nomer_korpusa").html("<div style='font-size:12'><i>Выберите корпус</i></div>");
		flag=false;
	}
	
	n = jq("#Etag2 option").index(jq("#Etag2 option:selected"));
	if(n!=0)  jq("#div_Etag2").html("");
	else  
	{
		 jq("#div_Etag2").html(" <div  style='font-size:12'><i>Выберите этаж</i></div>");
		flag=false;
    };
	
    n = jq("#Vid_prava option").index(jq("#Vid_prava option:selected"));
	if(n!=0)  jq("#div_Vid_prava").html("");
	else  
	{
		 jq("#div_Vid_prava").html(" <div  style='font-size:12'><i>Выберите вид права</i></div>");
		flag=false;
    }
	
	n = jq("#Categoriya_pomesh option").index(jq("#Categoriya_pomesh option:selected"));
	if(n!=0)  jq("#div_Categoriya_pomesh").html("");
	else  
	{
		 jq("#div_Categoriya_pomesh").html(" <div  style='font-size:12'><i>Выберите категорию помещения</i></div>");
		flag=false;
    }
	
	n = jq("#Vid_ispolzovanie option").index(jq("#Vid_ispolzovanie option:selected"));
	if(n!=0)  jq("#div_Vid_ispolzovanie").html("");
	else  
	{
		 jq("#div_Vid_ispolzovanie").html(" <div  style='font-size:12'><i>Выберите вид использования</i></div>");
		flag=false;
    }

    n = jq("#Obremenenie option").index(jq("#Obremenenie option:selected"));
	if(n!=0)  jq("#div_Obremenenie").html("");
	else  
	{
		 jq("#div_Obremenenie").html(" <div  style='font-size:12'><i>Выберите обременение помещения</i></div>");
		flag=false;
    }
	
	n = jq("#Rejim_ispol option").index(jq("#Rejim_ispol option:selected"));
	if(n!=0)  jq("#div_Rejim_ispol").html("");
	else  
	{
		 jq("#div_Rejim_ispol").html(" <div  style='font-size:12'><i>Выберите режим использования</i></div>");
		flag=false;
    }
	
	n = jq("#Structurnoe_podrazdlenie option").index(jq("#Structurnoe_podrazdlenie option:selected"));
	if(n!=0)  jq("#div_Structurnoe_podrazdlenie").html("");
	else  
	{
		 jq("#div_Structurnoe_podrazdlenie").html(" <div  style='font-size:12'><i>Выберите подразделение</i></div>");
		flag=false;
    }
	
	/*n = jq("#Otvetstvennoe_lico option").index(jq("#Otvetstvennoe_lico option:selected"));
	if(n!=0)  jq("#div_Otvetstvennoe_lico").html("");
	else  
	{
		 jq("#div_Otvetstvennoe_lico").html(" <div  style='font-size:12'><i>Выберите ответственное лицо</i></div>");
		flag=false;
    }*/
	
	n = jq("#Okna option").index(jq("#Okna option:selected"));
	if(n!=0)  jq("#div_Okna").html("");
	else  
	{
		 jq("#div_Okna").html(" <div  style='font-size:12'><i>Выберите состояние окон</i></div>");
		flag=false;
    }
	
	n = jq("#Dveri option").index(jq("#Dveri option:selected"));
	if(n!=0)  jq("#div_Dveri").html("");
	else  
	{
		 jq("#div_Dveri").html(" <div  style='font-size:12'><i>Выберите состояние дверей</i></div>");
		flag=false;
    }
	
	n = jq("#Steni option").index(jq("#Steni option:selected"));
	if(n!=0)  jq("#div_Steni").html("");
	else  
	{
		 jq("#div_Steni").html(" <div  style='font-size:12'><i>Выберите состояние стен</i></div>");
		flag=false;
    }
	
	n = jq("#Potolok option").index(jq("#Potolok option:selected"));
	if(n!=0)  jq("#div_Potolok").html("");
	else  
	{
		 jq("#div_Potolok").html(" <div  style='font-size:12'><i>Выберите состояние потолка</i></div>");
		flag=false;
    }
	
	n = jq("#Pol option").index(jq("#Pol option:selected"));
	if(n!=0)  jq("#div_Pol").html("");
	else  
	{
		 jq("#div_Pol").html(" <div  style='font-size:12'><i>Выберите состояние пола</i></div>");
		flag=false;
    }
	
	n = jq("#Nalichie_pereplanirovok option").index(jq("#Nalichie_pereplanirovok option:selected"));
	if(n!=0)  jq("#div_Nalichie_pereplanirovok").html("");
	else  
	{
		 jq("#div_Nalichie_pereplanirovok").html(" <div  style='font-size:12'><i>Выберите наличие перепланировок</i></div>");
		flag=false;
    }
	
	n = document.getElementById("Uchastnik_kom[]").length;
	if(n == 0) {
		document.getElementById("div_Uchastnik_kom[]").innerHTML = " <div  style='font-size:12'><i>Выберите участника инвентаризации</i></div>";
		flag=false;
	}
	else
	{
	  document.getElementById("div_Uchastnik_kom[]").innerHTML = "";
	}
	
	n = jq("#Nomer_komnati").val().length;
	if(n!=0)  jq("#div_Nomer_komnati").html("");
	else  
	{
		 jq("#div_Nomer_komnati").html(" <div  style='font-size:12'><i>Введите номер комнаты</i></div>");
		flag=false;
    }
	
	n = jq("#Sootvetstvie").val().length;
	if(n!=0)  jq("#div_Sootvetstvie").html("");
	else  
	{
		 jq("#div_Sootvetstvie").html(" <div  style='font-size:12'><i>Введите соответсвие</i></div>");
		flag=false;
    }
	n = jq("#Naimenovanie_zdaniya").val().length;
	if(n!=0)  jq("#div_Naimenovanie_zdaniya").html("");
	else  
	{
		 jq("#div_Naimenovanie_zdaniya").html(" <div  style='font-size:12'><i>Введите наименование здания</i></div>");
		flag=false;
    }
	n = jq("#Nomer_tehpasporta").val().length;
	if(n!=0)  jq("#div_Nomer_tehpasporta").html("");
	else  
	{
		 jq("#div_Nomer_tehpasporta").html(" <div  style='font-size:12'><i>Введите номер технического паспорта</i></div>");
		flag=false;
    }
	n = jq("#Obshaya_ploshad").val().length;
	if(n!=0)  jq("#div_Obshaya_ploshad").html("");
	else  
	{
		 jq("#div_Obshaya_ploshad").html(" <div  style='font-size:12'><i>Введите общую площадь</i></div>");
		flag=false;
    }
	n = jq("#Naznachenie_pomesh").val().length;
	if(n!=0)  jq("#div_Naznachenie_pomesh").html("");
	else  
	{
		 jq("#div_Naznachenie_pomesh").html(" <div  style='font-size:12'><i>Введите назначение помещения</i></div>");
		flag=false;
    }
	n = jq("#Data_nachala").val().length;
	if(n!=0)  jq("#div_Data_nachala").html("");
	else  
	{
		 jq("#div_Data_nachala").html(" <div  style='font-size:12'><i>Введите дату начала использования</i></div>");
		flag=false;
    }
	
	n = jq("#Kol-vo_mest").val().length;
	if(n!=0)  jq("#div_Kol-vo_mest").html("");
	else  
	{
		 jq("#div_Kol-vo_mest").html(" <div  style='font-size:12'><i>Введите количество мест</i></div>");
		flag=false;
    }
	/*n = jq("#San_pasport").val().length;
	if(n!=0)  jq("#div_San_pasport").html("");
	else  
	{
		 jq("#div_San_pasport").html(" <div  style='font-size:12'><i>Введите номер санитарного паспорта</i></div>");
		flag=false;
    }*/
	
	n = jq("#Data").val().length;
	if(n!=0)  jq("#div_Data").html("");
	else  
	{
		 jq("#div_Data").html(" <div  style='font-size:12'><i>Введите дату инвентаризации</i></div>");
		flag=false;
    }
	
	
return flag;	
 }
	
	
	
//-----------------Контоль ввода только чисел----------------------------------------------------
function controlNumbers(edit){
	edit.style.color='black';
	var flag=false;
	for(var i=0;i<edit.value.length;i++){
	if((edit.value[i]=='1')||(edit.value[i]=='2')||(edit.value[i]=='3')||(edit.value[i]=='4')||(edit.value[i]=='5')||(edit.value[i]=='6')||(edit.value[i]=='7')||(edit.value[i]=='8')||(edit.value[i]=='9')||(edit.value[i]=='0')) flag=true;
	 else {flag=false;break;}
	}
	
	form1.add.disabled=true;
	if(flag)
	{
		var name = 'div_'+edit.name;
		document.getElementById(name).innerHTML='';
		if(controlEdits()==true){
			form1.add.disabled=false;
		}
	}
	else {
		form1.add.disabled=true;
		edit.style.color='red';
		var name = 'div_'+edit.name;
		document.getElementById(name).innerHTML=" <div  style='font-size:12'><i>Можно вводить только числа</i></div>";
	//	document.getElementById(name).innerHTML='Можно вводить только числа';
		
	}
	//controlEdits();
}
function Delete(){
	if(document.getElementById("Uchastnik_kom[]").selectedIndex== -1) alert('Выберите участника');
	document.getElementById("Uchastnik_kom[]").remove(document.getElementById("Uchastnik_kom[]").selectedIndex);
	//document.getElementById("Uchastnik_kom[]").style.visibility="visible";
	$("Uchastnik_kom[]").hide();
	controlEdits(); 
//="hidden";
}
function isEmpty(str) {
   for (var i = 0; i < str.length; i++)
      if (" " != str.charAt(i))
          return false;
      return true;
}
function checkform(f) {
	return dataSelect();
 // var errMSG = ""; 
//  // цикл ниже перебирает все элементы в объекте f, 
//  // переданном в качестве параметра
//  // функции, в данном случае - наша форма.            
//  for (var i = 0; i<f.elements.length; i++) 
//    // если текущий элемент имеет атрибут required
//    // т.е. обязательный для заполнения
//    if (null!=f.elements[i].getAttribute("required")) 
//       // проверяем, заполнен ли он в форме
//        if (isEmpty(f.elements[i].value)) // пустой
//            errMSG += "  " + f.elements[i].name + "\n"; // формируем сообщение
//                                                       // об ошибке, перечисляя 
//                                                       // незаполненные поля
//        // если сообщение об ошибке не пусто,
//        // выводим его, и возвращаем false   
//		//if(document.getElementById("Uchastnik_kom[]").length<1) errMSG="Добавте участника";
//        if ("" != errMSG) {
//            alert("Не заполнены обязательные поля\n");// + errMSG);
//            return false;
//        }
		
}
function query(){
  var flag;
  if(confirm("Вы уверены,что хотите удалить?")) flag = true;
  else flag=false;
  return flag;
}
// -->
</script>
</head>
<body>

<?php

function add($db){
	
  //  $result2 = mysql_query('SELECT  * FROM `Korpus` LIMIT 1 ',$db);
  //  $m = mysql_fetch_array($result2); 
	//$base[]=$m['Adres_zdaniya']; 
	$result = mysql_query('SELECT  Rukovoditel,telephon FROM `Structurnoe_podrazdelenie` LIMIT 1',$db);
    $m = mysql_fetch_array($result);
    $podrazdeleniya[] = $m['Rukovoditel'];
	$telephon[] = $m['telephon'];
	$komnata = $_GET['komnata'];
	$korpus=$_GET['korpus'];
	$Nomer_komnatiEdit=$_POST['Nomer_komnatiEdit'];
	$Nomer_korpusaEdit=$_POST['Nomer_korpusaEdit'];
	if(isset($Nomer_komnatiEdit)){
			 if(isset($Nomer_korpusaEdit)){
				 
					 $edit = mysql_query("SELECT Pomesenie.Vid_prava, Pomesenie.V_sootvetstvii_s, Pomesenie.Naznachenie_pomeseniya,Pomesenie.Naimenovanie_zdaniya, Pomesenie.Obsaya_plosad, Pomesenie.Po_tehpasportu_nomer,
	Pomesenie.Etag,  Pomesenie.Kolvo_uchebnih_rabochih_mest,  Pomesenie.Kolvo_mest_komment,  Pomesenie.Kategoriya_pomeseniya,
	Pomesenie.Nomer_komnati,  Pomesenie.Registracionni_nomer_pomeseniya,  Pomesenie.Nomer_korpusa_FK,  Korpus.Adres_zdaniya,
	Ispolzovnie_pomesheniya.id_podrazdeleniya_FK,Ispolzovnie_pomesheniya.id_Arendatora,  Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK,
	Ispolzovnie_pomesheniya.Vid_ispolzovaniya,  Ispolzovnie_pomesheniya.Obremenenie_pomesheniya,  Ispolzovnie_pomesheniya.Rejim_ispolzovaniya,
	Ispolzovnie_pomesheniya.Data_nachala_ispolzovamiya,  Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya,  Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK,  Structurnoe_podrazdelenie.id_podrazdeleniya,  Structurnoe_podrazdelenie.Nazvanie_podrazdeleniya,  Structurnoe_podrazdelenie.Rukovoditel,  Structurnoe_podrazdelenie.telephon,
	Otvetstvennoe_lico.id_otvetstvennogo_lica,  Otvetstvennoe_lico.Familiya,  Otvetstvennoe_lico.Imya,  Otvetstvennoe_lico.Otchestvo,
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
	inner JOIN Pomesenie ON (Korpus.Nomer_korpusa = Pomesenie.Nomer_korpusa_FK)
	inner JOIN Ispolzovnie_pomesheniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Ispolzovnie_pomesheniya.Registracionni_nomer_pomeseniya_FK)
	inner JOIN Structurnoe_podrazdelenie ON (Ispolzovnie_pomesheniya.id_podrazdeleniya_FK = Structurnoe_podrazdelenie.id_podrazdeleniya)
	Left JOIN Otvetstvennoe_lico ON (Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK = Otvetstvennoe_lico.id_otvetstvennogo_lica)
	AND (Structurnoe_podrazdelenie.id_podrazdeleniya = Otvetstvennoe_lico.id_podrazdeleniya_FK)
	INNER JOIN Tehnicheskoe_sostoyanie_pomeseniya ON (Pomesenie.Registracionni_nomer_pomeseniya = Tehnicheskoe_sostoyanie_pomeseniya.Registracionni_nomer_pomeseniya_FK)
	INNER JOIN Otmetka_invent_komissii ON (Tehnicheskoe_sostoyanie_pomeseniya.Nomer_inv_komissii_FK = Otmetka_invent_komissii.Nomer_inv_komissii)
	INNER JOIN Uchastnik_inv_komissii_has_Otmetka_invent_komissii ON (Otmetka_invent_komissii.Nomer_inv_komissii = Uchastnik_inv_komissii_has_Otmetka_invent_komissii.Nomer_inv_komissii_FK)
	INNER JOIN Uchastnik_inv_komissii ON (Uchastnik_inv_komissii_has_Otmetka_invent_komissii.id_uchastnika_inv_komissii_FK = Uchastnik_inv_komissii.id_uchastnika_inv_komissii)
	WHERE Pomesenie.Nomer_komnati='$Nomer_komnatiEdit' AND Pomesenie.Nomer_korpusa_FK='$Nomer_korpusaEdit' AND Ispolzovnie_pomesheniya.Data_okonchaniya_ispolzovaniya='0000-00-00' order by Tehnicheskoe_sostoyanie_pomeseniya.id_tehSostoyania desc limit 1",$db);
	             $rows=mysql_num_rows($edit);
	     		 if($rows > 0)
				 { 
					$pom = mysql_fetch_array($edit);
					$Vid_prava = $pom['Vid_prava'];
					$Sootvetstvie = $pom['V_sootvetstvii_s'];
					$Naimenovanie_zdaniya = $pom['Naimenovanie_zdaniya'];
					$Nomer_korpusa = $Nomer_korpusaEdit;
					$Etag = $pom['Etag'];
					$Nomer_komnati = $Nomer_komnatiEdit;
					$Nomer_tehpasporta = $pom['Po_tehpasportu_nomer'];
					$Obshaya_ploshad = $pom['Obsaya_plosad'];
					$Categoriya_pomesh = $pom['Kategoriya_pomeseniya'];
					$Naznachenie_pomesh = $pom['Naznachenie_pomeseniya'];
					
					$Structurnoe_podrazdlenie = $pom['id_podrazdeleniya'];
					$Arenda= $pom['id_Arendatora'];
					$Rukovoditel_podrazdeleniya = $pom['Rukovoditel'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Kolvo_mest_komment = $pom['Kolvo_mest_komment'];
					$Telefon = $pom['telephon'];
					$Okna = $pom['Okna'];
					$Dveri = $pom['Dveri'];
					$Steni = $pom['Steni'];
					$Potolok = $pom['Potolok'];
					$Pol = $pom['Pol'];
					$Nalichie_pereplanirovok = $pom['Nalichie_pereplanirovok'];
					$Nalichie_pereplanirovok_komment = $pom['Nalichie_pereplan_komment'];
					$Сигнализация  = $pom['Signalizaciya_poj'];
					$Сигнализация2  = $pom['Signalizaciya_ohr'];
					$Zamechaniya = $pom['Zamechaniya_invent_komissii'];
					$Predlojeniya = $pom['Predlojeniya'];
					$Data = $pom['Data_invent'];
					$Data_nachala = $pom['Data_nachala_ispolzovamiya'];
					$Data_okonchaniya = $pom['Data_okonchaniya_ispolzovaniya'];
					$San_pasport = $pom['Sanitarni_pasport_nomer'];
					$Uchastnik = $pom["Uchastnik_kom"];
				    do{
				      $fam = $pom["Familiya"];
				      $imya=$pom["Imya"];
				      $otch = $pom["Otchestvo"];
					  $uchastnik[]=$fam." ".$imya." ".$otch;

				    }
				    while($pom = mysql_fetch_array($edit));
					
					$edit = mysql_query("SELECT * 
FROM Ispolzovnie_pomesheniya
Left JOIN Otvetstvennoe_lico ON Otvetstvennoe_lico.id_otvetstvennogo_lica = Ispolzovnie_pomesheniya.id_otvetstvennogo_lica_FK
WHERE Registracionni_nomer_pomeseniya_FK = ( 
SELECT Registracionni_nomer_pomeseniya
FROM Pomesenie
WHERE Nomer_komnati='$Nomer_komnatiEdit' AND Nomer_korpusa_FK='$Nomer_korpusaEdit' ) 
AND id_ispolzovaniya = ( 
SELECT max( id_ispolzovaniya ) 
FROM Ispolzovnie_pomesheniya
WHERE Registracionni_nomer_pomeseniya_FK = ( 
SELECT Registracionni_nomer_pomeseniya
FROM Pomesenie
WHERE Nomer_korpusa_FK ='$Nomer_korpusaEdit'
AND Nomer_komnati ='$Nomer_komnatiEdit' ) and id_podrazdeleniya_FK = '$Structurnoe_podrazdlenie' ) and Data_okonchaniya_ispolzovaniya='0000-00-00'",$db);
	             					$pom = mysql_fetch_array($edit);
					
					$Vid_ispolzovanie = $pom['Vid_ispolzovaniya'];
					$Obremenenie = $pom['Obremenenie_pomesheniya'];
					$Rejim_ispol = $pom['Rejim_ispolzovaniya'];
					$Arenda = $pom['id_Arendatora'];
					
					$Otvetstvennoe_lico = $pom['id_otvetstvennogo_lica'];
				 }
				 else
				 {
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
					$Categoriya_pomesh = $pom['Kategoriya_pomeseniya'];
					$Naznachenie_pomesh = $pom['Naznachenie_pomeseniya'];
					$Kolvo_mest = $pom['Kolvo_uchebnih_rabochih_mest'];
					$Kolvo_mest_komment = $pom['Kolvo_mest_komment'];
					$Data_nachala=date("Y-m-d");
					$Okna = $pom['Okna'];
					$Dveri = $pom['Dveri'];
					$Steni = $pom['Steni'];
					$Potolok = $pom['Potolok'];
					$Pol = $pom['Pol'];
					$Nalichie_pereplanirovok = $pom['Nalichie_pereplanirovok'];
					$Nalichie_pereplanirovok_komment = $pom['Nalichie_pereplan_komment'];
					$Сигнализация  = $pom['Signalizaciya_poj'];
					$Сигнализация2  = $pom['Signalizaciya_ohr'];
					$Zamechaniya = $pom['Zamechaniya_invent_komissii'];
					$Predlojeniya = $pom['Predlojeniya'];
					$Data = $pom['Data_invent'];
					
					$San_pasport = $pom['Sanitarni_pasport_nomer'];
					$Uchastnik = $pom["Uchastnik_kom"];
				    do{
				      $fam = $pom["Familiya"];
				      $imya=$pom["Imya"];
				      $otch = $pom["Otchestvo"];
					  $uchastnik[]=$fam." ".$imya." ".$otch;

				    }
				    while($pom = mysql_fetch_array($edit));
				 }
				    $buttonName="Внести изменения";}
	}
else $buttonName=$_GET['buttonName'];
$pagetext = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>Система мониторинга деятельности подразделения</font></title>
    <link type='text/css' href='sources\privity\latest.css' rel='Stylesheet' />
  
  <style type='text/css'>
    @import url('styles/style.css');
  </style>

</head><body>

<form  name = 'form1' method=POST  action='".$_SERVER['PHP_SELF']."?nav=addToBase' onSubmit = 'return checkform(this)'>
<table border=0 width=100% height=100%>
  <tr>
    <td width='252'>&nbsp;</td>
    <td width='778'>&nbsp;</td>
    <td width='5'>&nbsp;</td>
    <td width='106'>&nbsp;</td>
  </tr>
  <tr>
    <td height='48' colspan='2'><strong>Месторасположение помещения</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>
      <label>Корпус №:   <label style='color: red'>*</label>    </label>
    </td>
    <td><select name='Nomer_korpusa' id='Nomer_korpusa'   ONCHANGE='pressKorpus()'  >";
	
	 $result2 = mysql_query('SELECT * FROM `Korpus` order by nomer_korpusa+0',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option >не выбрано</option>";
	 do{
       $pagetext =$pagetext. '<option value='.$m['Nomer_korpusa'].'>'.$m['Nomer_korpusa'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."  </select><div id='div_Nomer_korpusa' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Адрес здания:      </label>
    </td>
    <td>
		<input class='ad' type='text'  name='adr'   readonly id='adr' />
		
		 
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Этаж:  <label style='color: red'>*</label> </label>
    </td>
    <td><select name='Etag2'   id='Etag2' >";
	       $result2 = mysql_query('SELECT number FROM `etag` order by number',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option>не выбрано</option>";
	 do{
       $pagetext =$pagetext. '<option value='.$m['number'].'>'.$m['number'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."
    </select><div id='div_Etag2' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Комната №:  <label style='color: red'>*</label>  </label>
    </td>
    <td><input type='text'  name='Nomer_komnati' id='Nomer_komnati'  onChange='control(this)'  title='Вводить можно только числа и буквы'/> <div id='div_Nomer_komnati' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label name='adr2'>Вид права:  <label style='color: red'>*</label></label>&nbsp;
      
    </td>
    <td><select name='Vid_prava' id='Vid_prava' >";
	       $result2 = mysql_query('SELECT vid FROM `vidprava` order by vid',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option><i>не выбрано</i></option>";
	 do{
       $pagetext =$pagetext. '<option value='.$m['vid'].'>'.$m['vid'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."
    </select><div id='div_Vid_prava' class='error' ></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>В соответствии с:  <label style='color: red'>*</label>     </label>
    </td>
    <td><input type='text' name='Sootvetstvie' id='Sootvetstvie'   />
	<div id='div_Sootvetstvie' style='color:red'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Наименование здания (помещения):   <label style='color: red'>*</label>    </label>
    </td>
    <td><input type='text' name='Naimenovanie_zdaniya' id='Naimenovanie_zdaniya'   onkeyup='controlEdits()' />
	<div id='div_Naimenovanie_zdaniya' style='color:red'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  
  <tr>
    <td>
      <label>По техпаспорту №:   <label style='color: red'>*</label>    </label>
    </td>
    <td><input type='text' name='Nomer_tehpasporta' id='Nomer_tehpasporta'   onChange='controlNumbers(this)' title='Вводить можно только числа' />  <div id='div_Nomer_tehpasporta' style='color:red'></div> </td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='45'>
      <label>Общая площадь,м2:   <label style='color: red'>*</label>    </label>
    </td>
    <td><input type='text' name='Obshaya_ploshad' id='Obshaya_ploshad'   onChange='controlNumbers(this)' title='Вводить можно только числа'/><div id='div_Obshaya_ploshad' style='color:red'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td height='60' colspan='2'><strong>Использование помещения</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Категория помещения:    <label style='color: red'>*</label>   </label>
    </td>
    <td><select name='Categoriya_pomesh' id='Categoriya_pomesh'>";
	       $result2 = mysql_query('SELECT kat FROM `kategoriyapomesheniya` order by kat',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option><i>не выбрано</i></option>";
	 do{
       $pagetext =$pagetext. '<option value='.$m['kat'].'>'.$m['kat'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."
    </select><div id='div_Categoriya_pomesh' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Назначение помещения:  <label style='color: red'>*</label>     </label>
    </td>
    <td><input type='text' name='Naznachenie_pomesh' id='Naznachenie_pomesh'/>
	<div id='div_Naznachenie_pomesh' class='error'></div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Вид использования:   <label style='color: red'>*</label>    </label>
    </td>
    <td><select name='Vid_ispolzovanie' id='Vid_ispolzovanie'>";
	       $result2 = mysql_query('SELECT vid FROM `vidispolzovaniya` order by vid',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option><i>не выбрано</i></option>";
	 do{
       $pagetext =$pagetext. "<option value='$m[vid]'>".$m['vid'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."
    </select><div id='div_Vid_ispolzovanie' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Обременение помещения:    <label style='color: red'>*</label>   </label>
    </td>
    <td style='width:300px'><select name='Obremenenie' id='Obremenenie'>";
	       $result2 = mysql_query('SELECT obrem FROM `obremenenie` order by obrem',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option><i>не выбрано</i></option>";
	 do{
       $pagetext =$pagetext. '<option value='.$m['obrem'].'>'.$m['obrem'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."
    </select>
	<div id='div_Obremenenie' class='error'></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<label>Арендатор:</label>
	<select name='Arenda' id='Arenda'>";
	       $result2 = mysql_query('SELECT * FROM `Arendatory` order by Nazvanie',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option><i>не выбрано</i></option>";
	 do{
       $pagetext =$pagetext. '<option value='.$m['id_arendatora'].'>'.$m['Nazvanie'].'</option>'; //????????? ????? ???????
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."
    </select>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Режим использования:    <label style='color: red'>*</label>   </label>
    </td>
    <td><select name='Rejim_ispol' id='Rejim_ispol'>";
	 $result2 = mysql_query('SELECT * FROM `Rejim_ispol` order by rejim',$db);
     $m = mysql_fetch_array($result2);
	  $pagetext =$pagetext.="<option><i>не выбрано</i></option>";
	 	  
	 do{
       $pagetext =$pagetext. "<option value='$m[rejim]'>".$m['rejim'].'</option>'; //????????? ????? ???????
	   
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext." 
      
    </select>
	<div id='div_Rejim_ispol' class='error'></div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>Дата начала использования: <label  style='color: red'>*</label></td>
    <td><input value='".date("Y-m-d")."' class='datepickerTimeField' name='Data_nachala' id='Data_nachala'   />
	<div id='div_Data_nachala' class='error'></div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><div id='div_label_data_end'> Дата окончания использования:</div></td>
    <td><input  class='datepickerTimeField' name='Data_okonchaniya' id='Data_okonchaniya'  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Количество учебных (рабо-чих) мест:    <label style='color: red'>*</label>   </label>
    </td>
    <td><input type='text' name='Kol-vo_mest'  id='Kol-vo_mest'  onChange='controlNumbers(this)'  title='Вводить можно только числа'/><div id='div_Kol-vo_mest' style='color:red'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Количество учебных (рабо-чих) мест - комментарии:      </label>
    </td>
    <td><textarea name='Kol-vo_mest_komment'  id='Kol-vo_mest_komment'  rows='7' cols='60'  ></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='57' colspan='2'><strong>Структурное подразделение, эксплуатирующее помещение</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Структурное подразделение:   <label style='color: red'>*</label>    </label>
    </td>
    <td><select class='input' ONCHANGE='onChangeMy3()' type=text style='width: 500px;' name='Structurnoe_podrazdlenie' width=10% id='Structurnoe_podrazdlenie' action = 'uio_addToBase.php' metod='post'>
	<option  value='не выбранно'>не выбрано</option>";
	
          $result2 = mysql_query('SELECT * FROM `Structurnoe_podrazdelenie` ',$db);
          $m = mysql_fetch_array($result2);
          do{
             $pagetext = $pagetext . '<option  value='.$m['id_podrazdeleniya'].'>'.$m['Nazvanie_podrazdeleniya'].'</option>'; 
          }
         while($m = mysql_fetch_array($result2)); 

     $pagetext =$pagetext. "  </select>
	 <div id='div_Structurnoe_podrazdlenie' class='error'></div>
	 </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Руководитель подразделения:      </label>
    </td>
    <td><input type='text'  name='Rukovoditel_podrazdeleniya'  readonly id='Rukovoditel_podrazdeleniya' />
	<div id='div_Rukovoditel_podrazdeleniya' class='error'></div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Ответственное лицо:   <label style='color: red'>*</label>    </label>
    </td>
    <td> <select name='Otvetstvennoe_lico' id='Otvetstvennoe_lico'>
	<option  value='null'>не выбрано</option>
	 	</select><div id='div_Otvetstvennoe_lico' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Телефон:      </label>
    </td>
    <td><input type='text' name='Telefon'   'id='Telefon' readonly/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='53' colspan='2'><strong>Техническое состояние</strong> <strong>помещения</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Окна:    <label style='color: red'>*</label>   </label>
    </td>
    <td><select name='Okna' id='Okna'>
	<option  value='не выбранно'>не выбрано</option>";
      $result3 = mysql_query("SELECT label FROM `sostoyanie`",$db);
     $m = mysql_fetch_array($result3);
     do{
       $pagetext = $pagetext ."<option  value='$m[label]'>".$m['label'].'</option>'; 
     }
     while($m = mysql_fetch_array($result3));
     $pagetext =$pagetext. "	</select>
	 <div id='div_Okna' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Двери: <label style='color: red'>*</label>
    </label></td>
    <td><select name='Dveri' id='Dveri'>
	<option  value='не выбранно'>не выбрано</option>";
      $result3 = mysql_query("SELECT label FROM `sostoyanie`",$db);
     $m = mysql_fetch_array($result3);
     do{
       $pagetext = $pagetext ."<option  value='$m[label]'>".$m['label'].'</option>'; 
     }
     while($m = mysql_fetch_array($result3));
     $pagetext =$pagetext. "	</select>
	 <div id='div_Dveri' class='error'></div>
	 </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Стены: <label style='color: red'>*</label>
    </label></td>
    <td><select name='Steni' id='Steni'>
	<option  value='не выбранно'>не выбрано</option>";
     $result3 = mysql_query("SELECT label FROM `sostoyanie`",$db);
     $m = mysql_fetch_array($result3);
     do{
       $pagetext = $pagetext ."<option  value='$m[label]'>".$m['label'].'</option>'; 
     }
     while($m = mysql_fetch_array($result3));
     $pagetext =$pagetext. "	</select>
	  <div id='div_Steni' class='error'></div>
	  </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Потолок: <label style='color: red'>*</label>
    </label></td>
    <td><select name='Potolok' id='Potolok'>
	<option  value='не выбранно'>не выбрано</option>";
      $result3 = mysql_query("SELECT label FROM `sostoyanie`",$db);
     $m = mysql_fetch_array($result3);
     do{
       $pagetext = $pagetext ."<option  value='$m[label]'>".$m['label'].'</option>'; 
     }
     while($m = mysql_fetch_array($result3));
     $pagetext =$pagetext. "	</select>
	 <div id='div_Potolok' class='error'></div>
	 </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Пол: <label style='color: red'>*</label>
    </label></td>
    <td><select name='Pol' id='Pol' >
	<option  value='не выбранно'>не выбрано</option>";
      $result3 = mysql_query("SELECT label FROM `sostoyanie`",$db);
     $m = mysql_fetch_array($result3);
     do{
       $pagetext = $pagetext ."<option  value='$m[label]'>".$m['label'].'</option>'; 
     }
     while($m = mysql_fetch_array($result3));
     $pagetext =$pagetext. "	</select>
	  <div id='div_Pol' class='error'></div>
	  </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Наличие перепланировок:   <label style='color: red'>*</label>    </label>
    </td>
    <td><select name='Nalichie_pereplanirovok' id='Nalichie_pereplanirovok'>
	<option  value='не выбранно'>не выбрано</option>
      <option value='1'>да</option>
      <option value='0'>нет</option>
    </select>
	<div id='div_Nalichie_pereplanirovok' class='error'></div>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Наличие перепланировок - комментарии:      </label>
    </td>
    <td><textarea name='Nalichie_pereplanirovok_komment' rows='7' cols='60' id='Nalichie_pereplanirovok_komment'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label> Номер санитарного паспорта: </label>
	
      </td>
    <td>
    
   <input type='text' name='San_pasport' id='San_pasport'  onChange='controlNumbers(this)'   title='Вводить можно только числа'/><div id='div_San_pasport' style='color:red'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Сигнализация: <label style='color: red'>*</label></label>
      <p><br />
        <br />
      </p>
    </td>
    <td><input type='checkbox' name='Сигнализация' value=1 id='Сигнализация_0' onclick = 'Signalizaciya2()' />
    <label>охранная<br />
      <input type='checkbox' name='Сигнализация2' value=1 id='Сигнализация_1' onclick = 'Signalizaciya2()' />
пожарная</label>
    <br />
    <label>
      <input type='checkbox' name='Сигнализация3' value='нет' id='Сигнализация_2' onclick = 'Signalizaciya()' checked />
      нет</label>
    <label>    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='55' colspan='2'><strong>Отметки инвентаризационной комиссии:</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Замечания инвентаризаци-онной комиссии:      </label>
    </td>
    <td><textarea name='Zamechaniya' rows='7' cols='60' id='Zamechaniya'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Предложения:      </label>
  </td>
    <td><textarea rows='7' cols='60' name='Predlojeniya' id='Predlojeniya'></textarea>

</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Дата инвентаризации:  <label style='color: red'>*</label>     </label>
    </td>
    <td><input  class='datepickerTimeField' name='Data' id='Data'   value='$Data'/>
	<div id='div_Data' class='error'></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>Участники инвентаризационной комиссии: <label style='color: red'>*</label></label>
   </td>
    <td><select class='input' type=text  style='width: 200px;' name='Uchastnik_kom[]' id='Uchastnik_kom[]'  metod='post' size='4'   multiple></select>&nbsp;<input type=button  name='delRow' value='Удалить участника' title='Выберите участника из списка и нажмите кнопку' class='delButtonForm' style='width:160' onClick='Delete()'/><div id='div_Uchastnik_kom[]' class='error'></div>
	</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label> Выбрать участника инвентаризационной комиссии:      </label>
	
      </td>
    <td>
    
   <select class='input' type=text  name='ViborUchastnik_kom' id='ViborUchastnik_kom' metod='post'>";
	
          $result2 = mysql_query('SELECT * FROM `Uchastnik_inv_komissii` ',$db);
          $m = mysql_fetch_array($result2);
          do{
             $pagetext = $pagetext . '<option  value='.$m['id_uchastnika_inv_komissii'].'>'.$m['Familiya'].' '.$m['Imya'].' '.$m['Otchestvo'].'</option>'; 
          }
         while($m = mysql_fetch_array($result2)); 

$pagetext =$pagetext. "  </select>
<input type='button' name='Dobavit' value='' class='addButton' onfocus='controlEdits()'  onClick='DobavitUchastnika()'>
</td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type=submit  class='okButton' name = 'add' id = 'add' value='$buttonName' onClick = 'Uchastnik()'/>
<input name='nomerKom' type='hidden' value='$Nomer_komnatiEdit'>
 <input name='Etag' type='hidden' value='$Etag'>
   <input name='nomerKor' type='hidden' value='$Nomer_korpusaEdit'>
   <input name='dataNachalaEdit' id='dataNachalaEdit' type='hidden' value='$Data_nachala'>
    <input name='Podrazdelenie' id='Podrazdelenie' type='hidden' value='$Structurnoe_podrazdlenie'>
   
  
 </form>
 
<form  name = 'form2' method=POST action='".$_SERVER['PHP_SELF']."?nav=delPom' onSubmit = 'return query() '>
<input type=submit  name = 'del' id = 'del'  class='delButtonForm' value='Удалить данные о помещение'   />
<script>
 //alert(jq('#Nomer_komnati').length());
// if(jq('#Nomer_komnati').length==0)
   jq('#del').hide();
 </script>
<input name='nomerKor' type='hidden' value='$Nomer_korpusaEdit'>
 <input name='nomerKom' type='hidden' value='$Nomer_komnatiEdit'>
 <input name='Etag' type='hidden' value='$Etag'>
 </form>

<label style='color: red'>*</label><label>&nbsp;-&nbsp;обязательные поля для заполнения </label>

<script >  
if(document.getElementById('add').value == 'Внести изменения'){
 jq('#del').show();
 var kor = document.getElementById('Nomer_korpusa');	
	for ( var i=0; i<kor.options.length; i++ ){
         if (kor.options[i].value == '$korpus') {
			 kor.selectedIndex=i;
			  kor.selectedIndex=i; 
			  kor.onchange();
			  break;
		  }
	 }
	 var o = document.getElementById('Arenda');
   for ( var i=0; i<o.options.length; i++ ){
         if (o.options[i].value == '$Arenda') {o.selectedIndex=i;break;}}
		 
   var vid = document.getElementById('Vid_prava');
   for ( var i=0; i<5; i++ ) { 
     if (vid.options[i].value == '$Vid_prava') {vid.selectedIndex=i;break;}}
   var kor = document.getElementById('Nomer_korpusa');
   for ( var i=0; i<kor.options.length; i++ ){
         if (kor.options[i].value == '$Nomer_korpusaEdit') {kor.selectedIndex=i;kor.onchange();kor.disabled=true;break;}}
	var etag = document.getElementById('Etag2');
   for ( var i=0; i<etag.options.length; i++ ){
         if (etag.options[i].value == '$Etag') {etag.selectedIndex=i;etag.disabled=true;break;}}	
	var cat = document.getElementById('Categoriya_pomesh');
	for ( var i=0; i<cat.options.length; i++ ){
         if (cat.options[i].value == '$Categoriya_pomesh') {cat.selectedIndex=i;break;}}
	document.getElementById('Naznachenie_pomesh').value ='$Naznachenie_pomesh' ;	 
  	document.getElementById('Sootvetstvie').value ='$Sootvetstvie' ;
	var vid = document.getElementById('Vid_ispolzovanie');	 
	 for ( var i=0; i<vid.options.length; i++ ){
         if (vid.options[i].value == '$Vid_ispolzovanie') {vid.selectedIndex=i;break;}}
	var ob = document.getElementById('Obremenenie');	
	for ( var i=0; i<ob.options.length; i++ ){
        if (ob.options[i].value == '$Obremenenie') {ob.selectedIndex=i;break;}}
	var reg = document.getElementById('Rejim_ispol');	
	for ( var i=0; i<reg.options.length; i++ ){;
         if (reg.options[i].value == '$Rejim_ispol') {reg.selectedIndex=i;break;}}
	 document.getElementById('Data_nachala').value='$Data_nachala';
	
	  document.getElementById('Data_okonchaniya').value='$Data_okonchaniya';
	  document.getElementById('Kol-vo_mest_komment').value='$Kolvo_mest_komment';
	  var st = document.getElementById('Structurnoe_podrazdlenie');	
	 for ( var i=0; i<st.options.length; i++ ){
		         if (st.options[i].value == '$Structurnoe_podrazdlenie') {
					 st.selectedIndex=i; 
					 st.onchange();
					// st.disabled=true;
					// document.getElementById('Data_nachala').disabled = true;
					 
					 break;}}
   
 
		 var o = document.getElementById('Okna');
   for ( var i=0; i<o.options.length; i++ ){
         if (o.options[i].value == '$Okna') {o.selectedIndex=i;break;}}
		 var d = document.getElementById('Dveri');
   for ( var i=0; i<d.options.length; i++ ){
         if (d.options[i].value == '$Dveri') {d.selectedIndex=i;break;}}
		 var s = document.getElementById('Steni');
   for ( var i=0; i<s.options.length; i++ ){
         if (s.options[i].value == '$Steni') {s.selectedIndex=i;break;}}
		 var p = document.getElementById('Potolok');
   for ( var i=0; i<p.options.length; i++ ){
         if (p.options[i].value == '$Potolok') {p.selectedIndex=i;break;}}
		 var p = document.getElementById('Pol');
   for ( var i=0; i<p.options.length; i++ ){
         if (p.options[i].value == '$Pol') {p.selectedIndex=i;break;}} 
	   var per = document.getElementById('Nalichie_pereplanirovok');
	  
 	   if($Nalichie_pereplanirovok==1){per.selectedIndex=1; }
	   if($Nalichie_pereplanirovok=='0') {per.selectedIndex=2;}
	  
	   	  
	   document.getElementById('Nalichie_pereplanirovok_komment').value = '$Nalichie_pereplanirovok_komment';
	 
	   document.getElementById('Nomer_komnati').value = '$Nomer_komnatiEdit';
	   document.getElementById('Sootvetstvie').value = '$Sootvetstvie';
	   document.getElementById('Naimenovanie_zdaniya').value = '$Naimenovanie_zdaniya';
       document.getElementById('Nomer_tehpasporta').value = '$Nomer_tehpasporta';
	   document.getElementById('Obshaya_ploshad').value = '$Obshaya_ploshad';
	   document.getElementById('Kol-vo_mest').value = '$Kolvo_mest';
	   document.getElementById('Kol-vo_mest_komment').value = '$Kolvo_mest_komment';
	   document.getElementById('San_pasport').value = '$San_pasport';
	   document.getElementById('Data').value = '$Data';
	   var s1= document.getElementById('Сигнализация_0');
 	   if('$Сигнализация'=='1') {s1.checked=true;s1.onclick();}
	   var s2= document.getElementById('Сигнализация_1');
	   if('$Сигнализация2'=='1') {s2.checked=true;s2.onclick();}
	   document.getElementById('Zamechaniya').value = '$Zamechaniya';
	   document.getElementById('Predlojeniya').value = '$Predlojeniya';
	   var u = document.getElementById('ViborUchastnik_kom');
       for ( var j2=1; j2<n.length; j2++ ){
		 for ( var i=0; i<u.options.length; i++ ){
			if (u.options[i].value == n[j2]) 
			{
				 u.selectedIndex=i;
				 form1.Dobavit.onclick();
			 }
    	  } 
	   }
}
</script>
</body>
</html>
";


return $pagetext;}
?>
</body></html>