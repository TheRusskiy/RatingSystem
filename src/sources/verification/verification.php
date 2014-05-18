<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

Redirect('/sources/verification/views/index.html', false);
?>