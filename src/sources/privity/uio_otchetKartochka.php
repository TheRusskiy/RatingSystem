<?php


include "core/skin.php";
include "uio_otchetiKartochkaForm.php";

 $Nomer_komnatiEdit=$_POST['Nomer_komnatiEdit'];
 $Nomer_korpusaEdit=$_POST['Nomer_korpusaEdit'];
if($_SESSION['user_id']=='2'){
 echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>   ��������&nbsp������������</a>",edit()."<br><a href='uio_otchetiKartochkaLoad.php?Nomer_komnatiEdit=".$Nomer_komnatiEdit."&Nomer_korpusaEdit=".$Nomer_korpusaEdit."'>������� �����</a>");
}
else {echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>".
"<br><a href='uio_otcheti.php'>������</a>",edit()."<br><a href='uio_otchetiKartochkaLoad.php?Nomer_komnatiEdit=".$Nomer_komnatiEdit."&Nomer_korpusaEdit=".$Nomer_korpusaEdit."'>������� �����</a>");
}


?>