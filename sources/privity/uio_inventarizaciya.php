<?php
//  include "core/skin.php";
//echo $_SERVER['REQUEST_URI'];
//if($_SESSION['user_id']=='2'){
  //  echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>       ��������&nbsp������������</a>","<br><a href='uio_add.php?buttonName=�������� ������'>��������      ���������    </a>".   "<br><a href='uio_edit.php?buttonName=������ ���������&r=edit'>�������� ������ � ���������</a>");
//}
//else {   echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>"."<br><a href='uio_otcheti.php'>������</a>","<br><a href='uio_add.php?buttonName=�������� ������'>��������      ���������    </a>".   "<br><a href='uio_edit.php?buttonName=������ ���������&r=edit'>�������� ������ � ���������</a>");
//}
function inv()
{
return "<br><a href='".$_SERVER['PHP_SELF']."?nav=dob'>��������      ���������    </a>".   "<br><a href='".$_SERVER['PHP_SELF']."?nav=edit'>�������� ������ � ���������</a>";
}
 ?>