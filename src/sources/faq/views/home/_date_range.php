<?php
    $now = new DateTime();
    $now = $now->format('Y-m-d');
    $year_ago = new DateTime();
    $year_ago->modify('-1 year');
    $year_ago = $year_ago->format('Y-m-d');
    $from = _or_(params('from_date'), session('from_date'), $year_ago);//"2012-01-01";
    $to = _or_(params('to_date'), session('to_date'), $now);//"2013-01-01";
    session('from_date', $from);
    session('to_date', $to);
    $current_params = "";
    foreach($_GET as $name => $value){
        if ($name==='from_date' || $name==='to_date' ) {continue;}
        $current_params.=hidden_field($name, $value)."\n";
    }
?>
<div id = "date_range">
    <form action="/">
        <?= $current_params ?>
        <label for="from">Период с</label>
        <input type="text" id="from" name="from_date" value="<?= $from ?>"/>
        <label for="to">по</label>
        <input type="text" id="to" name="to_date"  value="<?= $to ?>"/>
        <input type="submit" value="обновить">
    </form>
</div>