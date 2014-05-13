<?php
function manual_options_multipliers($criteria){
    $arr = array();
    $m = $criteria->multiplier;
    array_shift($m);
    for($i = 0; $i < sizeof($m); $i++){
        array_unshift($arr, $criteria->options[$i+1].": ".$m[$i]);
    }
    return implode("; ", $arr);
}
$score_sum = 0;
foreach ($results as $r){
    $score_sum += $r->score;
}
?>
<div class="row">
    <div class="col-md-8">
        <h3>Рейтинг для <?= $teacher['name']." ".$teacher['surname'] ?></h3>
        <p>С <?= $season->from_date ?> по <?= $season->to_date ?></p>
    </div>
    <div class="col-md-4">
        <form action="/">
            <input name="controller" type="hidden" value="teachers"/>
            <input name="action" type="hidden" value="show"/>
            <input name="id" type="hidden" value="<?= params('id') ?>"/>
            <select name="season_id" id="">
                <?php foreach ($seasons as $s) : ?>
                    <option value="<?= $s->id ?>"
                        <? if($s->id==$season->id) : ?>
                        selected
                        <? endif ?>
                        >
                        С <?= $s->from_date ?> по <?= $s->to_date ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Выбрать интервал</button>
        </form>
    </div>
</div>
<div class="row">
   <div class="col-md-12">
       <table class="table table-bordered">
           <?php foreach ($results as $ri => $r) : ?>
               <? $last_year = isset($r->previous_year_score) && ($r->previous_year_score != null) ?>
               <tr>
                   <td colspan="3">
                       <?= $ri+1 ?>.
                       <?= $r->criteria->name ?>
                       <? if ($r->criteria->year_limit != 0) : ?>
                           (
                           максимум в год: <?=$r->criteria->year_limit?>;
                           <? if ($r->criteria->year_2_limit != 0) : ?>
                               в 2 года: <?=$r->criteria->year_2_limit?>
                           <? endif ?>
                           )
                       <? endif ?>
                       <p>
                           <?= $r->criteria->description ?>
                       </p>
                   </td>
               </tr>
               <?php if(sizeof($r->records)>0) : ?>
                   <tr>
                       <td>№</td>
                       <td>Описание</td>
                       <td>Дата</td>
                   </tr>
                   <?php foreach ($r->records as $i=>$record) : ?>
                       <tr>
                           <td><?= $i+1 ?>.</td>
                           <td><?= $record['name'] ?></td>
                           <td><?= $record['date'] ?></td>
                       </tr>
                   <?php endforeach; ?>
               <?php else : ?>
                   <tr>
                       <td colspan="3">Достижения отсутствуют</td>
                   </tr>
               <?php endif ?>

               <tr>
                   <td>Коэффициент</td>
                   <td colspan="2">
                       <?php if($r->criteria->fetch_type=='manual_options'): ?>
                           <?= manual_options_multipliers($r->criteria) ?>
                       <?php else : ?>
                           <?= $r->criteria->multiplier ?>
                       <?php endif ?>
                   </td>
               </tr>
               <tr>
                   <td>Баллы</td>
                   <td>
                       <? if($last_year) : ?>
                           В прошлом году: <?=$r->previous_year_score?>
                       <? endif ?>
                   </td>
                   <td>Всего: <?= $r->score ?></td>
               </tr>
               <tr>
                   <td colspan="3"></td>
               </tr>
           <?php endforeach; ?>
           <tr>
               <td colspan="3">Всего баллов: <?= $score_sum ?></td>
           </tr>
       </table>
   </div>
</div>