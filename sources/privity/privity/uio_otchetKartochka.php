<?php


include "core/skin.php";
include "uio_otchetiKartochkaForm.php";

 $Nomer_komnatiEdit=$_POST['Nomer_komnatiEdit'];
 $Nomer_korpusaEdit=$_POST['Nomer_korpusaEdit'];
if($_SESSION['user_id']=='2'){
 echo fSkin ("Управление имущественными отношениями","<br><a href='uio_spravochniki.php'>   Введение&nbspсправочников</a>",edit()."<br><a href='uio_otchetiKartochkaLoad.php?Nomer_komnatiEdit=".$Nomer_komnatiEdit."&Nomer_korpusaEdit=".$Nomer_korpusaEdit."'>Скачать отчет</a>");
}
else {echo fSkin ("Управление имущественными отношениями","<br><a href='uio_inventarizaciya.php'>Инвентаризация </a>".
"<br><a href='uio_otcheti.php'>Отчеты</a>",edit()."<br><a href='uio_otchetiKartochkaLoad.php?Nomer_komnatiEdit=".$Nomer_komnatiEdit."&Nomer_korpusaEdit=".$Nomer_korpusaEdit."'>Скачать отчет</a>");
}


?>