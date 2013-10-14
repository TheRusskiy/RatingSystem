
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
		   
		  
		  
	}
	catch(e){}
	}
	
	return result;
	
}
function controlNumber(edit){
	var flag=true;
	return flag;
}
//---------------------------------------------Контроль ввода фамилий,имен,отчеств----------------------------------
function control(edit){
	var flag=false;
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
				  
				   document.getElementById(fam).style.color = 'red';
				  
				   
				   form1.addToBase.disabled=true;
				   form1.addRow.disabled=true;
				  
				   document.getElementById(edit.name).focus();
				 }
				else {
					
				  error=0;
				  
				  edit.style.color = 'black';
	      
				  var fam = 'famEdit_'+numberPol;
				 
				  fam=document.getElementById(fam);
				 
				  form1.addToBase.disabled=false;
				  form1.addRow.disabled=false;
				  if(control(fam)==false)fam.style.color='black';
				 
				 
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
	document.getElementById('error').innerHTML="<error><div><i>Такой арендатор уже существует</i></div></error>"}

}

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
  
   if((famEditG.value.length>0)){
	 for(var i=1;i<=countRow;i++){
	   try{
		 var i2=i-1;
		 var fam = "famEdit_"+i2;//alert(fam);
		 var famEdit = document.getElementById(fam);
		 if((famEditG.value == famEdit.value)) {count++;}
	   }
		 catch(e){}
	 }
   }
   if(count>1){flag=true; document.getElementById('error').innerHTML="<error><div><i>Такой арендатор уже существует</i></div></error>";   }
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
	   
			 if((famEditG.value == famEdit.value)) {count++;}
			
		   if(count>1){flag=true;form1.addToBase.disabled=true;}
		   if(count==1){
			
			 otchEditG.style.color='black';
		
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




function disEdit(){
	form1.addToBase.disabled=true;
	form1.addRow.disabled=true;
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
	      "<input style='width:20px;height:90px;' type='text' id='number"+currow+"'  value='"+currow+"' readonly name='newStroka' \>";
    table.rows[currow].cells[1].innerHTML = 
	     "<textarea  type='text' style ='color:black;height:90px;width:200px;' id='famEdit_"+i+"' name='famEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()' ></textarea>";
    table.rows[currow].cells[2].innerHTML = 
	    "<textarea  type='text' style ='color:black;height:90px;width:200px;' id='imyaEdit_"+i+"' name='imyaEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'></textarea>";
     table.rows[currow].cells[3].innerHTML = 
	 "<textarea  type='text' style ='color:black;height:90px;width:200px;' id='otchEdit_"+i+"'  name='otchEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'></textarea>";
	 table.rows[currow].cells[4].innerHTML = 
	 " <input type=button  id='delRow_"+i+"' class='delButton' name='delRow_"+i+"' value='' onClick='deleteRowToTabla(this)'/>";
	 var fam = "famEdit_"+i;
		document.getElementById(fam).focus();
}
function deleteRowToTabla(button){
	
   var numberPol = button.name.substring(7,button.name.length);
   var numberPol2=Number(numberPol);
   numberPol=Number(numberPol)+1;
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
function spArenda($db){
	$pagetext = "<form  name = 'form1' method=POST action='".$_SERVER['PHP_SELF']."?nav=editArenda' >
	
         <table border=1 width=500 height=30 id ='tb1' name='tb1' cellspacing='0'>
		 <tr class='backcol'>
		    <td width=5%>\</td>
		    <td width=30%>Название</td>
			<td width=30%>Адрес</td>
			<td swidth=30%>Реквизиты</td>
			<td swidth=30%>&nbsp</td>
		 </tr>";
		 
          $result2 = mysql_query('SELECT * FROM `Arendatory`',$db);
          $m = mysql_fetch_array($result2);
		  $i=0;
		  
          do{
			  $i2=$i+1;
             $pagetext = $pagetext . "<tr><td><input style='height:90px;width:20px;' type='text' id='number".$i2."'  value='$i2' readonly name='newStroka'\></td>".
			      "<td><textarea style='height:90px;width:200px;'  id='famEdit_$i'  name='famEdit_$i'   onBlur='errorEdit(this)' onkeyup='disEdit()'>".$m['Nazvanie']."</textarea></td>
				  <td><textarea  style='height:90px;width:200px;'   id='imyaEdit_$i'  name='imyaEdit_$i'    onBlur='errorEdit(this)' onkeyup='disEdit()'>".$m['Adres']."</textarea></td>
				  <td><textarea  style='height:90px;width:200px;'  id='otchEdit_$i'  name='otchEdit_$i'   onBlur='errorEdit(this)' onkeyup='disEdit()'>".$m['Rekviziti']."</textarea></td><td><input type=button  id='delRow_$i' name='delRow_$i' class='delButton' value=''  onClick='deleteRowToTabla(this)'/></td></tr>";
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