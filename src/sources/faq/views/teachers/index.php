<table>
    <caption>Teachers</caption>
    <tr>
        <td>id</td>
        <td>shortname</td>
        <td>Actions</td>
    </tr>
    <?php foreach ($teachers as $row) : ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['shortname']; ?></td>
            <td><?= link_for_teacher($row); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
On page: <?= count($teachers)?>
<br>
<?= pagination(href('teachers', 'index'), $page_count, $page) ?>