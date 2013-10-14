<?php

$result = new Cafedra;

class Cafedra {
	var $out = "";
	var $page_title = "����� � ������������ �������";
	var $navmenu = array("���������� ��������� �������" => "data",
			"���������� ������������" => "depactivity",
			"���������� ������������� (�������)" => "totalactivity",
		);
	
	function Cafedra() {
		global $info;

		switch ($_GET["page"]) {
			case 'data' 		: $this->out = fPageData(); break;
			case 'depactivity' 	: $this->out = fPageDepActivity(); break;
			case 'totalactivity' 	: $this->out = fPageTotalActivity(); break;

			case 'depreport' 	: require("CafedraReport.php"); $this->out = fCafedraReport(); break;

//			default : $this->out = "��� ���������� ������ �������� ��������������� ����� � ����"; break;
			default : $this->out = fPageTotalActivity(); break;
		}

		
	}	

}

function fPageData() {
$out = fPeriodList();

$q = "SELECT MIN(id), MAX(id), DATE_FORMAT(MIN( start_date ),'%d.%m.%Y') , DATE_FORMAT(MAX( end_date ),'%d.%m.%Y') FROM `ka_periods`";
list($startid,$endid,$dmin,$dmax) = mysql_fetch_array(mysql_query($q));

$checkperiods = TRUE;
if (!isset($_GET["start"])) {
	$dstart = $dmin;
} else {
	$sid = (int)$_GET["start"];
	$q = "SELECT `id`,DATE_FORMAT(`start_date`,'%d.%m.%Y') FROM `ka_periods` WHERE `id`='$sid'";
	list($startid,$dstart) = mysql_fetch_array(mysql_query($q));
	if ($startid == 0) {$checkperiods = FALSE;}
}

if (!isset($_GET["end"])) {
	$dend = $dmax;
} else {
	$sid = (int)$_GET["end"];
	$q = "SELECT `id`,DATE_FORMAT(`end_date`,'%d.%m.%Y') FROM `ka_periods` WHERE `id`='$sid'";
	list($endid,$dend) = mysql_fetch_array(mysql_query($q));
	if ($endid == 0) {$checkperiods = FALSE;}
}

if (($checkperiods) AND ($startid <= $endid)) {

$deprows = ""; $total = array();

$q = "SELECT `id`,`code`,`name` FROM `dep` WHERE `id_deptype`='30278001' ORDER BY `code` ASC";
$r = mysql_query($q);
while (list($did,$dcode,$dname) = mysql_fetch_array($r)) {

    $num = array();
//echo "SELECT count(*) as cnt FROM ka_trips a 	WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id";
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_trips a 	WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_visits a 	WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_edu a 	WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_staff a 	WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_stud  a 	WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));

    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_publ   	a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_st_contests   	a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_staff_contests a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_measures  	a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
 
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_cources	  a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_laboratories	  a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_exhibitions  	a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_educ_techn  	a WHERE a.dep_id=$did AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_assets    a WHERE a.dep_id=$did AND a.fin_source = '0' AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_assets    a WHERE a.dep_id=$did AND a.fin_source = '1' AND a.period_id BETWEEN $startid AND $endid GROUP BY a.dep_id"));

    $k = sizeof($num); 
    $nums = array();
    for ($i=0;$i<=$k;$i++) {
	$total[$i] += $num[$i];
	$nums[$i] = ($num[$i]=="")?"-":$num[$i];
    }

    $deprows .= "
    <tr align=center>
	<td align=left><nobr>&nbsp; <a href=./index.php?act=reports&report=cafedra&page=depactivity&did=$did title='$dname'>$dcode</nobr></td>
	<td>".$nums[0]."</td>
	<td>".$nums[1]."</td>
	<td>".$nums[2]."</td>
	<td>".$nums[3]."</td>
	<td>".$nums[4]."</td>
	<td>".$nums[5]."</td>
	<td>".$nums[6]."</td>
	<td>".$nums[7]."</td>
	<td>".$nums[8]."</td>
	<td>".$nums[9]."</td>
	<td>".$nums[10]."</td>
	<td>".$nums[11]."</td>
	<td>".$nums[12]."</td>
	<td>".$nums[13]."</td>
	<td>".$nums[14]."</td>
	<td><a href=./index.php?act=reports&report=cafedra&page=depreport&dep=$did&start=$startid&end=$endid title='�������� ������ �� ������ ������'>".array_sum($num)."</a></td>
    </tr>";
    

}




$out .= "
<h5 align=center>����� � ���������� �������, ��������� �������������� ��� \"�������\"<br> �� ������ � $dstart �� $dend</h5>
<table width=100% cellspacing=0 cellpadding=0 border=1>
<tr bgcolor=#EEEEEE align=center>
<td width=20% rowspan=2>�������</td>

<td colspan=5>��������������� ������������</td>
<td colspan=4>������-����������������� ������������</td>
<td colspan=6>��������</td>
<td width=10% rowspan=2>����� �������</td>
</tr>
<tr bgcolor=#EEEEEE>

<td width=5% class=vertical>������� �������</td>
<td width=5% class=vertical>�����������<br> ���������</td>
<td width=5% class=vertical>������� ��������<br> ������������</td>
<td width=5% class=vertical>�������������<br> �����������������<br> ����������</td>
<td width=5% class=vertical>�������������<br> �����������������<br> ���������</td>

<td width=5% class=vertical>��������������<br> ������� ������</td>
<td width=5% class=vertical>������� ���������<br> � ���������</td>
<td width=5% class=vertical>������� ����������<br> � ���������</td>
<td width=5% class=vertical>����������� �������<br> �����������</td>

<td width=5% class=vertical>����� ������������ /<br> �����������������<br> �����</td>
<td width=5% class=vertical>����� �������� /<br> �����������������<br> �����������</td>
<td width=5% class=vertical>������� � ���������</td>
<td width=5% class=vertical>���������� �����������</td>
<td width=5% class=vertical>��������� �������,<br> ������������� ��<br> ���� ������������</td>
<td width=5% class=vertical>��������� �������,<br> ������������� ��<br> ���� ���������</td>



</tr>
$deprows
    <tr align=center>
	<td align=left>&nbsp; ����� ������� �� ������</td>
	<td>".$total[0]."</td>
	<td>".$total[1]."</td>
	<td>".$total[2]."</td>
	<td>".$total[3]."</td>
	<td>".$total[4]."</td>
	<td>".$total[5]."</td>
	<td>".$total[6]."</td>
	<td>".$total[7]."</td>
	<td>".$total[8]."</td>
	<td>".$total[9]."</td>
	<td>".$total[10]."</td>
	<td>".$total[11]."</td>
	<td>".$total[12]."</td>
	<td>".$total[13]."</td>
	<td>".$total[14]."</td>
	<td>".array_sum($total)."</td>
    </tr>
</table>

<p><i>����������</i><br>
<b>-</b> - �� ����������� ������ ������ ������� �� ����.<br> 
��������� ���������� ������� �������� � ���� ������ �� �������� ����������� ��������.<br>
</p>
<p></p>
";

} else {
	$out .= "�������� ������� �������";
}

	return $out;

} // fPageData

function fPageDepActivity() {

$closedtxt = array(
		'0' => '������',
		'1' => '������',
		'2' => '�������',
	);

$arrm = array("������","�������","����","������","���","����","����","������","��������","�������","������","�������");


$did = ($_GET["did"]=="")?0 : (int)$_GET["did"];

if ($did == 0) { // ������������� �� ������

	$out .= fDepList();

} else {	// ������� ���������� ������������� $did

	$deprows = "";
	$q = "SELECT `id`,`code`,`name` FROM `dep` WHERE `id_deptype`='30278001' AND `id`='$did'";
	$r = mysql_query($q);
	list($did,$dcode,$dname) = mysql_fetch_array($r);

	if ($did == 0) { // ������� � ����� ������� ������������� �� ����������
		$out = "������� � ����� ������� ������������� �� ����������";

	} else {

		$q = "SELECT p.id, dp.is_closed, YEAR(`start_date`), MONTH(`start_date`), ROUND(DAY(`start_date`)/10)+1 as decade,DATE_FORMAT(p.start_date,'%d-%m-%Y'), DATE_FORMAT(p.end_date,'%d-%m-%Y') FROM ka_dep_periods dp, ka_periods p WHERE p.id=dp.period_id AND dp.dep_id='$did' ORDER BY p.start_date ASC";
		$r = mysql_query($q);
		while (list($pid,$isclosed,$year,$monthnum,$decade,$pstart,$pend) = mysql_fetch_array($r)) {

		    $num = array();
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_trips 	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_visits 	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_edu a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_staff a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_stud  a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));

		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_publ   	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_st_contests   	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_staff_contests   	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_measures  	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
 
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_cources	  a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_laboratories	  a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_exhibitions  	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_educ_techn  	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_assets    a WHERE a.dep_id=$did AND a.fin_source = '0' AND period_id='$pid' GROUP BY a.dep_id"));
		    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_assets    a WHERE a.dep_id=$did AND a.fin_source = '1' AND period_id='$pid' GROUP BY a.dep_id"));

		    $k = sizeof($num); 
		    $nums = array();
		    for ($i=0;$i<=$k;$i++) {
			$nums[$i] = ($num[$i]=="")?"-":$num[$i];
		    }
			$pert = $year." �., ".$arrm[$monthnum-1].", ������ ".str_repeat("I",$decade);

		    $deprows .= "
		    <tr align=center>
			<td align=left><nobr>$pert</nobr></td>
			<td>".$nums[0]."</td>
			<td>".$nums[1]."</td>
			<td>".$nums[2]."</td>
			<td>".$nums[3]."</td>
			<td>".$nums[4]."</td>
			<td>".$nums[5]."</td>
			<td>".$nums[6]."</td>
			<td>".$nums[7]."</td>
			<td>".$nums[8]."</td>
			<td>".$nums[9]."</td>
			<td>".$nums[10]."</td>
			<td>".$nums[11]."</td>
			<td>".$nums[12]."</td>
			<td>".$nums[13]."</td>
			<td>".$nums[14]."</td>
			<td>".$closedtxt[$isclosed]."</td>
			<td>".array_sum($num)."</td>
		    </tr>";


		}
    




$out = "<div align=right>".fDepList($did)."</div>
<h5 align=center>����� �� ���������� ������������ ��� \"�������\"<br>
	�������������: $dname ($dcode)</h5>
<table width=100% cellspacing=0 cellpadding=0 border=1>
<tr bgcolor=#EEEEEE align=center>
<td width=15% rowspan=2>����������� ������</td>

<td colspan=5>��������������� ������������</td>
<td colspan=4>������-����������������� ������������</td>
<td colspan=6>��������</td>
<td width=10% rowspan=2>������ �������</td>
<td width=5% rowspan=2>����� �������</td>
</tr>
<tr bgcolor=#EEEEEE>

<td width=5% class=vertical>������� �������</td>
<td width=5% class=vertical>�����������<br> ���������</td>
<td width=5% class=vertical>������� ��������<br> ������������</td>
<td width=5% class=vertical>�������������<br> �����������������<br> ����������</td>
<td width=5% class=vertical>�������������<br> �����������������<br> ���������</td>

<td width=5% class=vertical>��������������<br> ������� ������</td>
<td width=5% class=vertical>������� ���������<br> � ���������</td>
<td width=5% class=vertical>������� ����������<br> � ���������</td>
<td width=5% class=vertical>����������� �������<br> �����������</td>

<td width=5% class=vertical>����� ������������ /<br> �����������������<br> �����</td>
<td width=5% class=vertical>����� �������� /<br> �����������������<br> �����������</td>
<td width=5% class=vertical>������� � ���������</td>
<td width=5% class=vertical>���������� �����������</td>
<td width=5% class=vertical>��������� �������,<br> ������������� ��<br> ���� ������������</td>
<td width=5% class=vertical>��������� �������,<br> ������������� ��<br> ���� ���������</td>

</tr>
$deprows
</table>

<p><i>����������</i><br>
����������� ������ ��������� ����������, ���� ��������� ��� �������������� �������� ��������. ��������� ������ � ���� ������ ������������� ��������� �� ��������� ����������� ������.<br>
���������� ������������ ������� � ������ ��������, ��� � ������� ���� ���� ��������������� ������������� � ������� �� �������������.
</p>

";
}

}

return $out;

} // fPageDepActivity 

function fPageTotalActivity() {

$year = (!isset($_GET["year"]))? $year = date("Y") : $year = (int)$_GET["year"];

// ===================================================================

$rmonths = ""; $arrm = array("������","�������","����","������","���","����","����","������","��������","�������","������","�������");
$rdec = "";
for ($i = 0; $i<12; $i++) {
	$rmonths .= "<td colspan=3>".$arrm[$i]."</td>";
	$rdec .= "<td width=2.4%>I</td><td width=2.4%>II</td><td width=2.4%>III</td>";
}


$depactivity = array();
$q = "SELECT `id`, `start_date`, (MONTH(`start_date`)-1)*3 + ROUND(DAY(`start_date`)/10)+1 as decade FROM `ka_periods` WHERE YEAR(`start_date`) = '$year'";
//echo $q;
$r = mysql_query($q);
while (list($pid,$pstart,$pdecnum) = mysql_fetch_array($r)) {
	$qq = "SELECT `dep_id`,`is_closed` FROM `ka_dep_periods` WHERE `period_id`='$pid'";
//echo $qq;
	$rr = mysql_query($qq);
	while (list($did,$pstatus) = mysql_fetch_array($rr)) {
		$depactivity[$did][$pdecnum]["pid"] = $pid;
		$depactivity[$did][$pdecnum]["status"] = $pstatus;
		$depactivity[$did][$pdecnum]["cnt"]    = fCalcActions($did,$pid);

	}

	$periods[$pdecnum] = array($pstart,$pend);
}

//print_r($depactivity);

$datarows = "";
$q = "SELECT `id`,`code`,`name` FROM `dep` WHERE `id_deptype`='30278001' ORDER BY `code` ASC";
$r = mysql_query($q);
while (list($did,$dcode,$dname) = mysql_fetch_array($r)) {
	$datarows .= "<tr align=center><td align=left><nobr>&nbsp; <a href=./index.php?act=reports&report=cafedra&page=depactivity&did=$did title='$dname'>$dcode</a></nobr></td>";

	for ($i=1;$i<=36;$i++) {


		if (!isset($periods[$i])) {
			$cellvalue = " &nbsp; ";
		} elseif (!isset($depactivity[$did][$i]["status"])) {
			$cellvalue = " x ";
		} elseif ($depactivity[$did][$i]["status"] == 2) {
			$cellvalue = " - ";
		} elseif (($depactivity[$did][$i]["status"] == 0) AND ($depactivity[$did][$i]["cnt"]==0)) {
			$cellvalue = " - ";
		} elseif (($depactivity[$did][$i]["cnt"] > 0) AND ($depactivity[$did][$i]["status"] == 1)){
			$cellvalue = "<a href=/index.php?act=reports&report=cafedra&page=depreport&dep=$did&start=".$depactivity[$did][$i]["pid"]."&end=".$depactivity[$did][$i]["pid"].">".$depactivity[$did][$i]["cnt"]."</a>";
		} else {
			$cellvalue = $depactivity[$did][$i]["cnt"];
		}

		$datarows .= "<td>$cellvalue</td>";
	}

	$datarows .= "</tr>\n";
		
}

$out = fYearList()."<h5 align=center>����� �� ���������� ������������� ��� \"�������\" �� $year ���</h5>
<table width=100% cellspacing=0 cellpadding=0 border=1>
<tr align=center><td rowspan=2 width=13.6%>�������</td>$rmonths</tr>
<tr align=center>$rdec</tr>
$datarows
</table>

<p><i>����������</i><br>
<b>-</b> - ����������� ������ �� ��� ������ �������������<br> 
<b>x</b> - �� ����������� ������ ������������ �� ������ � �������<br> 
<b>0</b> - ����������� ������ ��� ������ �������������, �� ������ � ������� ������� ������� �� ����<br> 
����������� ������ ������������ ������� �������� �� ������, ���� ����������� ������ ��� ������.
</p>
<p></p>
";

return $out;

} // fPageTotalActivity


// other functions 

function fPeriodList() {
	
	$q = "SELECT `id`,DATE_FORMAT(`start_date`,'%d.%m.%Y'),DATE_FORMAT(`end_date`,'%d.%m.%Y') FROM `ka_periods` ORDER BY `start_date` ASC";
	$r = mysql_query($q);
	while (list($pid,$pstart,$pend) = mysql_fetch_array($r)) {
		$ssel = ($pid == $_GET["start"])? " selected" : "";
		$esel = ($pid == $_GET["end"])? " selected" : "";
		$startopts .= "<option value=$pid$ssel>$pstart</option>";
		$endopts   .= "<option value=$pid$esel>$pend</option>";
	}

	$form = "
	<form action=./index.php method=GET>
	<div align=right>
	<input type=hidden name=act value=reports>
	<input type=hidden name=report value=cafedra>
	<input type=hidden name=page value=data>
	�������� ���������� ������� �� ������ � 
	<select name=start>$startopts</select>
	��
	<select name=end>$endopts</select>
	<input type=submit value=' -> '>
	</div>
	</form>
	";

	return $form;

}

function fDepList($depid = 0) {

	$deprows = "";
	$q = "SELECT `id`,`code` FROM `dep` WHERE `id_deptype`='30278001' ORDER BY `code` ASC";
	$r = mysql_query($q);
	while (list($did,$dname) = mysql_fetch_array($r)) {
		$issel = ($depid == $did)? " selected" : "";
		$deprows .= "<option value=$did$issel>$dname</option>\n";
	}

	return "
	<form action=./index.php method=GET>
	<input type=hidden name=act value=reports>
	<input type=hidden name=report value=cafedra>
	<input type=hidden name=page value=depactivity>
	�������� ��������� ������������: 
	<select name=did>
	<option value=0>�������� ������������� �� ������</option> 
	$deprows
	</select>
	<input type=submit value=' -> '>
	</form>
	";

}

function fYearList() {


	$years = "";
	$q = "SELECT DISTINCT YEAR(`end_date`) as y FROM `ka_periods` ORDER BY y DESC";
	$r = mysql_query($q);
	while (list($year) = mysql_fetch_array($r)) {
		$ysel = ($year == $_GET["year"])? " selected" : "";
		$years .= "<option value=$year$ysel>$year</option>";
	}
	

	$form = "
	<form action=./index.php method=GET>
	<div align=right>
	<input type=hidden name=act value=reports>
	<input type=hidden name=report value=cafedra>
	<input type=hidden name=page value=totalactivity>
	�������� ����� �� ���������� �� 
	<select name=year>$years</select> ��� 
	<input type=submit value=' -> '>
	</div>
	</form>
	";

	return $form;

}

function fCalcActions($did,$pid) {


	$num = array();

    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_trips 	a WHERE a.dep_id=$did AND period_id='$pid' GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_visits 	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_edu a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_staff a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_ank_stud  a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));

    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_publ   	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_st_contests   	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_staff_contests   	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_measures  	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
 
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_cources	  a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_laboratories	  a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_exhibitions  	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_educ_techn  	a WHERE a.dep_id=$did AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_assets    a WHERE a.dep_id=$did AND a.fin_source = '0' AND period_id='$pid'  GROUP BY a.dep_id"));
    list($num[]) = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ka_assets    a WHERE a.dep_id=$did AND a.fin_source = '1' AND period_id='$pid'  GROUP BY a.dep_id"));

	return array_sum($num);

}

?>