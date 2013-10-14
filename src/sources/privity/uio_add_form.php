<?
$a = $_GET['a'];
echo "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Мониторинг деятельности подразделений университета</font></title>
  <link type=text/css href=/styles/common.css rel=stylesheet>
</head>
<body>
<form method=POST>
<table border=0 width=100% height=100%>
  <tr>
    <td width='252'>&nbsp;</td>
    <td width='578'>&nbsp;</td>
    <td width='5'>&nbsp;</td>
    <td width='106'>&nbsp;</td>
  </tr>
  <tr>
    <td height='48' colspan='2'><strong>Месторасположение помещения</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form1' name='form1' method='post' action=''>
      <label>Адрес здания      </label>
    </form></td>
    <td><input type='text' name='adr' id='adr' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Вид права </label>&nbsp;
      <form id='form2' name='form2' method='post' action=''>
    </form></td>
    <td><select name='Vid_prava' id='Vid_prava'>
      <option value = 'оперативное управление'>оперативное управление</option>
      <option value = 'безвозмездное пользование'>безвозмездное пользование</option>
      <option value = 'аренда'>аренда</option>
      <option value = 'другое'>другое</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form3' name='form3' method='post' action=''>
      <label>В соответствии с      </label>
    </form></td>
    <td><input type='text' name='Sootvetstvie' id='Sootvetstvie' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form4' name='form4' method='post' action=''>
      <label>Наименование здания (помещения)      </label>
    </form></td>
    <td><input type='text' name='Naimenovanie_zdaniya' id='Naimenovanie_zdaniya' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form5' name='form5' method='post' action=''>
      <label>Корпус №      </label>
    </form></td>
    <td><select name='Nomer_korpusa' id='Nomer_korpusa'>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form6' name='form6' method='post' action=''>
      <label>Этаж      </label>
    </form></td>
    <td><select name='Etag' id='Etag'>
      <option value='подвальный'>подвальный</option>
      <option value='цокольный'>цокольный</option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
      <option value='9'>9</option>
      <option value='10'>10</option>
      <option value='11'>11</option>
      <option value='12'>12</option>
      <option value='13'>13</option>
      <option value='14'>14</option>
      <option value='15'>15</option>
      <option value='16'>16</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form7' name='form7' method='post' action='>
      <label>Комната №      </label>
    </form></td>
    <td><input type='text' name='Nomer_komnati' id='Nomer_komnati' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form8' name='form8' method='post' action=''>
      <label>По техпаспорту №      </label>
    </form></td>
    <td><input type='text' name='Nomer_tehpasporta' id='Nomer_tehpasporta' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='45'><form id='form9' name='form9' method='post' action=''>
      <label>Общая площадь, м2      </label>
    </form></td>
    <td><input type='text' name='Obshaya_ploshad' id='Obshaya_ploshad' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td height='60' colspan='2'><strong>Использование помещения</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form10' name='form10' method='post' action=''>
      <label>Категория помещения      </label>
    </form></td>
    <td><select name='Categoriya_pomesh' id='Categoriya_pomesh'>
      <option value = 'учебное' >учебное</option>
      <option value ='учебно-вспомогательное'>учебно-вспомогательное</option>
      <option value = 'научное'>научное</option>
      <option value ='подсобное'>подсобное</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form11' name='form11' method='post' action=''>
      <label>Назначение помещения      </label>
    </form></td>
    <td><input type='text' name='Naznachenie_pomesh' id='Naznachenie_pomesh' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form12' name='form12' method='post' action=''>
      <label>Вид использования      </label>
    </form></td>
    <td><select name='Vid_ispolzovanie' id='Vid_ispolzovanie'>
      <option value = 'по назначению'>по назначению</option>
      <option value = 'не по назначению'>не по назначению</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form13' name='form13' method='post' action=''>
      <label>Обременение помещения      </label>
    </form></td>
    <td><select name='Obremenenie' id='Obremenenie'>
      <option value = 'аренда'>аренда</option>
      <option value ='нет'>нет</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form14' name='form14' method='post' action=''>
      <label>Режим использования      </label>
    </form></td>
    <td><select name='Rejim_ispol' id='Rejim_ispol'>
      <option value ='с 8 до 17 часов'>с 8 до 17 часов</option>
      <option value ='с 9 до 18 часов'>с 9 до 18 часов</option>
      <option value ='с 8 до 20 часов'>с 8 до 20 часов</option>
      <option value='другой'>другой</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form15' name='form15' method='post' action=''>
      <label>Количество учебных (рабо-чих) мест      </label>
    </form></td>
    <td><input type='text' name='Kol-vo_mest' id='Kol-vo_mest' value =$a /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form16' name='form16' method='post' action=''>
      <label>Количество учебных (рабо-чих) мест - комментарии      </label>
    </form></td>
    <td><textarea name='Kol-vo_mest_komment' id='Kol-vo_mest_komment' rows='4' ></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='57' colspan='2'><strong>Структурное подразделение, эксплуатирующее помещение</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form17' name='form17' method='post' action=''>
      <label>Структурное подразделение      </label>
    </form></td>
    <td><select class='input' type=text name='Structurnoe_podrazdlenie' id='Structurnoe_podrazdlenie'>";
        $db = mysql_connect('localhost','Shaman','123');
          mysql_select_db('mon',$db);
          $result2 = mysql_query('SELECT * FROM `dep` ',$db);
          $m = mysql_fetch_array($result2);
          do{
              echo '<option value='.$m['name'].'>'.$m['name'].'</option>'; //Формируем новую строчку
          }
         while($m = mysql_fetch_array($result2));
echo " </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form18' name='form18' method='post' action=''>
      <label>Руководитель подразделения      </label>
    </form></td>
    <td><input type='text' name='Rukovoditel_podrazdeleniya' id='Rukovoditel_podrazdeleniya' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form19' name='form19' method='post' action=''>
      <label>Ответственное лицо      </label>
    </form></td>
    <td><input type='text' name='Otvetstvennoe_lico' id='Otvetstvennoe_lico' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form20' name='form20' method='post' action=''>
      <label>Телефон      </label>
    </form></td>
    <td><input type='text' name='Telefon' id='Telefon' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='53' colspan='2'><strong>Техническое состояние</strong> <strong>помещения</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form21' name='form21' method='post' action=''>
      <label>Окна      </label>
    </form></td>
    <td><select name='Okna' id='Okna'>
      <option value='отличное'>отличное</option>
      <option value='хорошее'>хорошее</option>
      <option value='удовлетворительное'>удовлетворительное</option>
      <option value='неудовлетворительное'>неудовлетворительное</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Двери
    </label></td>
    <td><select name='Dveri' id='Dveri'>
     <option value='отличное'>отличное</option>
      <option value='хорошее'>хорошее</option>
      <option value='удовлетворительное'>удовлетворительное</option>
      <option value='неудовлетворительное'>неудовлетворительное</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Стены
    </label></td>
    <td><select name='Steni' id='Steni'>
     <option value='отличное'>отличное</option>
      <option value='хорошее'>хорошее</option>
      <option value='удовлетворительное'>удовлетворительное</option>
      <option value='неудовлетворительное'>неудовлетворительное</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Потолок
    </label></td>
    <td><select name='otolok' id='otolok'>
      <option value='отличное'>отличное</option>
      <option value='хорошее'>хорошее</option>
      <option value='удовлетворительное'>удовлетворительное</option>
      <option value='неудовлетворительное'>неудовлетворительное</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Пол
    </label></td>
    <td><select name='Pol' id='Pol'>
     <option value='отличное'>отличное</option>
      <option value='хорошее'>хорошее</option>
      <option value='удовлетворительное'>удовлетворительное</option>
      <option value='неудовлетворительное'>неудовлетворительное</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form22' name='form22' method='post' action=''>
      <label>Наличие перепланировок      </label>
    </form></td>
    <td><select name='Nalichie_pereplanirovok' id='Nalichie_pereplanirovok'>
      <option value='да'>да</option>
      <option value='нет'>нет</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form23' name='form23' method='post' action=''>
      <label>Наличие перепланировок - комментарии      </label>
    </form></td>
    <td><textarea name='Nalichie_pereplanirovok_komment' rows='4' id='Nalichie_pereplanirovok_komment'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Сигнализация</label><form id='form24' name='form24' method='post' action=''>
      <p><br />
        <br />
      </p>
    </form></td>
    <td><input type='checkbox' name='Сигнализация' value='охранная' id='Сигнализация_0' />
    <label>охранная<br />
      <input type='checkbox' name='Сигнализация' value='пожарная' id='Сигнализация_1' />
пожарная</label>
    <br />
    <label>
      <input type='checkbox' name='Сигнализация' value='нет' id='Сигнализация_2' />
      нет</label>
    <label>    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='55' colspan='2'><strong>Отметки инвентаризационной комиссии</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form25' name='form25' method='post' action=''>
      <label>Замечания инвентаризаци-онной комиссии      </label>
    </form></td>
    <td><textarea name='Zamechaniya' rows='4' id='Zamechaniya'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form26' name='form26' method='post' action=''>
      <label>Предложения      </label>
    </form></td>
    <td><textarea name='Predlojeniya' rows='4' with id='Predlojeniya'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form27' name='form27' method='post' action=''>
      <label>Дата инвентаризации      </label>
    </form></td>
    <td><input type='text' name='Data' id='Data'  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form28' name='form28' method='post' action=''>
      <label>Участник инвентаризационной комиссии:</label>
    </form></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form29' name='form29' method='post' action=''>
      <label> Участник инвентаризационной комиссии      </label>
    </form>  </td>
    <td>
    
   <input type='text' name='Uchastnik' id='Uchastnik'/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
";
?>
