<?php
$user = session('user_name');
$notice = flash('notice');
$error = flash('error');
$logout = "";
function class_for($controller, $action){
    if (params('controller', 'home')==$controller && params('action', 'index')==$action){
        return 'active';
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
                    <li class="<?= class_for('teachers', 'total_rating')?>">
                        <a href='/?controller=teachers&action=total_rating'>Общий рейтинг</a>
                    </li>
                    <li class="<?= class_for('teachers', 'index')?>">
                        <a href='/?controller=teachers&action=index'>Преподаватели</a>
                    </li>
                    <li class="<?= class_for('home', 'help')?>">
                        <a href='/?controller=home&action=help'>Помощь</a>
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
<?php
 if (!isset($container_class)){
     $container_class = 'container';
 }
?>
<div class="<?= $container_class ?>">
<?php if($notice): ?>
    <div class='notice'><?= $notice?></div>
<?php endif ?>
<?php if($error): ?>
    <div class='error'><?= $error?></div>
<?php endif ?>