<?php
  include "core/skin.php";
include "editForm.php";
if($_SESSION['user_id']=='2'){
    echo fSkin ("Управление имущественными отношениями","<br><a href='uio_spravochniki.php'>       Введение&nbspсправочников</a>",edit());
}
else {  echo fSkin ("Управление имущественными отношениями","<br><a href='uio_inventarizaciya.php'>Инвентаризация </a>"."<br><a href='uio_otcheti.php'>Отчеты</a>",edit());
}
 ?>

