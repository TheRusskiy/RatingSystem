<?php
    $sum = 0;
    foreach($criteria as $c){
        $sum+=$c->result;
    }

    function create_record($cr){
        $r = "";
        $r.="<div class='record' data-criteria='$cr->id'>\n";
        $r.="<input class='record-field' data-type='date' type='text'/>\n";
        if($cr->fetch_type=="manual"){
            $r.="<input class='record-field' data-type='value' type='text'/>\n";
        } else{
            $r.="<select class='record-field' data-type='value' type='text'>\n";
            foreach ($cr->options as $i => $o){
                $r.="<option value='$i'>$o</option>\n";
            }
            $r.="</select>\n";
        }
        $r.="</div>\n";
        return $r;
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

                <?php if($c->fetch_type=="manual" || $c->fetch_type=="manual_options") : ?>
                <div class='record'>
                    <input class='record-field' data-type="date" type="text"/>
                    <input class='record-field' data-type="value" type="text"/>
                </div>

                <div style="display: none" id="template_<?=$c->id?>">
                    <?= create_record($c) ?>
                </div>
                <a class="new_record" data-id="<?=$c->id?>" href="#">Новая запись</a>
                <?php endif ?>
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