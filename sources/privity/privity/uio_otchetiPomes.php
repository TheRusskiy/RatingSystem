<?php

include "uio_queryPomesheniya.php";
include "core/skin.php";
//$ww = add();
if($_SESSION['user_id']=='2'){
 echo fSkin ("Управление имущественными отношениями","<br><a href='uio_spravochniki.php'>   Введение&nbspсправочников</a>",Form());
}
else { echo fSkin ("Управление имущественными отношениями","<br><a href='uio_inventarizaciya.php'>Инвентаризация </a>"."<br><a href='uio_otcheti.php'>Отчеты</a>",Form());
}

//echo "<form method=POST>
  // <input type=submit name = 'Dobavit'value='aiai'>";
?>