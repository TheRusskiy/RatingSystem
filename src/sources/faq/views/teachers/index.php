<?php
    $initial_class = params('search') == null ? "" : 'x';
?>

<div class="row">
    <div id="search" class="pull-right">
        <form action="/">
            <?= hidden_field('controller', 'teachers')?>
            <?= hidden_field('action', 'index')?>
            <input placeholder="Фамилия и/или имя" class="clearable <?=$initial_class?>" name="search" value="<?=params('search', '')?>"/>
            <input type="submit" value="Поиск"/>
        </form>
    </div>
</div>
<div class="row">
    <table class="table table-bordered">
        <h4>Преподаватели</h4>
        <tr>
            <td>id</td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Кафедра</td>
            <td>Рейтинг</td>
        </tr>
        <?php foreach ($teachers as $t) : ?>
            <tr>
                <td><div class="cell">
                    <?= $t['id']?>
                </div></td>
                <td><div class="cell">
                    <?= $t['name']; ?>
                </div></td>
                <td><div class="cell">
                    <?= $t['surname']; ?>
                </div></td>
                <td><div class="cell">
                    <?= $t['department']; ?>
                </div></td>
                <td><div class="cell">
                    <?= link_for_teacher($t, 'Просмотреть'); ?>
                </div></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">На странице: <?= count($teachers)?></div>
        <div class="pull-left">
            <?= pagination(href('teachers', 'index'), $page_count, $page, array('search'=>params('search'))) ?>
        </div>
    </div>
</div>