<?php
  include "core/skin.php";
include "editForm.php";
if($_SESSION['user_id']=='2'){
    echo fSkin ("���������� �������������� �����������","<br><a href='uio_spravochniki.php'>       ��������&nbsp������������</a>",edit());
}
else {  echo fSkin ("���������� �������������� �����������","<br><a href='uio_inventarizaciya.php'>�������������� </a>"."<br><a href='uio_otcheti.php'>������</a>",edit());
}
 ?>

