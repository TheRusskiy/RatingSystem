<?php
    $initial_class = params('search') == null ? "" : 'x';
?>

<div class="row">
    <div class="col-md-6">

        <form action="/" class="form form-inline">
            <?= hidden_field('controller', 'teachers')?>
            <?= hidden_field('action', 'index')?>
            <div class="form-group">
                <label class="sr-only" for="teacher-search">Имя/Фамилия преподавателя</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    <input id="teacher-search" type="text" name="search" class="input-lg form-control clearable <?=$initial_class?>" placeholder="ФИО преподавателя" value="<?=params('search', '')?>"/>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-lg">Поиск</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <h4>Преподаватели</h4>
            <tr>
                <td>id</td>
                <td>ФИО</td>
                <td>Кафедра</td>
                <td>Рейтинг</td>
            </tr>
            <?php foreach ($teachers as $t) : ?>
                <tr>
                    <td>
                        <?= $t['id']?>
                    </td>
                    <td>
                        <?= $t['surname']." ".$t['name']." ".$t['secondname']; ?>
                    </td>
                    <td>
                        <?= $t['department']; ?>
                    </td>
                    <td>
                        <?= link_for_teacher($t, 'Просмотреть'); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">На странице: <?= count($teachers)?></div>
        <div class="pull-left">
            <?= pagination(href('teachers', 'index'), $page_count, $page, array('search'=>params('search'))) ?>
        </div>
    </div>
</div>
<script>
    $( "#teacher-search" ).autocomplete({
        minLength: 3,
        source: <?=json_encode($teacher_names)?>
    });
</script>