<?php
$user = session('user_name');
$notice = flash('notice');
$error = flash('error');
$logout = "";
function class_for($controller){
    if (params('controller', 'home')==$controller){
        return 'current';
    } else { return ''; }
}
?>
<body>
<div class="header">
    <ul class = 'menu'>
        <li id='logo'><img src="sources/faq/images/ssaulogo.gif"/></li>
        <li class="<?= class_for('home')?>">
            <a href='/?controller=home&action=index'>Рейтинговая cистема</a>
        </li>
        <li class="<?= class_for('teachers')?>">
            <a href='/?controller=teachers&action=index'>Преподаватели</a>
        </li>
        <li class="<?= class_for('criteria')?>">
            <a href='/?controller=criteria&action=index'>Критерии</a>
        </li>
        <li>
            <b><?= $user?></b> |
            <a href='/?controller=sessions&action=logout'>Выйти</a>
        </li>
    </ul>
</div>
<div class="content">
<?php if($notice): ?>
    <div class='notice'><?= $notice?></div>
<?php endif ?>
<?php if($error): ?>
    <div class='error'><?= $error?></div>
<?php endif ?>