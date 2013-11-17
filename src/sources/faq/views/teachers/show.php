<?php
    $sum = 0;
    foreach($criteria as $c){
        $sum+=$c->result;
    }

    function create_record($cr, $is_template = false){
        $r = "";
        $class = 'record';
        if ($is_template){
            $class = '';
        }
        $r.="<div class='$class' data-criteria='$cr->id'>\n";
        $r.="<a class='delete_record' href='#'>X</a>\n";
        $r.="<input class='field date-field' data-type='date' type='text'/>\n";
        if($cr->fetch_type=="manual"){
            $r.="<input class='field' data-type='value' type='text'/>\n";
        } else{
            $r.="<select class='field' data-type='value' type='text'>\n";
            foreach ($cr->options as $i => $o){
                $r.="<option value='$i'>$o</option>\n";
            }
            $r.="</select>\n";
        }
        $r.="</div>\n";
        return $r;
    }
    function create_records(){
        return "";
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
                        <?= create_records($c, true) ?>
                    <!--TEMPLATE for new record creation via JS:-->
                    <div style="display: none" id="template_<?=$c->id?>">
                        <?= create_record($c, true) ?>
                    </div>
                    <a class="new_record" data-id="<?=$c->id?>" href="#">Новая запись</a>
                <?php endif ?>
            </td>
            <td><?= $c->multiplier_to_string(); ?></td>
            <td><?= $c->result; ?></td>
        </tr>

    <?php endforeach; ?>
</table>
<a id="save_criteria" href="#">Сохранить изменения</a>
<h2>Sum: <?= $sum?></h2>