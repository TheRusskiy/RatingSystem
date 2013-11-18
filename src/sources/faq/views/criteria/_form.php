<form action="/" method="post">
    <?=hidden_field('controller', 'criteria')?>
    <?=hidden_field('action', 'upsert')?>
    <?=hidden_field('id', $criteria->id)?>
    <label>Название
        <input type="text" name="name" value="<?=$criteria->name?>"/>
    </label>
    <br/>
    <label>Способ вычисления
        <input type="text" name="fetch_type" value="<?=$criteria->fetch_type?>"/>
    </label>
    <br/>
    <label>Данные
        <textarea name="fetch_value"><?=$criteria->fetch_value?></textarea>
    </label>
    <br/>
    <label>Множитель
        <input type="text" name="multiplier" value="<?=$criteria->multiplier?>"/>
    </label>
    <br/>
    <label>Метод оценки
        <input type="text" name="calculation_type" value="<?=$criteria->calculation_type?>"/>
    </label>
    <br/>
    <label>Лимит в год
        <input type="text" name="year_limit" value="<?=$criteria->year_limit?>"/>
    </label>
    <br/>
    <input type="submit" value="Сохранить"/>
</form>