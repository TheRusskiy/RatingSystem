<?php
$user = session('user_name');
$notice = flash('notice');
$error = flash('error');
$logout = "";
?>
<!DOCTYPE html>
<html>
<head>
<!-- FREAKING Windows 1251 ENCODING, screw u-->
    <meta http-equiv=Content-Type content='text/html; charset=UTF-8'>
  <title>Rating system</title>
  <link type='text/css' href='/sources/styles/rating_system.css' rel='stylesheet'>
</head>
<header>
    <ul class = 'menu'>
        <li><a href='/?controller=home&action=index'>Рейтинговая cистема</a></li>
        <li><a href='/?controller=teachers&action=index'>Преподаватели</a></li>
        <li><a href='/?controller=criteria&action=index'>Критерии</a></li>
        <li>
            <b><?php $user?></b>
            <a href='/?controller=sessions&action=logout'>Выйти</a>
        </li>
    </ul>
</header>
<div class='notice'><?php $notice?></div>
<div class='error'><?php $error?></div>
<body>