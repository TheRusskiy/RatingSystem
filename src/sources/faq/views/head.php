<?php
$user = session('user_name');
$notice = flash('notice');
$error = flash('error');
$logout = "";

?>
<!doctype html>
<html>
<head>
<!-- FREAKING Windows 1251 ENCODING, screw u-->
    <meta http-equiv=Content-Type content='text/html; charset=UTF-8'>
  <title>Rating system</title>
    <link type='text/css' href='/sources/styles/reset.css' rel='stylesheet'>
    <link type='text/css' href='/sources/styles/style.css' rel='stylesheet'>
    <link type='text/css' href='/sources/styles/rating_system.css' rel='stylesheet'>
    <!--[if lt IE 9]>
    <script src="/sources/js/html5shiv.js"></script>
    <script src="/sources/js/html5shiv-printshiv.js"></script>
    <![endif]-->
    <script src="/sources/js/jquery-1.9.1.min.js"></script>
    <script src="/sources/js/modernizr-2.6.3.custom.js"></script>
</head>

<body>
<div class="header">
    <ul class = 'menu'>
        <li><a href='/?controller=home&action=index'>Рейтинговая cистема</a></li>
        <li><a href='/?controller=teachers&action=index'>Преподаватели</a></li>
        <li><a href='/?controller=criteria&action=index'>Критерии</a></li>
        <li>
            <b><?= $user?></b>
            <a href='/?controller=sessions&action=logout'>Выйти</a>
        </li>
    </ul>
    <div class='notice'><?= $notice?></div>
    <div class='error'><?= $error?></div>
<div>