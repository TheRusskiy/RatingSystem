<div class="index">
    <table>
        <caption>Критерии</caption>
        <tr>
            <td>Id</td>
            <td>Название</td>
            <td>Способ вычисления</td>
            <td>Данные</td>
            <td>Множитель</td>
            <td>Метод оценки</td>
            <td>Лимит в год</td>
            <td>Дата создания критерия</td>
            <td>Действия</td>
        </tr>
        <?php foreach ($criteria as $cr) : ?>
            <tr>
                <td><div class="cell">
                    <?= $cr->id; ?>
                </div></td>
                <td><div class="cell">
                    <?= $cr->name; ?>
                </div></td>
                <td><div class="cell">
                    <?= $cr->fetch_type_to_string(); ?>
                </div></td>
                <td><div class="cell" title="<?=$cr->fetch_value?>">
                    <?= str_replace("\n", "</br>", $cr->fetch_value); ?>
                </div></td>
                <td><div class="cell">
                    <?= $cr->multiplier_to_string(); ?>
                </div></td>
                <td><div class="cell">
                    <?= $cr->calculation_type_to_string(); ?>
                </div></td>
                <td><div class="cell">
                    <?= $cr->year_limit; ?>
                </div></td>
                <td><div class="cell">
                    <?= $cr->creation_date; ?>
                </div></td>
                <td><div class="cell">
                    <?= url('Редактировать', href('criteria', 'edit', array('id'=>$cr->id))); ?>
                    <?= url('Удалить', href('criteria', 'delete', array('id'=>$cr->id))); ?>
                </div></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?= url('Новый критерий', href('criteria', 'new_criteria')); ?>
</div>
<div>На странице: <?= count($criteria)?></div>
<br/>
<?= pagination(href('criteria', 'index'), $page_count, $page) ?>
