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
    <div class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span
                        class="icon-bar"></span>
                </button>
                <a href='/?controller=home&action=index' class="navbar-brand">
                    <img id="ssau-logo" src="sources/verification/images/ssaulogo.gif" alt="logo"/>
                    Рейтинг ППС
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="<?= class_for('home')?>">
                        <a href='/?controller=home&action=index'>Рейтинговая система</a>
                    </li>
                    <li class="<?= class_for('teachers')?>">
                        <a href='/?controller=teachers&action=index'>Преподаватели</a>
                    </li>
                    <li class="<?= class_for('criteria')?>">
                        <a href='/?controller=criteria&action=index'>Критерии</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href><?= $user?></a>
                    </li>
                    <li>
                        <a href='/?controller=sessions&action=logout'>Выйти</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
<?php if($notice): ?>
    <div class='notice'><?= $notice?></div>
<?php endif ?>
<?php if($error): ?>
    <div class='error'><?= $error?></div>
<?php endif ?>