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
            <td>
                <?= $c->value_to_string(); ?>
                <br/>

                <div class='record'>
                    <input class='record-field' data-type="date" type="text"/>
                    <input class='record-field' data-type="value" type="text"/>
                </div>

                <div style="display: none" id="template_<?=$c->id?>">
                <!--Template-->
                    <div class='record' data-criteria="<?=$c->id?>">
                        <input class='record-field' data-type="date" type="text"/>
                        <input class='record-field' data-type="value" type="text"/>
                    </div>
                </div>
                <a class="new_record" data-id="<?=$c->id?>" href="#">Новая запись</a>
            </td>
            <td><?= $c->multiplier_to_string(); ?></td>
            <td><?= $c->result; ?></td>
        </tr>

    <?php endforeach; ?>
</table>
<h2>Sum: <?= $sum?></h2>

<div id="show-templates" style="display: none">
    <!--TEMPLATES-->

</div>