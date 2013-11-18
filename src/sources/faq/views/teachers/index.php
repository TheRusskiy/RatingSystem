<?= render('home/_date_range')?>
<div class="index">
    <table>
        <caption>Преподаватели</caption>
        <tr>
            <td>id</td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Действия</td>
        </tr>
        <?php foreach ($teachers as $row) : ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['surname']; ?></td>
                <td><?= link_for_teacher($row, 'Рейтинг'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div>На странице: <?= count($teachers)?></div>
<br/>
<?= pagination(href('teachers', 'index'), $page_count, $page) ?>