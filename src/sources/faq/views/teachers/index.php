<table>
    <caption>Teachers</caption>
    <tr>
        <td>id</td>
        <td>shortname</td>
    </tr>
    <?php foreach ($teachers as $row) : ?>
        <tr>
            <td><?= $row[0]; ?></td>
            <td><?= $row[1]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
On page: <?= count($teachers)?>
<br>
<?php $p = 1; while($p <= $page_count) :?>
    <a <?= href('teachers', 'index', array("page"=>$p))?>><?= $p++ ?></a>
<?php endwhile; ?>