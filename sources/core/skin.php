<?php

function fSkin ($title,$menu,$maintext) {

$pagetext = "
<html>
  <head>
    <meta http-equiv=Content-Type content='text/html; charset=windows-1251'>
    <title>$title</title>
    <link type=text/css href=/styles/common.css rel=stylesheet>
  </head>
  <body bottommargin=0 leftmargin=0 rightmargin=0 topmargin=0 bgcolor=#FFFFFF>
<table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#7F99BE>
<tr>
<td rowspan=2 width=180 height=80 align=center valign=center><img src=/images/ssaulogo.gif width=120 height=60></td>
<td valign=center><h3 style='color:#ffffff'>Система мониторинга деятельности подразделений университета</h3></td>
</tr>
<tr>
<td valign=center><h3 style='color:#ffffff'>$title</h4></td>
<td align=left><a style='color:#ffffff;' href='?logout'>Выход</a></td>
</tr>
</table>
<br>
<div align=right><a href=".$_SERVER["REQUEST_URI"]."&print=1><img src=/images/print.png border=0> Версия для печати</a></div>
<center>
   <table width=98% height=80% border=0 cellpadding=0 cellspacing=0>
     <tr>
       <td width=120 valign='top' align='right'>
    $menu
       </td>
	
       <td width=10><img src=/images/blank.gif width=10></td> 
       <td width=1  bgcolor=#7F99BE><img src=/images/blank.gif width=1></td> 
       <td width=10><img src=/images/blank.gif width=10></td> 
       <td valign='top'>
        <br>
         $maintext
        <br>&nbsp;
       </td> 
     </tr>
   </table> 
</center>
</body>
</html>
";

return $pagetext;
}

function fSkinPrint ($title,$menu,$maintext) {

$pagetext = "
<html>
  <head>
    <meta http-equiv=Content-Type content='text/html; charset=windows-1251'>
    <title>$title</title>
    <link type=text/css href=/styles/quality.css rel=stylesheet>
  </head>
  <body bottommargin=0 leftmargin=0 rightmargin=0 topmargin=0 bgcolor=#FFFFFF>
<table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor=#7F99BE>
<tr>
<td rowspan=2 width=180 height=80 align=center valign=center><img src=/images/ssaulogo.gif width=120 height=60></td>
<td valign=center><h3 style='color:#ffffff'>Система мониторинга деятельности подразделений университета</h3></td>
</tr>
<tr>
<td valign=center><h3 style='color:#ffffff'>Отдел управления качеством</h4></td>
<td align=left><a style='color:#ffffff;' href='".ereg_replace("print=1","",$_SERVER["REQUEST_URI"])."'>Вернуться к полной версии отчета</a></td>
</tr>
</table>
<center>
	<h4>Версия для печати</h4>
   <table width=98% border=0 cellpadding=0 cellspacing=0>
     <tr>
       <td valign='top'>
         $maintext
        <br>
       </td> 
     </tr>
   </table> 
</center>
</body>
</html>
";

return $pagetext;
}

?>