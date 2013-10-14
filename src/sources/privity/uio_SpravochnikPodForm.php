
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>Система мониторинга деятельности подразделения</font></title>
  <link type=text/css href=/styles/common.css rel=stylesheet>
   <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
  <script language='JavaScript' >
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
	for(var i=1;i<countRow;i++){
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
	if((edit.value[i]=='1')||(edit.value[i]=='2')||(edit.value[i]=='3')||(edit.value[i]=='4')||(edit.value[i]=='5')||(edit.value[i]=='6')||(edit.value[i]=='7')||(edit.value[i]=='8')||(edit.value[i]=='9')||(edit.value[i]=='0')) flag=false;
	 else {flag=true;break;}
    }
	/*if(flag==false) {
		edit.style.color='red';
		document.form1.delRow.disabled=true;
                                  
	}
	else{
		document.form1.delRow.disabled=false;
		edit.style.color='black';
                                  
	}*/
   if(flag)  
       document.getElementById("div_ErrorAdd").innerHTML=" <div  style='font-size:12'><i>Можно вводить только числа</i></div>";
	   else 
	      document.getElementById("div_ErrorAdd").innerHTML="";
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
              if(flag) 
			      document.getElementById("div_ErrorAdd").innerHTML=" <div  style='font-size:12'><i>Вводить можно только буквы</i></div>";
				  else
				   
			      document.getElementById("div_ErrorAdd").innerHTML="";;
	return flag;
}

function errorEdit22(edit) {//alert(error);
	  var name = edit.name;
	  var number=name.indexOf('_')+1;
	  var numberPol = name.substring(number,edit.length);
	  if((error==edit.name)||(error==0)){
		 if(edit.value.length!=0){
			flag=control(edit);
			if(flag){ 
			  error = edit.name;
			  
			  document.getElementById(edit.name).focus();
			  edit.style.color = 'red';
			 // form1.addToBase.disabled=true;
			//  form1.addRow.disabled=true;
			  
			}
			else {
			error=0;
			edit.style.color = 'black';
			form1.addRow.disabled=false;
			form1.addToBase.disabled=false;
			}
		}
		else error=edit.name;
	  }
	  else  document.getElementById(error).focus();
	

}
function errorEdit222(edit) {//alert(error);
	  var name = edit.name;
	  var number=name.indexOf('_')+1;
	  var numberPol = name.substring(number,edit.length);
	//  alert(error);
	  if((error==edit.name)||(error==0)){
		  if(edit.value.length!=0){
			flag=controlNumber(edit);
			if(flag){ 
			  error = edit.name;
			  
			  document.getElementById(edit.name).focus();
			  edit.style.color = 'red';
			//  form1.addToBase.disabled=true;
			//  form1.addRow.disabled=true;
			  
			}
			else {
			error=0;
			edit.style.color = 'black';
			form1.addRow.disabled=false;
			form1.addToBase.disabled=false;
			}
		  }
			else error=edit.name;
			
	}
	else  document.getElementById(error).focus();

}

function errorEditNew(edit)
{
  if((error==edit.name)||(error==0)){
	form1.addRow.disabled=true;
	errorEdit22(edit);
	if(error==0){
		if(document.getElementById("otchEditNew").value.length!=0)
		{
			form1.addRow.disabled=false;
		}
	    else
		{
		  form1.addRow.disabled=true;
		  document.getElementById(error).focus();
		}
	}
  } 
}
function errorEditNumberNew(edit){
	 if((error==edit.name)||(error==0)){
	form1.addRow.disabled=true;
	errorEdit222(edit);
	if(error==0){
		if(document.getElementById("imyaEditNew").value.length!=0){form1.addRow.disabled=false;}
		else form1.addRow.disabled=true;
		}
	 }
	 else  document.getElementById(error).focus();
	
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
   if(count>1){
	   flag=true;
	   document.getElementById("div_ErrorAdd").innerHTML="<div  style='font-size:12'><i>Такое подразделение уже существует</i></div>";
	}
   else
   document.getElementById("div_ErrorAdd").innerHTML="";
	

   return flag;
}


function disEdit(){
	form1.addToBase.disabled=true;
//	form1.addRow.disabled=true;
}

//--------------------------------------------Добавляет новую строку--------------------------------------------
function addRowToTable2(){//alert('error');
var flag =false;
	if(countRow==0)countRow=document.getElementById("tb1").rows.length
	else countRow++;
	var selected =  document.getElementById("Structurnoe_podrazdlenie").options[document.getElementById("Structurnoe_podrazdlenie").selectedIndex].text;
	 for(var i=1;i<countRow;i++){
		try{
		   var i2=i-1;
		   var fam = "famEdit_"+i2;
		   fam=document.getElementById(fam);
		   if(selected==fam.value) {flag=true;
		   document.getElementById('div_ErrorAdd').innerHTML="<error><div><i>Такое подразделение уже существует</i></div></error>";break;}
		   else {document.getElementById('div_ErrorAdd').innerHTML="";}
		  
		}
	    catch(e){}
	}
	if((document.getElementById("imyaEditNew").value.length!=0)&&(document.getElementById("otchEditNew").value.length!=0)&&(flag==false)){
		var podrazdelenie = document.getElementById("Structurnoe_podrazdlenie").options[document.getElementById("Structurnoe_podrazdlenie").selectedIndex].text;
	var table  = document.getElementById("tb1");
	var currow;	   
	currow = table.rows.length; 
//	if(countRow==0)countRow=currow;
	//else countRow++;
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
	     "<input  type='text' style ='color:black;width:280px' id='famEdit_"+i+"' name='famEdit_"+i+"' readonly value='"+podrazdelenie+"'\>";
    table.rows[currow].cells[2].innerHTML = 
	    "<input  type='text' style ='color:black;width:280px' id='imyaEdit_"+i+"' value='"+document.getElementById("imyaEditNew").value+"' name='imyaEdit_"+i+"' onBlur='errorEdit(this)' onkeyup='disEdit()'\>";
     table.rows[currow].cells[3].innerHTML = 
	 "<input  type='text' style ='color:black;width:140px' id='otchEdit_"+i+"'  value='"+document.getElementById("otchEditNew").value+"' name='otchEdit_"+i+"' onBlur='errorEditNumberNew(this)' onkeyup='disEdit()'\>";
	 table.rows[currow].cells[4].innerHTML = 
	 " <input type=button  id='delRow_"+i+"' name='delRow_"+i+"' value='' class='delButton'onClick='deleteRowToTabla(this)'/>";
	 var fam = "famEdit_"+i;
		document.getElementById(fam).focus();
		form1.addToBase.disabled=false;
		 table.rows[currow].cells[0].className = 'mytr';
		table.rows[currow].cells[1].className = 'mytr';
		table.rows[currow].cells[2].className = 'mytr';
		table.rows[currow].cells[3].className = 'mytr';
		table.rows[currow].cells[4].className = 'mytr';
	}
}
function deleteRowToTabla(button){
  
   var numberPol = button.name.substring(7,button.name.length);
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
           
	   }
   }
}

  </script>
</head>
<body>
<?php 
function podrazdeleniya($db){
	$pagetext = "<form  name = 'form1' method=POST  action='".$_SERVER['PHP_SELF']."?nav=editPod'>
	
         <table border=1 width=750 height=30 id ='tb1' name='tb1' cellspacing='0'>
		 <tr class='backcol'>
		    <td width=20>\</td>
		    <td width=280>Название&nbsp;подразделения</td>
			<td width=280>Руководитель</td>
			<td swidth=140>Телефон</td>
			<td swidth=70>&nbsp</td>
		 </tr>";
		
          $result2 = mysql_query('SELECT * FROM `Structurnoe_podrazdelenie`',$db);
          $m = mysql_fetch_array($result2);
		  $i=0;
		  
          do{
			  $i2=$i+1;
             $pagetext = $pagetext . "<tr><td class='mytr'><input style='width:20px' type='text' id='number".$i2."'  value='$i2' readonly name='newStroka'\></td>".
			      "<td class='mytr'><input  style='width:280px' type='text' id='famEdit_$i'  readonly name='famEdit_$i' value='".$m['Nazvanie_podrazdeleniya']."'  \></td>
				  <td class='mytr'> <input  type='text'  style='width:280px' id='imyaEdit_$i'  name='imyaEdit_$i' value='".$m['Rukovoditel']."'   onBlur='errorEdit22(this)' onkeyup='disEdit()'\></td>
				  <td class='mytr'><input  type='text'  style='width:140px' id='otchEdit_$i'  name='otchEdit_$i' value='".$m['telephon']."'  onBlur='errorEdit222(this)' onkeyup='disEdit()'\></td><td><input class='delButton' type=button  id='delRow_$i' name='delRow_$i' value=''  onClick='deleteRowToTabla(this)'/></td></tr>";
          $i++;
		  }
         while($m = mysql_fetch_array($result2)); 

     $pagetext =$pagetext."
		 </table> 
		  <div id='div_ErrorTable' style='color:red'></div>   
		  <br>
		  <table border=0 width=500 height=30 id ='tb1' name='tb1'>
		 <tr>
		 <td> <select class='input'  type=text style='width: 200px;' name='Structurnoe_podrazdlenie' width=10% id='Structurnoe_podrazdlenie' >";
	    
          $result2 = mysql_query('SELECT * FROM `dep` ',$db);
          $m = mysql_fetch_array($result2);
          do{
             $pagetext = $pagetext . '<option  value='.$m['id'].'>'.$m['name'].'</option>'; 
          }
         while($m = mysql_fetch_array($result2)); 

     $pagetext =$pagetext. " </select></td>
	 <td><td class='mytr'><input  type='text'  id='imyaEditNew'  name='imyaEditNew' value='".$m['Rukovoditel']."'   onBlur='errorEditNew(this)' \></td></td>
	 <td><td class='mytr'><input  type='text'  id='otchEditNew'  name='otchEditNew' value='".$m['telephon']."'  onBlur='errorEditNumberNew(this)' \></td>
	 <td class='mytr'><input type=button  name='addRow' value='' class='addButton'  disabled onClick='addRowToTable2()'/><td/>
	 </table>
	 <div id='div_ErrorAdd' style='color:red'></div>
		  <br>
		  <br>
		  <br>
		 <input type=submit class='okButton'  name='addToBase' id='addToBase' value='Внести изменеия' />
	 	 </form>";
	return $pagetext;
}
?>
</body>