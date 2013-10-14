<?php
//  include "core/skin.php";
//echo $_SERVER['REQUEST_URI'];
//if($_SESSION['user_id']=='2'){
  //  echo fSkin ("Управление имущественными отношениями","<br><a href='uio_spravochniki.php'>       Введение&nbspсправочников</a>","<br><a href='uio_add.php?buttonName=Добавить данные'>Добавить      помещение    </a>".   "<br><a href='uio_edit.php?buttonName=Внести изменения&r=edit'>Изменить данные о помещение</a>");
//}
//else {   echo fSkin ("Управление имущественными отношениями","<br><a href='uio_inventarizaciya.php'>Инвентаризация </a>"."<br><a href='uio_otcheti.php'>Отчеты</a>","<br><a href='uio_add.php?buttonName=Добавить данные'>Добавить      помещение    </a>".   "<br><a href='uio_edit.php?buttonName=Внести изменения&r=edit'>Изменить данные о помещение</a>");
//}
function inv()
{
return "<br><a href='".$_SERVER['PHP_SELF']."?nav=dob'>Добавить      помещение    </a>".   "<br><a href='".$_SERVER['PHP_SELF']."?nav=edit'>Изменить данные о помещение</a>";
}
 ?>