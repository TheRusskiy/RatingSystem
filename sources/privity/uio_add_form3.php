<?
  $a = $_GET['a'];
 $a = 'sdfsdf';
     print_r($_POST);    
function add(){
	 
	
$pagetext = "
<form method=POST >
<table border=0 width=100% height=100%>
  <tr>
    <td width='252'>&nbsp;</td>
    <td width='578'>&nbsp;</td>
    <td width='5'>&nbsp;</td>
    <td width='106'>&nbsp;</td>
  </tr>
  <tr>
    <td height='48' colspan='2'><strong>����������������� ���������</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>����� ������      </label>
    </td>
    <td><input type='text' name=adr  id='adr' value = 'dgfdf' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>��� ����� </label>&nbsp;
     
    </td>
    <td><select name='Vid_prava' id='Vid_prava'>
      <option value = '����������� ����������'>����������� ����������</option>
      <option value = '������������� �����������'>������������� �����������</option>
      <option value = '������'>������</option>
      <option value = '������'>������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>� ������������ �      </label>
   </td>
    <td><input type='text' name='Sootvetstvie' id='Sootvetstvie' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>������������ ������ (���������)      </label>
 </td>
    <td><input type='text' name='Naimenovanie_zdaniya' id='Naimenovanie_zdaniya' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>������ �      </label>
   </td>
    <td><select name='Nomer_korpusa' id='Nomer_korpusa'>";
	 $db = mysql_connect('localhost','Shaman','123');
     mysql_select_db('mon',$db);
	$result2 = mysql_query('SELECT * FROM `Korpus` ',$db);
    $m = mysql_fetch_array($result2);
	 do{
           $pagetext =$pagetext. '<option value='.$m['Nomer_korpusa'].'>'.$m['Nomer_korpusa'].'</option>'; //????????? ????? ???????
       }
     while($m = mysql_fetch_array($result2));
   $pagetext =$pagetext."  </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>����      </label>
   </td>
    <td><select name='Etag' id='Etag'>
      <option value='����������'>����������</option>
      <option value='���������'>���������</option>
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
    <td>
      <label>������� �      </label>
    </td>
    <td><input type='text' name='Nomer_komnati' id='Nomer_komnati' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>�� ����������� �      </label>
    </td>
    <td><input type='text' name='Nomer_tehpasporta' id='Nomer_tehpasporta' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='45'><form id='form9' name='form9' method='post' action=''>
      <label>����� �������, �2      </label>
    </form></td>
    <td><input type='text' name='Obshaya_ploshad' id='Obshaya_ploshad' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td height='60' colspan='2'><strong>������������� ���������</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>��������� ���������      </label>
    </td>
    <td><select name='Categoriya_pomesh' id='Categoriya_pomesh'>
      <option value = '�������' >�������</option>
      <option value ='������-���������������'>������-���������������</option>
      <option value = '�������'>�������</option>
      <option value ='���������'>���������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>���������� ���������      </label>
    </td>
    <td><input type='text' name='Naznachenie_pomesh' id='Naznachenie_pomesh' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>��� �������������      </label>
   </td>
    <td><select name='Vid_ispolzovanie' id='Vid_ispolzovanie'>
      <option value = '�� ����������'>�� ����������</option>
      <option value = '�� �� ����������'>�� �� ����������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>����������� ���������      </label>
    </td>
    <td><select name='Obremenenie' id='Obremenenie'>
      <option value = '������'>������</option>
      <option value ='���'>���</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <label>����� �������������      </label>
   </td>
    <td><select name='Rejim_ispol' id='Rejim_ispol'>
      <option value ='� 8 �� 17 �����'>� 8 �� 17 �����</option>
      <option value ='� 9 �� 18 �����'>� 9 �� 18 �����</option>
      <option value ='� 8 �� 20 �����'>� 8 �� 20 �����</option>
      <option value='������'>������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>���� ������ �������������</td>
    <td><input type='text' name='Data_nachala' id='Data_nachala'  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>���� ��������� �������������</td>
    <td><input type='text' name='Data_okonchaniya' id='Data_okonchaniya'  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form15' name='form15' method='post' action=''>
      <label>���������� ������� (����-���) ����      </label>
    </form></td>
    <td><input type='text' name='Kol-vo_mest' id='Kol-vo_mest' value =$a /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form16' name='form16' method='post' action=''>
      <label>���������� ������� (����-���) ���� - �����������      </label>
    </form></td>
    <td><textarea name='Kol-vo_mest_komment' id='Kol-vo_mest_komment' rows='4' ></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='57' colspan='2'><strong>����������� �������������, ��������������� ���������</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form17' name='form17' method='post' action='uio_addToBase.php'>
      <label>����������� �������������      </label>
    </form></td>
    <td><select class='input' type=text name='Structurnoe_podrazdlenie' id='Structurnoe_podrazdlenie' action = 'uio_addToBase.php' metod='post'>";
	
          $result2 = mysql_query('SELECT * FROM `dep` ',$db);
          $m = mysql_fetch_array($result2);
          do{
            $pagetext = $pagetext . '<option value='.$m['name'].'>'.$m['name'].'</option>'; 
          }
         while($m = mysql_fetch_array($result2)); 
		 
	
       
	//	return $pagetext;}
//function add2(){
	$pagetext =$pagetext.
 "  </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form18' name='form18' method='post' action=''>
      <label>������������ �������������      </label>
    </form></td>
    <td><input type='text' name='Rukovoditel_podrazdeleniya' id='Rukovoditel_podrazdeleniya' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form19' name='form19' method='post' action=''>
      <label>������������� ����      </label>
    </form></td>
    <td><input type='text' name='Otvetstvennoe_lico' id='Otvetstvennoe_lico' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form20' name='form20' method='post' action=''>
      <label>�������      </label>
    </form></td>
    <td><input type='text' name='Telefon' id='Telefon' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='53' colspan='2'><strong>����������� ���������</strong> <strong>���������</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form21' name='form21' method='post' action=''>
      <label>����      </label>
    </form></td>
    <td><select name='Okna' id='Okna'>
      <option value='��������'>��������</option>
      <option value='�������'>�������</option>
      <option value='������������������'>������������������</option>
      <option value='��������������������'>��������������������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>�����
    </label></td>
    <td><select name='Dveri' id='Dveri'>
     <option value='��������'>��������</option>
      <option value='�������'>�������</option>
      <option value='������������������'>������������������</option>
      <option value='��������������������'>��������������������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>�����
    </label></td>
    <td><select name='Steni' id='Steni'>
     <option value='��������'>��������</option>
      <option value='�������'>�������</option>
      <option value='������������������'>������������������</option>
      <option value='��������������������'>��������������������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>�������
    </label></td>
    <td><select name='Potolok' id='Potolok'>
      <option value='��������'>��������</option>
      <option value='�������'>�������</option>
      <option value='������������������'>������������������</option>
      <option value='��������������������'>��������������������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>���
    </label></td>
    <td><select name='Pol' id='Pol'>
     <option value='��������'>��������</option>
      <option value='�������'>�������</option>
      <option value='������������������'>������������������</option>
      <option value='��������������������'>��������������������</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form22' name='form22' method='post' action=''>
      <label>������� ��������������      </label>
    </form></td>
    <td><select name='Nalichie_pereplanirovok' id='Nalichie_pereplanirovok'>
      <option value='��'>��</option>
      <option value='���'>���</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form23' name='form23' method='post' action=''>
      <label>������� �������������� - �����������      </label>
    </form></td>
    <td><textarea name='Nalichie_pereplanirovok_komment' rows='4' id='Nalichie_pereplanirovok_komment'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>������������</label><form id='form24' name='form24' method='post' action=''>
      <p><br />
        <br />
      </p>
    </form></td>
    <td><input type='checkbox' name='������������' value='��������' id='������������_0' />
    <label>��������<br />
      <input type='checkbox' name='������������' value='��������' id='������������_1' />
��������</label>
    <br />
    <label>
      <input type='checkbox' name='������������' value='���' id='������������_2' />
      ���</label>
    <label>    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height='55' colspan='2'><strong>������� ������������������ ��������</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form25' name='form25' method='post' action=''>
      <label>��������� �������������-����� ��������      </label>
    </form></td>
    <td><textarea name='Zamechaniya' rows='4' id='Zamechaniya'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form26' name='form26' method='post' action=''>
      <label>�����������      </label>
    </form></td>
    <td><textarea name='Predlojeniya' rows='4' with id='Predlojeniya'></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form27' name='form27' method='post' action=''>
      <label>���� ��������������      </label>
    </form></td>
    <td><input type='text' name='Data' id='Data'  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form28' name='form28' method='post' action=''>
      <label>�������� ������������������ ��������:</label>
    </form></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id='form29' name='form29' method='post' action=''>
      <label> �������� ������������������ ��������      </label>
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
<form/>

";

print_r($_POST);

return $pagetext;}
?>
