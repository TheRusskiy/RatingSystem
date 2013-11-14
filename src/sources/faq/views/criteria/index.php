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
    <?php foreach ($teachers as $row) : ?>
        <tr>
            <td><?= $row["id"]; ?></td>
            <td><?= $row["name"]; ?></td>
            <td><?= $row["fetch_type"]; ?></td>
            <td><?= $row["fetch_value"]; ?></td>
            <td><?= $row["multiplier"]; ?></td>
            <td><?= $row["calculation_type"]; ?></td>
            <td><?= $row["year_limit"]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
On page: <?= count($teachers)?>
<br>
<?= pagination(href('teachers', 'index'), $page_count, $page) ?>