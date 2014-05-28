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
    <div class="col-md-7">
        <h3>Рейтинг для <?= $teacher['name']." ".$teacher['secondname']." ".$teacher['surname'] ?></h3>
        <p>С <?= $season->from_date ?> по <?= $season->to_date ?></p>
    </div>
    <div class="col-md-5 no-print">
        <form action="/" class="form-inline pull-right">
            <input name="controller" type="hidden" value="teachers"/>
            <input name="action" type="hidden" value="show"/>
            <input name="id" type="hidden" value="<?= params('id') ?>"/>
            <div class="form-group">
                <select name="season_id" id="" class="form-control">
                    <?php foreach ($seasons as $s) : ?>
                        <option value="<?= $s->id ?>"
                            <?php if($s->id==$season->id) : ?>
                            selected
                            <?php endif ?>
                            >
                            С <?= $s->from_date ?> по <?= $s->to_date ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Выбрать интервал</button>
        </form>
    </div>
</div>
<div class="row">
   <div class="col-md-12">
       <table class="table table-bordered">
           <?php foreach ($results as $ri => $r) : ?>
               <?php $last_year = isset($r->previous_year_score) && ($r->previous_year_score != null) ?>
               <tr>
                   <td colspan="5">
                       <?= $ri+1 ?>.
                       <?= $r->criteria->name ?>
                       <?php if ($r->criteria->year_limit != 0) : ?>
                           (
                           максимум в год: <?=$r->criteria->year_limit?>;
                           <?php if ($r->criteria->year_2_limit != 0) : ?>
                               в 2 года: <?=$r->criteria->year_2_limit?>
                           <?php endif ?>
                           )
                       <?php endif ?>
                       <p>
                           <?= $r->criteria->description ?>
                       </p>
                       <p>
                           <?php if($r->criteria->fetch_type=='manual_options'): ?>
                               Коэффициенты: <?= manual_options_multipliers($r->criteria) ?>
                           <?php else : ?>
                               Коэффициент: <?= $r->criteria->multiplier ?>
                           <?php endif ?>
                       </p>
                   </td>
               </tr>
               <?php if(sizeof($r->records)>0) : ?>
                   <tr>
                       <td>№</td>
                       <td colspan="2">Описание</td>
                       <td>Дата</td>
                       <td>Баллы</td>
                   </tr>
                   <?php foreach ($r->records as $i=>$record) : ?>
                       <tr>
                           <td><?= $i+1 ?>.</td>
                           <?php if($r->criteria->fetch_type=='manual_options'): ?>
                               <td><?= $r->criteria->options[$record['value']] ?></td>
                               <td><?= $record['name'] ?></td>
                           <?php else : ?>
                               <td colspan="2"><?= $record['name'] ?></td>
                           <?php endif ?>
                           <td width="100"><?= $record['date'] ?></td>
                           <td>
                               <?php if($r->criteria->fetch_type=='manual_options'): ?>
                                   <?= $r->criteria->multiplier[$record['value']] ?>
                               <?php else : ?>
                                   <?= $r->criteria->multiplier ?>
                               <?php endif ?>
                           </td>
                       </tr>
                   <?php endforeach; ?>
               <?php else : ?>
                   <tr>
                       <td colspan="5">Достижения отсутствуют</td>
                   </tr>
               <?php endif ?>

               <tr>
                   <td>Всего:</td>
                   <td>
                       <?php if($last_year): ?>
                           В прошлый раз: <?=$r->previous_year_score?>
                       <?php else : ?>
                           В прошлый раз: достижения отсутствуют
                       <?php endif ?>
                   </td>
                   <td style="text-align: right" colspan="2"></td>
                   <td><?= $r->score ?></td>
               </tr>
               <tr>
                   <td colspan="5"></td>
               </tr>
           <?php endforeach; ?>
           <tr>
               <td colspan="4">Баллов по всем показателям: </td>
               <td><?= $score_sum ?></td>
           </tr>
       </table>
   </div>
</div>
<div class="row print-only">
    <p>
        Данные сформированы в системе расчёта рейтинга ППС СГАУ
<?= date("Y-m-d в H:i:s") ?>
    </p>
    <p>
        <?= $teacher['name']." ".$teacher['secondname']." ".$teacher['surname'] ?>
    </p>
    <table>
        <tr>
            <td>Правильность предоставленных данных подтверждаю:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>Подпись______________(_______________)</td>
        </tr>
        <tr>
            <td>Заведующий кафедрой: </td>
            <td>Подпись______________(_______________)</td>
        </tr>
        <tr>
            <td>Уполномоченный по качеству кафедры: </td>
            <td>Подпись______________(_______________)</td>
        </tr>
    </table>
</div>