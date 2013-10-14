
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
   <title>Система мониторинга деятельности подразделения</font></title>
 <!-- <link type=text/css href=/styles/common.css rel=stylesheet>-->
   <link rel="stylesheet" type="text/css" href="sources//privity//styles//style.css">
   
 <script  type="text/javascript" src="sources//privity//jquery-1.5.1.js"></script>

  <script language='JavaScript' src="sources//privity//Spravochniki.js"></script>
<script>
$(document).ready(function(){
	
// $(".table tr").hover(
//   function () {
//	$(this).addClass("tr_hover");
	
//	},
 //  function (){
	// $(this).removeClass("tr_hover");
 //  }
 //  );

   
   
});
</script>
</head>
<body>
<?php 
function spForm($db){
	$button = $_POST['button'];
	$table = $_POST['table'];
	$col = $_POST['col'];
	$nav = $_POST['nextNav'];
	$nameTable = $_POST['nameTable'];
	$pagetext = "<form  name = 'form1' method=POST action='".$_SERVER['PHP_SELF']."?nav=$nav' >
	            <table border=1 width=340 height=30 id ='tb1' name='tb1' cellspacing='0'  >
		          <tr class='backcol'>
				    <td style='width:20px'  class='mytable'>\</td>
				    <td style='width:300px'  class='mytable'>$nameTable</td>
				    <td   class='mytable'>&nbsp</td>
			     </tr>";
		          
				  $result2 = mysql_query("SELECT $col FROM `".$table."` order by $col",$db);
				  $m = mysql_fetch_array($result2);
				  $i=0;
				  $rows = mysql_num_rows($result2);
				 for($row = 0;$row<$rows;$row++){
					  $i2=$i+1;
                     $pagetext = $pagetext . "<tr><td  class='mytr'><input     style ='width:20px;' type='text' id='number".$i2."' value='$i2' readonly name='newStroka'\></td>".
			     "<td  class='mytr'><input  type='text' style='width:300px'  id='famEdit_$i'   name='famEdit_$i'  value='".$m[$col]."'  \></td>
				 <td  class='mytr'>
				 <input  class='delButton' type=button  id='delRow_$i' name='delRow_$i' value=''  onClick='deleteRowToTabla(this)'/></td></tr>";
                   $i++;
		           $m = mysql_fetch_array($result2);
		     }
       $pagetext =$pagetext."
		 </table>    
		  <br>
		  <table border=0 width=500 height=30 id ='tb1' name='tb1'>
		  <tr>$button
		  <td><input type=new  name='new' id='new'/>
	 
	  <input type=button  name='addRow' class = 'addButton' value='' onClick='addRowToTable()'/><td/>
	  <tr><div id='error' class = 'error'></div></tr>
	  <input name='count' id='count' type='hidden' value=''>
	  <script>
	  document.getElementById('count').value ='$rows'
	  </script>
	  </table>
		  <br>
		  
		 <input type=submit  name='addToBase' id='addToBase' class='okButton' value='Внести изменеия' />
	 	 </form>";
	return $pagetext;
}
?>
</body>