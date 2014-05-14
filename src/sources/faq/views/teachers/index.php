<?php
    $initial_class = params('search') == null ? "" : 'x';
?>

<div id="search">
    <form action="/">
        <?= hidden_field('controller', 'teachers')?>
        <?= hidden_field('action', 'index')?>
        <input placeholder="Фамилия и/или имя" class="clearable <?=$initial_class?>" name="search" value="<?=params('search', '')?>"/>
        <input type="submit" value="Поиск"/>
    </form>
</div>
<div class="index">
    <table>
        <caption>Преподаватели</caption>
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
<div>На странице: <?= count($teachers)?></div>
<br/>
<?= pagination(href('teachers', 'index'), $page_count, $page, array('search'=>params('search'))) ?>