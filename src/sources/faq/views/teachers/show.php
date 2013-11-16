<?php
    $sum = 0;
    foreach($criteria as $c){
        $sum+=$c->result;
    }
?>
<h1>Rating for <?= $teacher['shortname'] ?></h1>
<table>
    <caption>Criteria</caption>
    <tr>
        <td>Name</td>
        <td>Multiplier</td>
        <td>Result</td>
    </tr>
    <?php foreach ($criteria as $c) : ?>
        <tr>
            <td><?= $c->name; ?></td>
            <td><?= $c->multiplier; ?></td>
            <td><?= $c->result; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<h2>Sum: <?= $sum?></h2>