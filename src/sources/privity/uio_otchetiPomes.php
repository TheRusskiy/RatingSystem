<?php

include "uio_queryPomesheniya.php";
include "core/skin.php";
//$ww = add();
if($_SESSION['user_id']=='2'){
 echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>   ��������&nbsp������������</a>",Form());
}
else { echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>"."<br><a href='uio_otcheti.php'>������</a>",Form());
}

//echo "<form method=POST>
  // <input type=submit name = 'Dobavit'value='aiai'>";
?>