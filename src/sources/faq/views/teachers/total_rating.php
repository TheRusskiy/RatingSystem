<?php
function explain_value($criteria, $value){
    if($criteria->fetch_type!='manual_options'){
        return $value;
    }
    $res = $value;
    array_shift($res);
    return implode("; ", $res);
};
?>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <h3>Общий рейтинг с <?= $season->from_date ?> по <?= $season->to_date ?></h3>
        </div>
        <div class="col-md-5 no-print">
            <form action="/" class="form-inline pull-right">
                <input name="controller" type="hidden" value="teachers"/>
                <input name="action" type="hidden" value="total_rating"/>
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
</div>
<table class="table table-bordered table-condensed">
    <tr>
        <td rowspan="2">ФИО</td>
        <?php foreach ($criteria as $i=>$c) : ?>
            <td colspan="2"><?= $i+1 ?>. <?= $c->name ?></td>
        <?php endforeach ?>
        <td rowspan="2">Итого</td>
    </tr>
    <tr>
        <?php foreach ($criteria as $c) : ?>
            <td>Очков</td>
            <td>Баллов</td>
        <?php endforeach ?>
    </tr>
    <?php foreach ($teachers as $t) : ?>
        <tr>

            <td>
                <?= link_for_teacher($t, "{$t['name']} {$t['surname']}") ?>
            </td>
            <?php foreach ($t['ratings'] as $r) : ?>
                <td>
                    <?= explain_value($r->criteria, $r->value) ?>
                </td>
                <td>
                    <?= $r->score ?>
                </td>
            <?php endforeach ?>
            <td>
                <?= $t['total_rating']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>