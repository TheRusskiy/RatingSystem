<?php
    $sum = 0;
    foreach($criteria as $c){
        $sum+=$c->result;
    }
?>
<h1>Rating for <?= $teacher['shortname'] ?></h1>
<hr/>
<?= render('home/_date_range')?>
<table>
    <caption>Criteria</caption>
    <tr>
        <td>Name</td>
        <td>Value</td>
        <td>Multiplier</td>
        <td>Result</td>
    </tr>
    <?php foreach ($criteria as $c) : ?>
        <tr>
            <td><?= $c->name; ?></td>
            <td><?= $c->value_to_string(); ?></td>
            <td><?= $c->multiplier_to_string(); ?></td>
            <td><?= $c->result; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<h2>Sum: <?= $sum?></h2>