<?php

include "uio_add_form2.php";
include "core/skin.php";
if($_SESSION['user_id']=='2'){
 echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>   ��������&nbsp������������</a>",add());
}
else { echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>"."<br><a href='uio_otcheti.php'>������</a>",add());
}

?>
