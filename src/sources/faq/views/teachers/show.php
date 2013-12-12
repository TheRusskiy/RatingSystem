<?php

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
<h1>Рейтинг для <?= $teacher['name']." ".$teacher['surname'] ?></h1>
<hr/>
<?= render('home/_date_range')?>
<div id="rating_table">
    <table>
        <caption>Критерии</caption>
        <tr>
            <td>id</td>
            <td>Название</td>
            <td>Значение</td>
            <td>Множитель</td>
            <td>Баллы</td>
        </tr>
        <?php foreach ($criteria as $c) : ?>
            <tr>
                <td><?= $c->id; ?></td>
                <td><?= $c->name; ?></td>
                <td>
                    <?php $ct = $c->calculation_types(); $ct = $ct[$c->calculation_type] ?>
                    <?= $c->value_to_string()." ($ct)"; ?>
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
    <a id="save_criteria" href="#">Сохранить изменения</a>
    <h2 class="right">Всего баллов: <?= $result?></h2>
</div>
