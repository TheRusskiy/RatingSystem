<?php
    $sum = 0;
    foreach($criteria as $c){
        $sum+=$c->result;
        if (!$c->has_records){
            $sum='?';
            break;
        }
    }

    function create_record($cr, $record = array(
        'id'=>null,
        'value'=>'',
        'date'=>''
    )){ // when null template is rendered
        $r = "";
        $class = 'record';
        if ($record['id'] === null){
            $class = '';
        }
        $id = $record['id'];
        $value = $record['value'];
        $date = $record['date'];
        $r.="<div class='$class' data-id='$id' data-criteria='$cr->id'>\n";
        $r.="<a class='delete_record' href='#'>X</a>\n";
        $r.="<input class='field date-field' data-type='date' type='text' value='$date'/>\n";
        if($cr->fetch_type=="manual"){
            $r.="<input class='field' data-type='value' type='text' value='$value'/>\n";
        } else{
            $r.="<select class='field' data-type='value' type='text'>\n";
            foreach ($cr->options as $i => $o){
                $selected = $i=== intval($value) ? 'selected' : '';
                $r.="<option value='$i' $selected>$o</option>\n";
            }
            $r.="</select>\n";
        }
        $r.="</div>\n";
        return $r;
    }
    function create_records($criteria){
        $result = "";
        foreach ($criteria->records as $r) {
            $result.=create_record($criteria, $r);
        }
        return $result;
    }
?>
<h1>Rating for <?= $teacher['shortname'] ?></h1>
<hr/>
<?= render('home/_date_range')?>
<div id="rating_table">
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
                    <?= $c->value_to_string()." ($c->calculation_type)"; ?>
                    <br/>

                    <?php if($c->fetch_type=="manual" || $c->fetch_type=="manual_options") : ?>
                        <?= create_records($c) ?>
                        <!--TEMPLATE for new record creation via JS:-->
                        <div style="display: none" id="template_<?=$c->id?>">
                            <?= create_record($c) ?>
                        </div>
                        <a class="new_record" data-id="<?=$c->id?>" href="#">Новая запись</a>
                    <?php endif ?>
                </td>
                <td><?= $c->multiplier_to_string(); ?></td>
                <td><?= $c->result_to_string(); ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>
<a id="save_criteria" href="#">Сохранить изменения</a>
<h2>Sum: <?= $sum?></h2>