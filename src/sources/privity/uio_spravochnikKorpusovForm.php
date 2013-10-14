

<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>Система мониторинга деятельности подразделения</font></title>
  <link type=text/css href=/styles/common.css rel=stylesheet>
   <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
  <script language='JavaScript'>
<!-- hide

var flagKorpus=false;//Флаг ошибок номера корпуса
var flagAdr=false;//Флаг ошибок адреса корпуса
var countAdr=0;
var countKorpus=0;
var emptyKorpus = true;
var emptyAdr = true;
//------------------------------------------------Поиск пустого поля----------------------------------------
function searchPole2()
{
	var result = false;
	var empty = false;
	var table  = document.getElementById("tb1");
	var currow= table.rows.length; // вычислить количество строк в таблице
	for(var i=1;i<currow;i++){
	   var adr = "adrEdit"+i;
	   var adrEdit = document.getElementById(adr).value.length;
	   if(adrEdit == 0){ result=true;break;}
	   var nomer = "nomerEdit"+i;
	   var nomerEdit = document.getElementById(nomer).value.length;
	if(nomerEdit == 0){ result=true;break;}
	}
	return result;
	
}

//--------------------------------------------Контроль ввода символов-----------------------------------------------------------------
function control2(edit){
	edit.style.color='black';
	var flag = false;
	for(var i=0;i<edit.value.length;i++)
	{
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
	return flag;
}
//------------------------------------------Контроль ввода адресса корпуса-----------------------------------------
/*function controlAdr(edit){
 // if(searchPole2()==false){
	 if(edit.text!=""){
		 countAdr=0;
		 emptyAdr = false;
	flagAdr = control2(edit);
	form1.addToBase.disabled=true;
	if(flagAdr){
		document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>Недопустимые символы в адресе корпуса</i></div>";
	  form1.addToBase.disabled=true;
	 
	}
	var table  = document.getElementById("tb1");
	var currow;	   
    currow = table.rows.length; // вычислить количество строк в таблице
	var count=0;
	var count2=0
	for(var i=1;i<currow;i++){
		var adr = "adrEdit"+i;
		var adrEdit = document.getElementById(adr);
		if(edit.value == adrEdit.value) {count2++;}
	}
	if(count2 > 1)  {
		edit.style.color='red';
		countAdr++;
		document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>Корпус с таким адресом уже существует</i></div>";
	}
	else 
	  if((count2==1)&&(countAdr>0)&&(flagAdr==false))countAdr--;
	if(countAdr>1) {
		form1.addToBase.disabled=true;
		document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>Корпус с таким адресом уже существует</i></div>";
	}
    if((count2==1)&& (flagAdr==false))
	{
		 document.getElementById("div_Nomer_korpusa").innerHTML='';
		edit.style.color='black';
		
	}
	if((countKorpus==0)&&(countAdr==0)&&(flagAdr==false)&&(emptyKorpus == false))
	{
		form1.addToBase.disabled=false;
		edit.style.color='black';
			}
	else form1.addToBase.disabled=true;
  } else 
 {
	  emptyAdr = true;
	  form1.addToBase.disabled=true;
	 
  }
  //	myBlue(edit);
}*/

function Click(edit){
	//form1.addToBase.disabled=true;
	//controlAdr(edit);
	//controlKorpus(edit)
}
//---------------------------------------------Контроль ввода корпусов---------------------------------------------------
function controlKorpus(edit){
 // if(searchPole2()==false){
	  if(edit.text!=""){
		  countKorpus=0;
		emptyKorpus = false;  
	flagKorpus = control2(edit);
	form1.addToBase.disabled=true;
	if(flagKorpus){/*alert("Имеются недопустимые символы");*/
	  form1.addToBase.disabled=true;
	  document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>Недопустимые символы в номере корпуса</i></div>";
	}
	  var table  = document.getElementById("tb1");
	  var currow;	   
	  currow = table.rows.length; // вычислить количество строк в таблице
	  var count=0;
	  var count2=0
	  for(var i=1;i<currow;i++){
		  var nomer = "nomerEdit"+i;
		  var nomerEdit = document.getElementById(nomer);
		  if( edit.value == nomerEdit.value ) {count2++;}
	   }
	  if( count2 > 1 )  {
		  edit.style.color='red';
		  countKorpus++;
		   document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>Корпус с таким номером уже существует</i></div>";
	  }
	else 
	  if((count2==1)&&(countKorpus>0)&&(flagKorpus==false))countKorpus--;
	if(countKorpus>1) {
		  form1.addToBase.disabled=true;
		  document.getElementById("div_Nomer_korpusa").innerHTML=" <div  style='font-size:12'><i>Корпус с таким номером уже существует</i></div>";
	}
	if(count2==1) 
	{
		edit.style.color='black';
		 document.getElementById("div_Nomer_korpusa").innerHTML='';
	}
	
	
	if((countKorpus==0)&&(flagKorpus==false))
	{
		form1.addToBase.disabled=false;
		edit.style.color='black';
	}
	else form1.addToBase.disabled=true;
  } else 
  {
	  emptyKorpus = true; 
	  form1.addToBase.disabled=true;
	   
  }
//  myBlue(edit);
}
function myBlue(edit){
	 var table  = document.getElementById("tb1");
	 var currow = table.rows.length-1;
	 var e1 = "adrEdit"+currow; 
	 var e2=document.getElementById(e1).value.length;
	 var e3 = "nomerEdit"+currow; 
	 e4 = document.getElementById(e3).value.length;
	 if((e2==0)||(e4==0))
	 {
		  form1.add.disabled=true;
	 }
	 else
	 { 
	   form1.add.disabled=false;
	 }
       
}
//--------------------------------------------Добавляет новую строку--------------------------------------------
function refresh(){
	 emptyKorpus = true;
     emptyAdr = true;
 	form1.add.disabled=true;
	var table  = document.getElementById("tb1");
	var currow;	   
    currow = table.rows.length; 
    table.insertRow(currow); 
    table.rows[currow].insertCell(0);
    table.rows[currow].insertCell(1);
    table.rows[currow].insertCell(2);
   // table.rows[currow].insertCell(3);
	// вставляем в форму поля
     table.rows[currow].cells[0].innerHTML = 
	      currow;
    table.rows[currow].cells[1].innerHTML = 
	      "<input  type='text' id='adrEdit"+currow+"'  name='adrEdit"+currow+"' onblur='myBlue(this)' onkeyup='controlAdr(this)'\>";
   table.rows[currow].cells[2].innerHTML = 
	      "<input  type='text' maxlength=2 id='nomerEdit"+currow+"'  name='nomerEdit"+currow+"'   onblur='myBlue(this)' onkeyup='controlKorpus(this)'\>";
		  var e= "adrEdit"+currow;
		  document.getElementById(e).focus();
		  form1.addToBase.disabled=true;
		  table.rows[currow].cells[0].className = 'mytr';
		table.rows[currow].cells[1].className = 'mytr';
		table.rows[currow].cells[2].className = 'mytr';
		var count = document.getElementById("Count").value;
		count++;
		 document.getElementById("Count").value=count;	
}
// -->
</script>
</head>
<body>
<?php 
function korpus($db){
	
	$pagetext = "<form  name = 'form1' method=POST action='".$_SERVER['PHP_SELF']."?nav=editKorpus'>
         <table border=1 width=100 height=100 id ='tb1' name='tb1' cellspacing='0'>
		 <tr class='backcol'>
		    <td width='50'>\</td>
		    <td width='106'>Адрес&nbsp;корпуса</td>
			<td width='15'>Номер&nbsp;корпуса</td>
		 </tr>";
   
    $result2 = mysql_query('SELECT * FROM `Korpus` order by nomer_korpusa+0 ',$db);
    $m = mysql_fetch_array($result2);
	$i=1;
    do{
		$pagetext =$pagetext. "<tr>
		       <td class='mytr'>".$i."</td>
		       <td class='mytr'><input  type='text' id = 'adrEdit".$i."' name='adrEdit".$i."' value ='".$m['Adres_zdaniya']. "' onkeyup='controlAdr(this)' onblur='myBlue(this)'/> </td>
			   <td class='mytr'><input  type='text' id = 'nomerEdit".$i."' maxlength=2 name='nomerEdit".$i."' value ='". $m['Nomer_korpusa']."'   onkeyup='controlKorpus(this)' onblur='myBlue(this)' /></td>
		
		   </tr>";
		   $i++;
     }
    while($m = mysql_fetch_array($result2));
	$pagetext =$pagetext."
	</table>
	<br>
	 <table border=0 width=100>
	 <tr>
		<td> <input type=button  name='add' value='Добавить новую строку'  onclick='refresh()'/> </td>
	 </tr>
	 <tr>
		 <td width='10'><input type=submit  name='addToBase'  class='okButton' value='Внести изменеия' /></td>
     </tr>
		 <div id='div_Nomer_korpusa' style='color:red'></div>
		 </table>
		  <input name='Count' id='Count' type='hidden' value='$i'>
	 </form>
	
	";
	//for($j=1;$j<count($m);$j++){
	//	print_r($_POST);
	//   $nomer = $_POST['nomer.j.'];
	 //  $adr =$_POST['adr'];
     //  $db = mysql_connect('localhost','Shaman','123');
     //  mysql_select_db('mon',$db);
     //  $result = mysql_query("INSERT INTO `Korpus` ( `Nomer_korpusa` , `Adres_zdaniya`) VALUES ('','')",$db);
	//}
	return $pagetext;
}
?>
</body>
</html>