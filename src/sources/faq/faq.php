<?php
$out.= "Вы подключились к рабочему месту Факультет!";
$router = new Router();
$out.=$router->controller->render();
//$out.=include("controllers/$controller");
?>