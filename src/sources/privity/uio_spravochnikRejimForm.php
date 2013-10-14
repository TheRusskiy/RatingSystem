
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>Система мониторинга деятельности подразделения</font></title>
 <!-- <link type=text/css href=/styles/common.css rel=stylesheet>-->
 <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
  <style type='text/css'>
    @import url('styles/style.css');
  </style>
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



function disEdit(){
	form1.addToBase.disabled=true;
//	form1.addRow.disabled=true;
}

//--------------------------------------------Добавляет новую строку--------------------------------------------
function addRowToTable(){//alert(error);
var flag =false;
	if(countRow==0)countRow=document.getElementById("tb1").rows.length
	else countRow++;
	document.getElementById("count").value = countRow;
	var selected =  "C "+document.getElementById("Begin_hour").options[document.getElementById("Begin_hour").selectedIndex].text+":"+document.getElementById("Begin_minute").options[document.getElementById("Begin_minute").selectedIndex].text+" до "+document.getElementById("End_hour").options[document.getElementById("End_hour").selectedIndex].text+":"+document.getElementById("End_minute").options[document.getElementById("End_minute").selectedIndex].text;
	
	 for(var i=1;i<countRow;i++){
		try{
		   var i2=i-1;
		   var fam = "famEdit_"+i2;
		   fam=document.getElementById(fam);
		   if(selected==fam.value) {
			   flag=true;
			   document.getElementById('error').innerHTML="<error><div><i>Такой режим уже существует</i></div></error>";
			   break;
			 }
		  
		}
        catch(e){}
	}
	if(flag==false){
		 document.getElementById('error').innerHTML="";
	var table  = document.getElementById("tb1");
	var currow;	   
	currow = table.rows.length; 
//	if(countRow==0)countRow=currow;
	//else countRow++;
	table.insertRow(currow); // добавляем строку в таблицу
	table.rows[currow].insertCell(0); // добавляем ячейки
    table.rows[currow].insertCell(1);
    table.rows[currow].insertCell(2);
  	// вставляем в форму поля
	i=currow-1;
   table.rows[currow].cells[0].innerHTML = 
	      "<input style='width:20px' type='text' id='number"+currow+"'  value='"+currow+"' readonly name='newStroka' \>";
    table.rows[currow].cells[1].innerHTML = 
	     "<input  type='text' style ='color:black' id='famEdit_"+(countRow-1)+"' name='famEdit_"+(countRow-1)+"' readonly value='"+selected+"'\>";
   
	 table.rows[currow].cells[2].innerHTML = 
	 " <input type=button  id='delRow_"+(currow-1)+"' name='delRow_"+(currow-1)+"' value='' class='delButton' onClick='deleteRowToTabla(this)'/>";
	 var fam = "famEdit_"+i;
		document.getElementById(fam).focus();
		form1.addToBase.disabled=false;
	}
	
	
}
function deleteRowToTabla(button){
   var numberPol = button.name.substring(7,button.name.length);
   numberPol=Number(numberPol)+1;
   var num = 'number'+numberPol;
   var num = document.getElementById(num);
   alert(numberPol);
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
   document.getElementById("count").value = countRow;
}
</script>
</head>
<body>
<?php 
function rejim($db){
	$pagetext = "<form  name = 'form1' method=POST action='".$_SERVER['PHP_SELF']."?nav=editRejim'>
	            <table border=1 width=10 height=30 id ='tb1' name='tb1' cellspacing='0'>
		          <tr class='backcol'>
				    <td >\</td>
				    <td >Режим</td>
				    <td >&nbsp</td>
			     </tr>";
		          
				  $result2 = mysql_query('SELECT rejim FROM `Rejim_ispol` order by rejim',$db);
				  $m = mysql_fetch_array($result2);
				  $i=0;
				  $rows = mysql_num_rows($result2);
				 for($row = 0;$row<$rows;$row++){
					  $i2=$i+1;
                     $pagetext = $pagetext . "<tr><td><input  style ='width:20' type='text' id='number".$i2."' value='$i2' readonly name='newStroka'\></td>".
			     "<td><input  type='text' id='famEdit_$i'  readonly name='famEdit_$i'  value='".$m['rejim']."'  \></td>
				 <td><input type=button  id='delRow_$i' name='delRow_$i' value='' class='delButton'  onClick='deleteRowToTabla(this)'/></td></tr>";
                   $i++;
		           $m = mysql_fetch_array($result2);
		     }
       $pagetext =$pagetext."
		 </table>    
		  <br>
		  <table border=0 width=500 height=30 id ='tb1' name='tb1'>
		  <tr>Добавить новый режим
		  <td> С </td>
		  <td><select class='input'  type=text  name='Begin_hour'  id='Begin_hour' >";
	      for($j = 0;$j<24;$j++){
             $pagetext = $pagetext . '<option  value='.$j.'>'.$j.'</option>'; 
          }
         $pagetext =$pagetext. " </select></td>
	     <td> часов </td>
	     <td><select class='input'  type=text  name='Begin_minute'  id='Begin_minute' >";
	     for($j = 0;$j<60;$j++){
           $pagetext = $pagetext . '<option  value='.$j.'>'.$j.'</option>'; 
          }
         $pagetext =$pagetext. " </select></td>
	     <td> минут </td>
	     <td> до</td>
		 <td><select class='input'  type=text  name='End_hour'  id='End_hour' >";
	     for($j = 0;$j<24;$j++){
             $pagetext = $pagetext . '<option  value='.$j.'>'.$j.'</option>'; 
          }
        $pagetext =$pagetext. " </select></td>
	    <td> часов </td>
	    <td><select class='input'  type=text  name='End_minute'  id='End_minute' >";
	   for($j = 0;$j<60;$j++){
         $pagetext = $pagetext . '<option  value='.$j.'>'.$j.'</option>'; 
        }
      $pagetext =$pagetext. " </select></td>
	  <td> минут </td>
	  <td><input type=button  name='addRow' value='' class='addButton' onClick='addRowToTable()'/><td/>
	  <tr><div id='error'></div></tr>
	  <input name='count' id='count' type='hidden' value=''>
	  </table>
		  <br>
		  
		 <input type=submit   class='okButton' name='addToBase' id='addToBase' value='Внести изменеия' />
	 	 </form>";
	return $pagetext;
}
?>
</body>