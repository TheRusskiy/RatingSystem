<?php
include_once('controllers/helpers.php');
require_once('router.php');
$router = new Router();
$out.=$router->execute();
?>