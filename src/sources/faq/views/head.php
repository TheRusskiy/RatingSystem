<?php
    if (isset($script)){
        $script = "<script src='/sources/faq/scripts/$script.js'></script>";
    } else {
        $script = "";
    }
    if (isset($style)){
        $style = "<link type='text/css' href='/sources/faq/styles/$style.css' rel='stylesheet'>";
    } else {
        $style = "";
    }
?>
<!doctype html>
<html>
<head>
<!-- FREAKING Windows 1251 ENCODING, screw u-->
    <meta http-equiv=Content-Type content='text/html; charset=UTF-8'>
  <title>Rating system</title>
<!--    <link type='text/css' href='/sources/faq/styles/reset.css' rel='stylesheet'>-->
    <link type='text/css' href='/sources/faq/bower_components/jquery-ui/themes/base/minified/jquery-ui.min.css' rel='stylesheet'>
    <link type='text/css' href='/sources/faq/bower_components/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link type='text/css' href='/sources/faq/styles/style.css' rel='stylesheet'>
    <link type='text/css' href='/sources/faq/styles/rating_system.css' rel='stylesheet'>
    <?= $style ?>
    <!--[if lt IE 9]>
    <script src="/sources/faq/bower_components/es5-shim/es5-shim.js"></script>
    <script src="/sources/faq/bower_components/json3/lib/json3.min.js"></script>
    <![endif]-->
    <script src="/sources/faq/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/sources/faq/bower_components/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="/sources/faq/bower_components/jquery-ui/ui/i18n/jquery.ui.datepicker-ru.js"></script>
    <script src="/sources/faq/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/sources/faq/scripts/rating_system.js"></script>
    <?= $script ?>
</head>