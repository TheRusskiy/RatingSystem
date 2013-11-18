<div class="index">
    <table>
        <caption>Criteria</caption>
        <tr>
            <td>Id</td>
            <td>Название</td>
            <td>Способ вычисление</td>
            <td>Данные</td>
            <td>Множитель</td>
            <td>Метод оценки</td>
            <td>Лимит в год</td>
        </tr>
        <?php foreach ($criteria as $cr) : ?>
            <tr>
                <td><?= $cr->id; ?></td>
                <td><?= $cr->name; ?></td>
                <td><?= $cr->fetch_type; ?></td>
                <td><?= str_replace("\n", "</br>", $cr->fetch_value); ?></td>
                <td><?= $cr->multiplier_to_string(); ?></td>
                <td><?= $cr->calculation_type; ?></td>
                <td><?= $cr->year_limit; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div>На странице: <?= count($criteria)?></div>
<br/>
<?= pagination(href('criteria', 'index'), $page_count, $page) ?>
