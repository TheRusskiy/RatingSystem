<?php
function require_all ($path) {
    $files = glob(dirname(__FILE__)."/".$path.'/*.php');
    foreach ($files as $filename){
        require_once $filename;
    }
}

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../core/functions.php");
connect_db();

require_all('controllers');
require_all('dao');
require_all('models');



//include_once('helpers.php');
include_once('controllers/helpers.php');
//include_once('views/helpers.php');
require_once('router.php');
$router = new Router();
?>
<?= $router->execute(); ?>