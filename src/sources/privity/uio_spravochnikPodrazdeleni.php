<?php
include "core/skin.php";
include "uio_SpravochnikPodForm.php";
 echo fSkin ("Управление имущественными отношениями","<br><a href='uio_inventarizaciya.php'>Инвентаризация </a>"."<br><a href='uio_spravochniki.php'>   Введение&nbspсправочников</a>".
"<br><a href='uio_otcheti.php'>Отчеты</a>",Podrazdeleniya());
?>