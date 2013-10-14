
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
if(document.getElementById("new").value!=""){

	if(countRow==0)countRow=document.getElementById("tb1").rows.length
	else countRow++;
	document.getElementById("count").value = countRow;
	var selected =  document.getElementById("new").value;
	
	 for(var i=1;i<countRow;i++){
		try{
		   var i2=i-1;
		   var fam = "famEdit_"+i2;
		   fam=document.getElementById(fam);
		   if(selected==fam.value) {
			   flag=true;
			   document.getElementById('error').innerHTML="<error><div><i>Такой значение уже существует</i></div></error>";
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
	      "<input style='width:20px' type='text' id='number"+currow+"'  value='"+currow+"' style='width:30px' readonly name='newStroka' \>";
    table.rows[currow].cells[1].innerHTML = 
	     "<input  type='text' style ='color:black;width:300px' id='famEdit_"+(countRow-1)+"'  name='famEdit_"+(countRow-1)+"' readonly value='"+selected+"'\>";
   
	 table.rows[currow].cells[2].innerHTML = 
	 " <input type=button  id='delRow_"+(countRow-1)+"' class='delButton' name='delRow_"+(countRow-1)+"' value='' onClick='deleteRowToTabla(this)'/>";
	 var fam = "famEdit_"+i;
		document.getElementById(fam).focus();
		form1.addToBase.disabled=false;
		table.rows[currow].cells[0].className = 'mytr';
		table.rows[currow].cells[1].className = 'mytr';
		table.rows[currow].cells[2].className = 'mytr';
	}
}else document.getElementById('error').innerHTML="<error><div><i>Нельзя добавить пустое значение</i></div></error>";


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
   document.getElementById("count").value = countRow;
}
