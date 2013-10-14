

var j = jQuery.noConflict();
j(document).ready(function(){
	
	j(".datepickerTimeField").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        firstDay: 1, 
		changeFirstDay: false,
        navigationAsDateFormat: false,
        duration: 0});// ��������� ������ ���������
		
});

var n = new Array();

<?php if($rows>0){
	//foreach($uchastnik as $id=>$value) echo "n[$id] = '$uchastnik[$]';";
        for($j=1;$j<=$rows;$j++){ 
          
          echo "n[$j] = '$uchastnik[$j]';"	;
        }
		}
 ?>

//-------------------------------------������� ��������� ���������� ��� ���������� � ����-------------------------------------------
function Uchastnik(){
	
	var objSel = document.getElementById("Uchastnik_kom[]");
    for (var key in objSel.options) {
      objSel.options[key].selected='true';
    }
}
///---------------------------------------------------�������� ������ ������������----------------------------------
function Signalizaciya(){
  document.form1.������������.checked = false;
  document.form1.������������2.checked = false;
}

function Signalizaciya2(){
  document.form1.������������3.checked = false;
}
//--------------------------------------��������� ����� ������� � ����----------------------------------------------------------------
function pressKorpus() {
	/*$(".datepickerTimeField").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        firstDay: 1, changeFirstDay: false,
        navigationAsDateFormat: false,
        duration: 0,// ��������� ������ ���������
});*/
	//$(".datepickerTimeField").hide();
//text());// == '������ ���������')alert('asd');
	//j("#Obshaya_ploshad").hide();
  www = document.form1.Nomer_korpusa.selectedIndex;
  www=document.getElementById("Nomer_korpusa").value;
  getAdres('/sources/privity/uio_queryAdresKorpusa.php?korpus='+www);
  }
  
  

//--------------------------------------------------���������� ��������� � ������ ����������--------------------------------------
function DobavitUchastnika(){
	var objSel = document.getElementById("Uchastnik_kom[]");
	var uchastnik = document.getElementById("ViborUchastnik_kom");	
	var flag = 'false';
	
	var i=0;
	//for (var key in objSel.options) {
	for (var i=0;i<objSel.length;i++){// in objSel.options)	
	    var val = objSel.options[key].value;
	    if(val == uchastnik.options[uchastnik.selectedIndex].value){ flag ='true';}
	}
	if(flag=='false'){
	  objSel.options[objSel.length] = new Option(uchastnik.options[uchastnik.selectedIndex].text, uchastnik.options[uchastnik.selectedIndex].value);
	}
	//controlEdits(); 
	
}

//-------------------------------��������� ������ �� ������ �������---------------------------------------------------------------
function getAdres(sURL){
	
	document.form1.adr.value = loadHTML3(sURL);

	
}
///--------------------------------������ �� ������ � ���������� ������-----------------------------------------------------------
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
 // alert(request.);
 //  alert(request.responseText);
 
  return request.responseText;
}
//-------------------������ �� ������ � ������������� � ���������� XML -------------------------------------------------------------
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
function onChangeMy3()
{
	  document.form1.Telefon.value = loadHTML3("/sources/privity/uio_queryTelefonPod.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value); 
	document.form1.Rukovoditel_podrazdeleniya.value = loadHTML3("/sources/privity/uio_queryRukovPod.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value);
	var url = "/sources/privity/uio_queryOtvLica.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value;
	loadXMLDoc4( "get", url );
}

function getLica4( xml ) {
	
   var Lica = xml.getElementsByTagName( 'otv_lico' );
   var _select = document.getElementById("Otvetstvennoe_lico");
  _select.innerHTML = ""; 
   for ( i=0; i<Lica.length; i++ ) { 
     var option = document.createElement( "option" );
     var optionText = document.createTextNode( Lica[i].firstChild.data );
     option.appendChild( optionText );
     option.setAttribute( "value",Lica[i].getAttribute("value") );
     _select.appendChild( option );
   }
} 
//-------------------------------------------�������� ����� ������-----------------------------------------------------------------
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
			case '�':{flag=true;edit.style.color='red';}
			case ';':{flag=true;edit.style.color='red';}
			case ':':{flag=true;edit.style.color='red';}
			case '?':{flag=true;edit.style.color='red';}
			case '*':{flag=true;edit.style.color='red';}
		    
		}
		 
	}
	form1.add.disabled=true;
	if(flag){
		var name = 'div_'+edit.name;
		document.getElementById(name).innerHTML=" <div  style='font-size:12'><i>����� ������� ������ ����� � �����</i></div>";
		form1.add.disabled=true;}
	else {
		form1.add.disabled=false;
		var name = 'div_'+edit.name;
		document.getElementById(name).innerHTML='';
		
//	controlEdits();
      }
}
function controlEdits(){
  // alert(document.form1.Data.value.length);
  var flag=false;
  form1.add.disabled=false;
	//if(document.form1.Nomer_komnati.value==='' || document.form1.Sootvetstvie.value==='' || document.form1.Naimenovanie_zdaniya.value==='' ||document.form1.Nomer_tehpasporta.value==='' || document.form1.Obshaya_ploshad.value==='' || document.form1.Naznachenie_pomesh.value==='' || document.form1.Data_nachala.value==='' || document.form1.Kol-vo_mest.value==='' || document.form1.San_pasport.value==='' || document.form1.Data.value==='' || document.getElementById("Uchastnik_kom[]").length>1) form1.add.disabled=true;//flag=true;
//	alert(document.getElementById("Nomer_komnati").value);
	//if(document.form1.Nomer_komnati.value!=""){flag=false;}else {flag=true;
	//  if(document.form1.Sootvetstvie.value!=""){flag=false;}else {flag=true;}}
//	if(document.form1.Naimenovanie_zdaniya.value!=""){flag=false;}else {flag=true;}
//	if(document.form1.Nomer_tehpasporta.value!=""){flag=false;}else {flag=true;}
//	if(document.form1.Obshaya_ploshad.value!=""){flag=false;}else {flag=true;}
	//if(document.form1.Naznachenie_pomesh.value!=""){flag=false;}else {flag=true;}
//	if(document.form1.Data_nachala.value!=""){flag=false;}else {flag=true;}
	//if(document.form1.Kol-vo_mest.value!=""){flag=false;}else {flag=true;}
	//if(document.form1.San_pasport.value!=""){flag=false;}else {flag=true;}
	//if(document.form1.Data.value!=""){flag=false;};else {flag=true;}
	//if(document.getElementById("Uchastnik_kom[]").length==0){flag=false;}else {flag=true;}
	//else {form1.add.disabled=false;}
//	
//alert(document.form1.Data.value.length);

 
//if(flag==true)form1.add.disabled=true;
//else form1.add.disabled=false;
//if(document.form1.Data.value!="") alert("2");
return flag;
}



//---------------------------------------�������� ����� �������-----------------------------------------
function dataSelect() {
	var flag=false;
	var n = document.getElementById("Nomer_korpusa").selectedIndex;
	if(n) document.getElementById("div_Nomer_korpusa").innerHTML="";
	else  
	{
		document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>�������� ������</i></div>";
		flag=true;
	}
return flag;	
 }
	
	
	
//-----------------������� ����� ������ �����----------------------------------------------------
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
		document.getElementById(name).innerHTML=" <div  style='font-size:12'><i>����� ������� ������ �����</i></div>";
	//	document.getElementById(name).innerHTML='����� ������� ������ �����';
		
	}
	//controlEdits();
}
function Delete(){
	
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
	dataSelect();
  var errMSG = ""; 
  // ���� ���� ���������� ��� �������� � ������� f, 
  // ���������� � �������� ���������
  // �������, � ������ ������ - ���� �����.            
  for (var i = 0; i<f.elements.length; i++) 
    // ���� ������� ������� ����� ������� required
    // �.�. ������������ ��� ����������
    if (null!=f.elements[i].getAttribute("required")) 
       // ���������, �������� �� �� � �����
        if (isEmpty(f.elements[i].value)) // ������
            errMSG += "  " + f.elements[i].name + "\n"; // ��������� ���������
                                                       // �� ������, ���������� 
                                                       // ������������� ����
        // ���� ��������� �� ������ �� �����,
        // ������� ���, � ���������� false   
		//if(document.getElementById("Uchastnik_kom[]").length<1) errMSG="������� ���������";
        if ("" != errMSG) {
            alert("�� ��������� ������������ ����:\n");// + errMSG);
            return false;
        }
		dataSelect();
}
function query(){
  var flag;
  if(confirm("�� �������,��� ������ �������?")) flag = true;
  else flag=false;
  return flag;
}

