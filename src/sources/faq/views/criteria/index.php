<table>
    <caption>Criteria</caption>
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Fetch type</td>
        <td>Fetch value</td>
        <td>Multiplier</td>
        <td>Calculation type</td>
        <td>Year limit</td>
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
On page: <?= count($criteria)?>
<br>
<?= pagination(href('criteria', 'index'), $page_count, $page) ?>