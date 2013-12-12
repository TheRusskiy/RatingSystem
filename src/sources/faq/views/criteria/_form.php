<div class="form">
    <form action="/" method="post">
        <?=hidden_field('controller', 'criteria')?>
        <?=hidden_field('action', 'upsert')?>
        <?=hidden_field('id', $criteria->id)?>

        <div class="field">
            <label for='name'>Название</label>
            <input id= 'name' type="text" name="name" value="<?=$criteria->name?>"/>
        </div>

        <div class="field">
            <label  for='fetch_type' >Способ вычисления </label>
            <select id= 'fetch_type'  name="fetch_type">
                <?php foreach($criteria->fetch_types() as $key => $value): ?>
                    <option value="<?=$key?>" <?=selected($key, $criteria->fetch_type)?>><?=$value?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="field">
            <label  for='fetch_value' >Данные</label>
            <textarea id= 'fetch_value' name="fetch_value"><?=$criteria->fetch_value?></textarea>
        </div>

        <div class="field">
            <label  for='multiplier' >Множитель</label>
            <input id= 'multiplier'  type="text" name="multiplier" value="<?=$criteria->multiplier_to_string()?>"/>
        </div>

        <div class="field">
            <label  for='calculation_type' >Метод оценки</label>
            <select id= 'calculation_type'  name="calculation_type">
                <?php foreach($criteria->calculation_types() as $key => $value): ?>
                    <option value="<?=$key?>" <?=selected($key, $criteria->calculation_type)?>><?=$value?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="field">
            <label  for='year_limit'>Лимит в год</label>
            <input id= 'year_limit'type="text" name="year_limit" value="<?=$criteria->year_limit?>"/>
        </div>

        <div class="field">
            <label  for='creation_date'>Дата</label>
            <input id= 'creation_date'type="text" name="creation_date" value="<?=$criteria->creation_date?>"/>
        </div>

        <input class='left' type="submit" value="Сохранить"/>
    </form>
</div>