<?php
    $now = new DateTime();
    $now = $now->format('Y-m-d');
    $year_ago = new DateTime();
    $year_ago->modify('-1 year');
    $year_ago = $year_ago->format('Y-m-d');
    $from = _or_(params('from'), session('from'), $now);//"2013-01-01";
    $to = _or_(params('to'), session('to'), $year_ago);//"2014-01-01";
    $current_params = "";
    foreach($_GET as $name => $value){
        if ($name==='from' || $name==='to' ) {continue;}
        $current_params.=hidden_field($name, $value)."\n";
    }
?>
<div id = "date_range">
    <form action="/">
        <?= $current_params ?>
        <label for="from">Перид с</label>
        <input type="text" id="from" name="from" value="<?= $from ?>"/>
        <label for="to">по</label>
        <input type="text" id="to" name="to"  value="<?= $to ?>"/>
        <input type="submit" value="обновить">
    </form>
</div>