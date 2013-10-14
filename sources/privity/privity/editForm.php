<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>Система мониторинга деятельности подразделения</font></title>
 <script language='JavaScript' >
//-------------------------------------------------------------------------------------
function loadXMLDoc( method, url ){
	
  if ( window.XMLHttpRequest ) {
    req = new XMLHttpRequest();
    
	req.onreadystatechange = processReqChange;
    req.open(method, url, true);
    req.send(null);
	} else if ( window.ActiveXObject ) {
    req = new ActiveXObject( "Microsoft.XMLHTTP" );
    if ( req ) {
	  //alert(reg.status);	
      req.open( method, url, true );
	  req.onreadystatechange = processReqChange;
      req.send(null);
    }
  }
}
function processReqChange() {
	
  if ( req.readyState == 4 ) {
    if ( req.status == 200 )
	   getLica(req.responseXML.documentElement);
    else
      alert("There was a problem retrieving the XML data:\n" + req.statusText);
  }
}

function onChangeMy() {
	
	var url = "/sources/privity/uio_queryKomnati.php?korpus="+encodeURI(document.form1.Nomer_korpusaEdit.value);//encodeURI Для преобразоввания рус букв
	//alert("uio_queryKomnati.php?korpus="+document.form1.Nomer_korpusa.value);
	loadXMLDoc( "get", url );
	document.form1.prosmotr.disabled=true;
	
}



function getLica( xml ) {

   var kom = xml.getElementsByTagName( 'komnata' );

  var _select = document.getElementById( "Nomer_komnatiEdit" );
  _select.innerHTML = ""; 
   for ( i=0; i<kom.length; i++ ) { 
    var option = document.createElement( "option" );
    var optionText = document.createTextNode(kom[i].firstChild.data );
    option.appendChild( optionText );
    option.setAttribute( "value",kom[i].getAttribute("value") );
    _select.appendChild( option );
	
  }
  if(document.getElementById( "Nomer_komnatiEdit" ).value.length>0)
	document.form1.prosmotr.disabled=false;
	
}
function clickB(){
	//alert($_SESSION['Nomer_korpusaEdit']);
// $_REQUEST['Nomer_korpusaEdit']=	document.getElementById( "Nomer_korpusaEdit" );
//alert($_REQUEST['Nomer_korpusaEdit']);
}
</script>
</head>
<body>
<?php
function edit($db){
    
		 
$buttonName=$_GET['buttonName'];
$pagetext = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Система мониторинга деятельности подразделения</font></title>
 
  <style type='text/css'>
    @import url('styles/style.css');
  </style>

</head>
<body>";
if($_GET['r']=="edit") $pagetext =$pagetext. "<form  name = 'form1' method=POST action=".$_SERVER['PHP_SELF']."?nav=editForm>";
if($_GET['r']=="otchet") $pagetext =$pagetext. "<form  name = 'form1' method=POST  action=".$_SERVER['PHP_SELF']."?nav=kartochka>";
if($_GET['r']=="otchetHistoryTeh") $pagetext =$pagetext. "<form  name = 'form1' method=POST  action=".$_SERVER['PHP_SELF']."?nav=otHis>";
if($_GET['r']=="otchetHistoryIspolzovaniya") $pagetext =$pagetext. "<form  name = 'form1' method=POST  action=".$_SERVER['PHP_SELF']."?nav=otHisIspolzovaniya>";
$pagetext =$pagetext."

<table border=0 width='600' height='10'>
  <tr>
    <td width='140'>  <label>Корпус №:</label></td>
    <td width='40'><select name='Nomer_korpusaEdit' id='Nomer_korpusaEdit' ONCHANGE='onChangeMy()' value ='$korpus'>";
	
	 $result2 = mysql_query('SELECT * FROM `Korpus` ',$db);
     $m = mysql_fetch_array($result2);
	 do{
       $pagetext =$pagetext. '<option value='.$m['Nomer_korpusa'].'>'.$m['Nomer_korpusa'].'</option>'; 
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."  </select></td>
	
    <td width='140'> <label>Комната №:</label></td>
	<td>
	<select name='Nomer_komnatiEdit' id='Nomer_komnatiEdit' value ='$korpus'>";
	 $result2 = mysql_query("SELECT Nomer_komnati From `Pomesenie`  where Nomer_korpusa_FK  =(select Nomer_korpusa from Korpus limit 1)   group by Nomer_komnati ",$db);
     $m = mysql_fetch_array($result2);
	 do{
       $pagetext =$pagetext. '<option value='.$m['Nomer_komnati'].'>'.$m['Nomer_komnati'].'</option>'; 
     }
     while($m = mysql_fetch_array($result2));
    $pagetext =$pagetext."</select>
	</td>
    <td width='150'><input type=submit  name = 'prosmotr' value='Просмотреть данные о помещение'  onClick='clickB()' disabled/></td>
    <td width='100'>&nbsp;</td>
  </tr>
  <script>
     if(document.form1.Nomer_komnatiEdit.value.length>0)document.form1.prosmotr.disabled=false;
  </script>
  </body>
</html>
";

return $pagetext;}
?>
