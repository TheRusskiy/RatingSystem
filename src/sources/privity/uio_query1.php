<?php include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
	$result2 = mysql_query('SELECT * FROM `Korpus` ',$db);
    $m = mysql_fetch_array($result2);
	 do{
           $base[]=$m['Adres_zdaniya']; 
		   }
     while($m = mysql_fetch_array($result2));
	 $users_array = array("Sergey", "Andrey", "Irina");?>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251' />
    <title>?????????? ???????????? ????????????? ????????????</font></title>
  <link type=text/css href=/styles/common.css rel=stylesheet>
  <script language='JavaScript'>
<!-- hide
function calculation() {
  www = document.form1.pomeshenie.selectedIndex;
  www = www + 1;
  
  var n=new Array();
  <?
    foreach($base as $id=>$value) echo "n[$id] = '$value'; ";
  ?>

alert(n[1]);
}

// -->
</script>
</head>
<body>
<?php
include "core/skin.php";
function query(){
$pagetext = "
<form name='form1' metod=POST action = 'uio_query1_form.php'>  
  <table border=0 width=100% height=100 >
  <tr>
    <td width='60'></td>
    <td width='10'></td>
  </tr>
  <tr>
    <td width='120'>Выберите корпус</td>
	<td>
      <select name='pomeshenie' ONCHANGE='calculation()'>   >";
	   include $_SERVER["DOCUMENT_ROOT"]."/config.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
  mysql_select_db($CONFS['sql_database'] ,$db);
	   $result2 = mysql_query('SELECT * FROM `Korpus` ',$db);
       $m = mysql_fetch_array($result2);
	   do{
           $pagetext =$pagetext. '<option value='.$m['Nomer_korpusa'].'>'.$m['Nomer_korpusa'].'</option>'; 
       }
       while($m = mysql_fetch_array($result2));
	  
       $pagetext =$pagetext."  </select>
     </td>
	 <td>
	 </td>
   <td>
     <input type=submit  name = 'query' value='Вывести инвентаризационную карточку помещения' />
   </td>
 </tr>
 </table>
 </form>";	
 return $pagetext;
}
echo fSkin ("Управление имущественными отношениями","<br><a href='uio_add.php?buttonName=Добавить данные'>Добавить помещение </a>"."<br><a href='uio_edit.php?buttonName=Внести изменения'>Редактировать</a>"."<br><a href='uio_query1.php'>Карточка инвентаризации помещения</a>",query());
?>
</body>
</html>

