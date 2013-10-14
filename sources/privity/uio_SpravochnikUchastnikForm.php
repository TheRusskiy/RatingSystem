
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>Система мониторинга деятельности подразделения</font></title>
    <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
  <link type=text/css href=/styles/common.css rel=stylesheet>
  <script language='JavaScript'  >
  var flagFam=false;//Флаг ошибок фамилии
var flagImya=false;//Флаг ошибок имени
var flagOtch=false;//Флаг ошибок отчества
var countFam=0;//количество ишибок
var countImya=0;
var countOtch=0;
var flagEquels=false;
var countRow=0;
var error=0;
//------------------------------------------------Поиск пустого поля----------------------------------------
function searchPole()
{
	var result = false;
	var empty = false;
	var table  = document.getElementById("tb1");
	var currow= table.rows.length; // вычислить количество строк в таблице
	for(var i=1;i<=countRow;i++){
		try{
		   var i2=i-1;
		   var fam = "famEdit_"+i2;
		   var famEdit = document.getElementById(fam).value.length;
		   fam=document.getElementById(fam);
		 //  fam.style.color = 'black';
		   if(famEdit == 0){ result=true;/*fam.focus();*/error=fam.name; break;}
		   else {
			   if(control(fam)){fam.focus();
					result=true;
					error=fam.name;
					 fam.style.color = 'red';
					 document.getElementById('error').innerHTML="<error><div><i>Недопустимый символ в фамилии</i></div></error>";
					}
		   }  
		   var imya = "imyaEdit_"+i2;
		   var imyaEdit = document.getElementById(imya).value.length;
		   imya=document.getElementById(imya);
		//   imya.style.color = 'black';
		   if(imyaEdit == 0){ result=true;/*imya.focus();*/error=imya.name;break;}
		   else {
				if(control(imya)){imya.focus();
				   result=true;
				   error=imya.name;
				   imya.style.color = 'red';
				   document.getElementById('error').innerHTML="<error><div><i>Недопустимый символ в имени</i></div></error>";
				   }
		   }
		   var otch = "otchEdit_"+i2;
		   var otchEdit = document.getElementById(otch).value.length;
		   otch=document.getElementById(otch);
		 //  otch.style.color = 'black';
		   if(otchEdit == 0){ result=true;/*otch.focus();*/error=otch.name;break;}
			else {
				if(control(otch)){otch.focus();
				   result=true;
				   error=otch.name;
				   otch.style.color = 'red';
				   document.getElementById('error').innerHTML="<error><div><i>Недопустимый символ в отчестве</i></div></error>";
				   break;}
			}
	}
	catch(e){}
	}
	
	return result;
	
}
function controlNumber(edit){
	var flag=true;
	for(var i=0;i<edit.value.length;i++){
	if((edit.value[i]=='1')||(edit.value[i]=='2')||(edit.value[i]=='3')||(edit.value[i]=='4')||(edit.value[i]=='5')||(edit.value[i]=='6')||(edit.value[i]=='7')||(edit.value[i]=='8')||(edit.value[i]=='9')||(edit.value[i]=='0')) flag=true;
	 else {flag=false;break;}
    }
	if(flag==false) {
		edit.style.color='red';
		document.form1.delRow.disabled=true;
		document.getElementById('error').innerHTML="<error><div><i>Недопустимый символ</i></div></error>"
	}
	else{
		document.form1.delRow.disabled=false;
		edit.style.color='black';
		document.getElementById('error').innerHTML=""
	}
	return flag;
}
//---------------------------------------------Контроль ввода фамилий,имен,отчеств----------------------------------
function control(edit){
	var flag=false;
	for(var i=0;i<edit.value.length;i++){
		switch (edit.value[i])
		{
			case '/':{flag=true;}
		    case '':{flag=true;}
			//case ".":{flag=true;edit.style.color='red';}
			//case ",":{flag=true;edit.style.color='red';}
			//case ''':{flag=true;edit.style.color='red';}
			//case '"':{flag=true;edit.style.color='red';}
			case ']':{flag=true;}
			case '[':{flag=true;}
			case '{':{flag=true;}
			case '}':{flag=true;}
			case '|':{flag=true;}
			case '@':{flag=true;}
			case '!':{flag=true;}
			case '#':{flag=true;}
			case '$':{flag=true;}
			case '%':{flag=true;}
			case '^':{flag=true;}
			case '&':{flag=true;}
			case '*':{flag=true;}
			case '(':{flag=true;}
			case ')':{flag=true;}
			case '№':{flag=true;}
			case ';':{flag=true;}
			case ':':{flag=true;}
			case '?':{flag=true;}
			case '*':{flag=true;}
			case '0':{flag=true;}
			case '9':{flag=true;}
			case '8':{flag=true;}
			case '7':{flag=true;}
			case '6':{flag=true;}
			case '5':{flag=true;}
			case '4':{flag=true;}
			case '3':{flag=true;}
			case '2':{flag=true;}
			case '1':{flag=true;}
		}
	}
	return flag;
}

function errorEdit(edit) {//alert(error);
	  var name = edit.name;
	  var number=name.indexOf('_')+1;
	  var numberPol = name.substring(number,edit.length);
	  
	  if((error==edit.name)||(error==0)){
		if(searchPole()==false){
			
			flag=control(edit);
			if(flag){ 
			  error = edit.name;
			  
			  document.getElementById(edit.name).focus();
			  edit.style.color = 'red';
			  form1.addToBase.disabled=true;
			  form1.addRow.disabled=true;
			  
			}
			else  {//alert(equel(numberPol));
				if(equel(numberPol)){
				   error=edit.name;
				   
				   form1.addToBase.disabled=true;
				   var fam = 'famEdit_'+numberPol;
				   var imya = 'imyaEdit_'+numberPol;
				   var otch = 'otchEdit_'+numberPol;
				   document.getElementById(fam).style.color = 'red';
				   document.getElementById(imya).style.color = 'red';
				   document.getElementById(otch).style.color = 'red';
				   
				   form1.addToBase.disabled=true;
				   form1.addRow.disabled=true;
				  
				   document.getElementById(edit.name).focus();
				 }
				else {
					
				  error=0;
				  
				  edit.style.color = 'black';
	      
				  var fam = 'famEdit_'+numberPol;
				  var imya = 'imyaEdit_'+numberPol;
				  var otch = 'otchEdit_'+numberPol;
				  fam=document.getElementById(fam);
				  imya=document.getElementById(imya);
				  otch=document.getElementById(otch);
				  form1.addToBase.disabled=false;
				  form1.addRow.disabled=false;
				  if(control(fam)==false)fam.style.color='black';
				  if(control(imya)==false)imya.style.color='black';
				  if(control(otch)==false)otch.style.color='black';
				 
		  }
		}
	  }
	  else{
	  	 flag=control(edit);
	     if(flag){
			  error = edit.name;
			  document.getElementById(edit.name).focus();
			  edit.style.color = 'red';
			  form1.addToBase.disabled=true;
			  form1.addRow.disabled=true;
	          document.getElementById(error).focus();
		      form1.addToBase.disabled=true;
		      form1.addRow.disabled=true;  }
		  else {
			 error = 0;
			 edit.style.color = 'black';
			 document.getElementById('error').innerHTML=""
	      }
	  }
	}else   {document.getElementById(error).focus();
	document.getElementById('error').innerHTML="<error><div><i>Ошибка ввода</i></div></error>"}

}

////////////////////////////////////////////////
/*function controlEdit(edit,name,flagG,count){//edit-содержимое поля,name-имя поля,flag глобальный флаг,count -глобальный count,

  var number=name.indexOf('_')+1;
  numberPol = name.substring(number,edit.length);
 // if(searchPole()==false){
	flag=control(edit);
	if(flag){
	  if(edit.style.color == "#000000"){
		edit.style.color = 'red';  
		switch (name.substring(0,number-1)+'_')
		{
		   case "famEdit_":{flagFam=true;countFam++;break;}	
		   case "imyaEdit_":{flagImya=true;countImya++;break;}
		   case "otchEdit_":{flagOtch=true;countOtch++;break;}	
		}
	  }
	  else {
		  fam="famEdit_"+numberPol;
		  imya="imyaEdit_"+numberPol;
		  otch="otchEdit_"+numberPol;
		 if((document.getElementById(fam).style.color=="#ff0000")&&(document.getElementById(imya).style.color=="#ff0000")&&( document.getElementById(otch).style.color=="#ff0000")) {
			 
			 switch (name.substring(0,number-1)+'_')
		       {
		        case "famEdit_":{
					flagFam=true;
					countFam++;
					document.getElementById(imya).style.color="#000000";
					document.getElementById(otch).style.color="#000000";break;}	
		        case "imyaEdit_":{
					flagImya=true;
					countImya++;
					document.getElementById(fam).style.color="#000000";
					document.getElementById(otch).style.color="#000000";break;}
		        case "otchEdit_":{
					flagOtch=true;
					countOtch++;
					document.getElementById(fam).style.color="#000000";
					document.getElementById(imya).style.color="#000000";break;}	
       	     }
		 }
       }
	}
	else {  
	 if(edit.style.color == "#ff0000"){
		if(searchRed()==false){
		  edit.style.color = 'black'; 
		  switch (name.substring(0,number-1)+'_')
		  {
			 case "famEdit_":{if((countFam>0)&&(flagFam==true))countFam--;
			                  if(countFam==0)flagFam=false;break;}	
			 case "imyaEdit_":{if((countImya>0)&&(flagImya==true))countImya--;
								if(countImya==0)flagImya=false;break;}
			 case "otchEdit_":{if((countOtch>0)&&(flagOtch==true))countOtch--;
			                    if(countOtch==0)flagOtch=false;break;}	
		  }
		}
	 }
	  if(equel(numberPol)){
         flagEquels=true;
		 form1.addToBase.disabled=true;
		 count++; 
		 var fam = 'famEdit_'+numberPol;
		 var imya = 'imyaEdit_'+numberPol;
		 var otch = 'otchEdit_'+numberPol;
		 document.getElementById(fam).style.color = 'red';
		 document.getElementById(imya).style.color = 'red';
		 document.getElementById(otch).style.color = 'red';
	  }
	  else {
	    flagEquels=false;
		var fam = 'famEdit_'+numberPol;
		var imya = 'imyaEdit_'+numberPol;
		var otch = 'otchEdit_'+numberPol;
		fam=document.getElementById(fam);
		imya=document.getElementById(imya);
		otch=document.getElementById(otch);
		if(control(fam)==false)fam.style.color='black';
		else{flagFam=false;}
		if(control(imya)==false)imya.style.color='black';
		else{falImya=false;}
		if(control(otch)==false)otch.style.color='black';
		else{flagOtch=false;}
	  }
  }
  
  if((countFam==0)&&(countImya==0)&&(countOtch==0)&&(flagFam==false)&&(flagImya==false)&&(flagOtch==false)&&(flagEquels==false)){
		  form1.addToBase.disabled=false;}
  
  else {form1.addToBase.disabled=true;}
  if(searchRed()==false) {form1.addToBase.disabled=false; }
 //searchRed();
 if(searchPole())form1.addToBase.disabled=true;//alert("3");
}*/
//////////////////////////////контроль одинаковых записей////////////////////////////////////////////
function equel(num){
   var mas=[];
   var flag=false;
   var table=document.getElementById("tb1");
   var currow;	   
   currow = table.rows.length; // вычислить количество строк в таблице
   var count=0;
   var  famG = "famEdit_"+num;
   var famEditG = document.getElementById(famG);
   var imyaG = "imyaEdit_"+num;
   var imyaEditG = document.getElementById(imyaG);
   var otchG = "otchEdit_"+num;
   var otchEditG = document.getElementById(otchG);
   if((famEditG.value.length>0)&&(otchEditG.value.length>0)&&(imyaEditG.value.length>0)){
	 for(var i=1;i<=countRow;i++){
	   try{
		 var i2=i-1;
		 var fam = "famEdit_"+i2;//alert(fam);
		 var famEdit = document.getElementById(fam);
		 var imya = "imyaEdit_"+i2;
		 var imyaEdit = document.getElementById(imya);
		 var otch = "otchEdit_"+i2;
		 var otchEdit = document.getElementById(otch);
		 if((famEditG.value == famEdit.value)&&(imyaEditG.value==imyaEdit.value)&&(otchEditG.value==otchEdit.value)) {count++;}
	   }
		 catch(e){}
	 }
   }
   if(count>1){flag=true; document.getElementById('error').innerHTML="<error><div><i>Такой работник уже существует</i></div></error>";   }
   else {
	   document.getElementById('error').innerHTML=""
   }
   return flag;
}
function searchRed(){
  
   var flag=false;
   var table=document.getElementById("tb1");
   var currow;	   
   currow = table.rows.length; // вычислить количество строк в таблице
   var count=0;
   for(var i=1;i<currow;i++){
	 i3=i-1;
	 var  famG = "famEdit_"+i3;
	 var famEditG = document.getElementById(famG);
	 if((famEditG.style.color == "#ff0000")&&(control(famEditG)==false)){
	   var imyaG = "imyaEdit_"+i3;
	   var imyaEditG = document.getElementById(imyaG);
	   if((imyaEditG.style.color == "#ff0000")&&(control(imyaEditG)==false)){
		 var otchG = "otchEdit_"+i3;
		 var otchEditG = document.getElementById(otchG);
		 if((otchEditG.style.color == "#ff0000")&&(control(otchEditG)==false)){
		   for(var j=1;j<currow;j++){
			 var i2=j-1;
			 var fam = "famEdit_"+i2;
			 var famEdit = document.getElementById(fam);
			 var imya = "imyaEdit_"+i2;
			 var imyaEdit = document.getElementById(imya);
			 var otch = "otchEdit_"+i2;
			 var otchEdit = document.getElementById(otch);
			 if((famEditG.value == famEdit.value)&&(imyaEditG.value==imyaEdit.value)&&(otchEditG.value==otchEdit.value)) {count++;}
			}
		   if(count>1){flag=true;form1.addToBase.disabled=true;}
		   if(count==1){
			 famEditG.style.color='black';  
			 imyaEditG.style.color='black';
			 otchEditG.style.color='black';
		   }
		 }
	   }
	  }
	}
   return flag;
}
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

function onChangeMy2() {
	//alert(document.location.hostname);
	var url = "sources\\privity\\uio_queryOtvLicaSpravochnik.php?podrazdelenie="+document.form1.Structurnoe_podrazdlenie.value;
	alert(url);
	form1.addRow.disabled = false;
	loadXMLDoc( "get", url );
	form1.addToBase.disabled=false;
	
//	alert( "<?php $_SERVER['PHP_SELF'] ?>");
	}


function disEdit(){
	form1.addToBase.disabled=true;
	form1.addRow.disabled=true;
}
function getLica( xml ) {
   form1.addRow.disabled=false;
   var Fam = xml.getElementsByTagName( 'fam' );
   var Imya = xml.getElementsByTagName( 'imya' );
   var Otch = xml.getElementsByTagName( 'otch' );
   var table2  = document.getElementById("tb1");
   var currow2;	   
   currow2 = table2.rows.length; // вычислить количество строк в таблице
   for(var i=1;i<currow2;i++)
   {
     table2.deleteRow(1);  
   }
   if(Fam[0].firstChild.data)var t=0;
   var currow =1;
   for ( i=0; i<Fam.length; i++ ) { 
  // if(Fam[i].firstChild.data.length)
      var table  = document.getElementById("tb1");
	  currow=i+1;
      table.insertRow(currow); // добавляем строку в таблицу
      table.rows[currow].insertCell(0); // добавляем ячейки
      table.rows[currow].insertCell(1);
      table.rows[currow].insertCell(2);
      table.rows[currow].insertCell(3);
	  table.rows[currow].insertCell(4);
	// вставляем в форму поля
	number = i+1;
	
      table.rows[currow].cells[0].innerHTML = 
	      "<input style='width:20px' type='text' id='number"+number+"'  value='"+number+"' readonly name='newStroka' \>";
    table.rows[currow].cells[1].innerHTML = 
	      "<input  type='text' style ='color:black' id='famEdit_"+i+"'  value='"+Fam[i].firstChild.data+"' name='famEdit_"+i+"'  onBlur='errorEdit(this)' onkeyup='disEdit()'\>";
    table.rows[currow].cells[2].innerHTML = 
	    "<input  type='text'  style ='color:black' id='imyaEdit_"+i+"' value ='"+Imya[i].firstChild.data+"' name='imyaEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'\>";
     table.rows[currow].cells[3].innerHTML = 
	 "<input  type='text' style ='color:black' id='otchEdit_"+i+"' value='"+Otch[i].firstChild.data+"' name='otchEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'\>";
	 table.rows[currow].cells[4].innerHTML = 
	 " <input type=button  id='delRow_"+i+"' name='delRow_"+i+"' value=''  class='delButton' onClick='deleteRowToTabla(this)'/>";
  }
}
//--------------------------------------------Добавляет новую строку--------------------------------------------
function addRowToTable2(){
	form1.addToBase.disabled=true;
	form1.addRow.disabled=true;  
	var table  = document.getElementById("tb1");
	var currow;	   
	currow = table.rows.length; 
	if(countRow==0)countRow=currow;
	else countRow++;
	table.insertRow(currow); // добавляем строку в таблицу
	table.rows[currow].insertCell(0); // добавляем ячейки
    table.rows[currow].insertCell(1);
    table.rows[currow].insertCell(2);
    table.rows[currow].insertCell(3);
    table.rows[currow].insertCell(4);
	// вставляем в форму поля
	i=currow-1;
   table.rows[currow].cells[0].innerHTML = 
	      "<input style='width:20px' type='text' id='number"+currow+"'  value='"+currow+"' readonly name='newStroka' \>";
    table.rows[currow].cells[1].innerHTML = 
	     "<input  type='text' style ='color:black' id='famEdit_"+i+"' name='famEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()' \>";
    table.rows[currow].cells[2].innerHTML = 
	    "<input  type='text' style ='color:black' id='imyaEdit_"+i+"' name='imyaEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'\>";
     table.rows[currow].cells[3].innerHTML = 
	 "<input  type='text' style ='color:black' id='otchEdit_"+i+"'  name='otchEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'\>";
	 table.rows[currow].cells[4].innerHTML = 
	 " <input type=button  id='delRow_"+i+"' class='delButton' name='delRow_"+i+"' value='' onClick='deleteRowToTabla(this)'/>";
	 var fam = "famEdit_"+i;
		document.getElementById(fam).focus();
}
function deleteRowToTabla(button){
	
   var numberPol = button.name.substring(7,button.name.length);
   var numberPol2=Number(numberPol);
   numberPol=Number(numberPol)+1;
/*  var request=null;
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
	var fam = 'famEdit_'+numberPol2;
	 fam = document.getElementById(fam).value;
	 var imya = 'imyaEdit_'+numberPol2;
	 imya = document.getElementById(imya).value;
	 var otch = 'otchEdit_'+numberPol2;
	otch = document.getElementById(otch).value;
	var pod = document.getElementById('Structurnoe_podrazdlenie').value;alert(pod);
	 alert(fam);
	 alert(imya);
	 alert(otch); 
	 alert("uio_queryOtvLicoFlag.php?fam="+fam+"&imya="+imya+"&otch="+otch+"&pod="+pod);
  request.open('GET', "uio_queryOtvLicoFlag.php?fam="+fam+"&imya="+imya+"&otch="+otch+"&pod="+pod,false);
  request.send(null);
  
  var flag=request.responseText;
  alert(flag);*/
   
   var num = 'number'+numberPol;
   var num = document.getElementById(num);
   if(error!=0)
   {
	  var numberEr=error.indexOf('_')+1;
	  erNumberPol = error.substring(numberEr,error.length);
	  var del = Number(erNumberPol)+1;
	  if(numberPol==del){ error=0; }
   }
   var table2  = document.getElementById("tb1");
   if(countRow==0) countRow=table2.rows.length;
   table2.deleteRow(num.value);  
   var currow = table2.rows.length;	
   var j=1;
   for(var i=1;i<=countRow;i++){
	   var i2=i;
	   var n="number"+i2;
	   try { 
	     var nn=document.getElementById(n);
		 nn.value=j;
		 j++;
	   } 
	   catch (e) { }
	   if(table2.rows.length ==1) {
		   document.form1.delRow.disabled=true;
		   form1.addToBase.disabled=false;
           form1.addRow.disabled=false;  
	   }
   }
   var table  = document.getElementById("tb1");
   var currow= table.rows.length; // вычислить количество строк в таблице
   for(var $o=0;$o<currow;$o++){
   try
   {
     var d = "famEdit_"+$o;
     document.getElementById(d).focus();
     document.getElementById(d).blur();
   }
   catch(e){}
}
}
</script>
</head>
<body>
<?php 
function Uchastnik($db){
	$pagetext = "<form  name = 'form1' method=POST action='".$_SERVER['PHP_SELF']."?nav=editUch' >
	
         <table border=1 width=500 height=30 id ='tb1' name='tb1' cellspacing='0'>
		 <tr class='backcol'>
		    <td width=5%>\</td>
		    <td width=30%>Фамилия</td>
			<td width=30%>Имя</td>
			<td swidth=30%>Отчества</td>
			<td swidth=30%>&nbsp</td>
		 </tr>";
		 
          $result2 = mysql_query('SELECT * FROM `Uchastnik_inv_komissii`',$db);
          $m = mysql_fetch_array($result2);
		  $i=0;
		  
          do{
			  $i2=$i+1;
             $pagetext = $pagetext . "<tr><td><input style='width:20px' type='text' id='number".$i2."'  value='$i2' readonly name='newStroka'\></td>".
			      "<td><input  type='text' id='famEdit_$i'  name='famEdit_$i' value='".$m['Familiya']."'  onBlur='errorEdit(this)' onkeyup='disEdit()'\></td>
				  <td><input  type='text'  id='imyaEdit_$i'  name='imyaEdit_$i' value='".$m['Imya']."'   onBlur='errorEdit(this)' onkeyup='disEdit()'\></td>
				  <td><input  type='text'  id='otchEdit_$i'  name='otchEdit_$i' value='".$m['Otchestvo']."'  onBlur='errorEdit(this)' onkeyup='disEdit()'\></td><td><input type=button  id='delRow_$i' name='delRow_$i' class='delButton' value=''  onClick='deleteRowToTabla(this)'/></td></tr>";
          $i++;
		  }
         while($m = mysql_fetch_array($result2)); 

     $pagetext =$pagetext."
		 </table>  
		 <div id='error' class = 'error'></div>  
		  <br>
		  <table >
		  <tr>
		    <td><div class = 'label' >Добавить новую строку:</div></td> 
		  	<td> <input type=button  name='addRow' value='' class='addButton'  onClick='addRowToTable2()'/></td>
		 </table>
		  
		 <input type=submit  name='addToBase' id='addToBase' class='okButton' value='Внести изменеия' />
	 	 </form>";
	return $pagetext;
}
?>
</body>