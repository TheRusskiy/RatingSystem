<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('helpers.php');
include_once('controllers/helpers.php');
include_once('views/helpers.php');
require_once('router.php');
$router = new Router();
$out.=$router->execute();
?>