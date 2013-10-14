<?php

function fCafedraReport($did,$pstart,$pend,$isclosed = 1) {

/*
$did  	= (int)$_GET["dep"];
$pstart = (int)$_GET["start"];
$pend	= (int)$_GET["end"];
*/

$q = "SELECT `name` FROM `dep` WHERE `id`='$did' AND `id_deptype`='30278001'";
$r = mysql_query($q);
if (mysql_num_rows($r) == 0) { 
	$out .= "Подразделение не найдено";
} else {
	list($dname) = mysql_fetch_array($r);
	$q = "SELECT `id`, DATE_FORMAT(`start_date`,'%d-%m-%Y') FROM `ka_periods` WHERE `id`='$pstart'";
	$r = mysql_query($q);
	list($pstart,$pstartdate) = mysql_fetch_array($r);

	$q = "SELECT `id`, DATE_FORMAT(`end_date`,'%d-%m-%Y') FROM `ka_periods` WHERE `id`='$pend'";
	$r = mysql_query($q);
	list($pend,$penddate) = mysql_fetch_array($r);

	if (($pstart == 0) OR ($pend == 0) OR ($pstart > $pend)) {
		$out .= "Запрошен неверный период";
	} else {
		$out .= "<h4>$dname<br>\nОтчет о деятельности подразделения за период с $pstartdate по $penddate</h4>";

//		$out .= fReportPps("Профессорско-преподавательский состав",$did,$pstart,$pend);
//		$out .= fReportUvp("Учебно-вспомогательный персонал",$did,$pstart,$pend);
		$out .= fReportTrips("Научные поездки",$did,$pstart,$pend,$isclosed);
		$out .= fReportVisits("Контрольные посещения",$did,$pstart,$pend,$isclosed);
		$out .= fReportAnkEducQuality("Уровень качества преподавания",$did,$pstart,$pend,$isclosed);
		$out .= fReportAnkStaffSat("Анкетирование удовлетворенности работников",$did,$pstart,$pend,$isclosed);
		$out .= fReportAnkStudSat("Анкетирование удовлетворенности студентов",$did,$pstart,$pend,$isclosed);
		$out .= fReportPublScience("Опубликованные научные работы",$did,$pstart,$pend,$isclosed);
		$out .= fReportStudConc("Участие студентов в конкурсах",$did,$pstart,$pend,$isclosed);
		$out .= fReportStaffConc("Участие работников в конкурсах",$did,$pstart,$pend,$isclosed);
		$out .= fReportMeasures("Проведенные научные мероприятия",$did,$pstart,$pend,$isclosed);
		$out .= fReportCources("Вновь поставленные / модернизированные курсы",$did,$pstart,$pend,$isclosed);
		$out .= fReportLabs("Вновь открытые / модернизированные лаборатории",$did,$pstart,$pend,$isclosed);
		$out .= fReportExhibitions("Участие в выставках",$did,$pstart,$pend,$isclosed);
		$out .= fReportEducTechnologies("Технологии образования",$did,$pstart,$pend,$isclosed);
		$out .= fReportActives("Получение кафедрой активов, приобретенных за счет средств университета",$did,$pstart,$pend,0,$isclosed);
		$out .= fReportActives("Получение кафедрой активов, приобретенных за счет средств спонсоров",$did,$pstart,$pend,1,$isclosed);


		$out .= "<p></p>";
	}
} 

return $out;
} 


// ================================================================================================

function fReportPps($header,$did,$pstart,$pend,$isclosed = 1) {
	
	$trows = "";
	$query_ka_periods = mysql_query("SELECT end_date, start_date FROM ka_periods WHERE id >= '$pstart' AND id <= '$pend'");
	$result_ka_periods = mysql_fetch_array($query_ka_periods);
	$start_date = $result_ka_periods[start_date];
    $end_date = $result_ka_periods[end_date];
	$query_depstaff = "SELECT DISTINCT s.id, s.shortname FROM staff s, depstaff ds WHERE ds.id_dep = '$did' AND ds.id_officercls = '85036001' AND s.id=ds.id_staff ORDER BY s.shortname ASC";
	$result_depstaff = mysql_query($query_depstaff);
	$i = 1;
	while (list($id_staff,$shortname) = mysql_fetch_array($result_depstaff)) {
		$query_staffed = mysql_query("SELECT id_staff, id_edtype, DATE_FORMAT(begdate,'%d.%m.%Y') as eurodatebeg, DATE_FORMAT(enddate,'%d.%m.%Y') as eurodateend FROM staffed WHERE id_staff = $id_staff AND edsign IN(3,8) AND DATE(begdate) >= '$start_date' AND DATE(enddate) <= '$end_date' ORDER BY id ASC");
		$sum_staff_pps++;
	// Место прохождения стажировки / повышения квалификации
	    while($result_staffed = mysql_fetch_array($query_staffed))
        {
		 $br = "<br>";
		 $tire = "&nbsp;-&nbsp;";
		 $id_edtype = $result_staffed[id_edtype];
		 $date_staffed = $date_staffed.$result_staffed[eurodatebeg].$tire.$result_staffed[eurodateend].$br;
         switch($id_edtype)
         {
          case 253361021:
            $strana = "В России";
			$rus++;
            break;
          case 253361172:
            $strana = "За рубежом";
			$za_rub++;
            break;
		 }
		 $mesto = $mesto.$strana.$br;
		 $sum_staffed = $rus+$za_rub;
		}
		if(empty($mesto)) $mesto = "&nbsp;";
		if(empty($date_staffed)) $date_staffed = "&nbsp;";


		$query_ka_trips = mysql_query("SELECT place, DATE_FORMAT(start_date,'%d.%m.%Y') as eurodatestart, DATE_FORMAT(end_date,'%d.%m.%Y') as eurodateend FROM ka_trips WHERE staff_id = $id_staff AND period_id >= '$pstart' AND period_id <= '$pend'");		
	// Место научной поездки
	    while($result_ka_trips = mysql_fetch_array($query_ka_trips))
        {
		 
		 $br = "<br>";
		 $tire = "&nbsp;-&nbsp;";
		 $place = $place.$result_ka_trips[place].$br;
		 $date_trips = $date_trips.$result_ka_trips[eurodatestart].$tire.$result_ka_trips[eurodateend].$br;
		 $sum_place++;
		}
		if(empty($place)) $place = "&nbsp;";
		if(empty($date_trips)) $date_trips = "&nbsp;";
		
			
		$query_ka_visits = mysql_query("SELECT mark_id , DATE_FORMAT(visit_date,'%d.%m.%Y') as eurodatefill FROM ka_visits WHERE staff_id = $id_staff AND period_id >= '$pstart' AND period_id <= '$pend'");		
	// Оценка по результатам контрольного или взаимного посещения
	    $result_ka_visits = mysql_fetch_array($query_ka_visits);
		$mark_id = $result_ka_visits[mark_id];
		$ka_visits = $result_ka_visits[eurodatefill];
		if(empty($mark_id)) $mark_id = "&nbsp;";
		if(empty($ka_visits)) $ka_visits = "&nbsp;";
		
		
		$query_edstatus = mysql_query("SELECT id_edstatus FROM staff WHERE id = $id_staff");		
	// РАН, АН

	    $result_edstatus = mysql_fetch_array($query_edstatus);
		$edstatus = $result_edstatus[id_edstatus];
// ran

    $qran = "SELECT es.name FROM staffed se, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939185 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";
    $rran = mysql_query($qran);
    if (mysql_num_rows($rran) > 0) {
	list ($ran) = mysql_fetch_array($rran);
	$sum_ran++;
    } else {
	$ran = "&nbsp;";
    }
    
// otr an


    $q_an = "SELECT es.name, ei.name FROM staffed se LEFT JOIN edinst ei ON se.id_edinst = ei.id, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939309 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";

    $r_an = mysql_query($q_an);
    if (mysql_num_rows($r_an) > 0) {
	list ($an,$an_name) = mysql_fetch_array($r_an);
	$sum_an++;
	$an = $an." ($an_name)";
    } else {
	$an = "&nbsp;";
    }

    $qran = "SELECT es.name FROM staffed se, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939185 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";
    $rran = mysql_query($qran);
    if (mysql_num_rows($rran) > 0) {
	list ($ran) = mysql_fetch_array($rran);
	$sum_ran++;
    } else {
	$ran = "&nbsp;";
    }

    $qoth = "SELECT es.name FROM staffed se, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939334 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";
    $roth = mysql_query($qoth);
    if (mysql_num_rows($roth) > 0) {
	list ($oth) = mysql_fetch_array($roth);
	$sum_oth++;
    } else {
	$oth = "&nbsp;";
    }




		$query_staffaward = mysql_query("SELECT id_award FROM staffaward WHERE id_staff = $id_staff");		
	// Награды и поощрения
	    while($result_staffaward = mysql_fetch_array($query_staffaward))
        {
		 $staffaward = $result_staffaward[id_award];
		 $query_award = mysql_query("SELECT name, id_awardtype FROM award WHERE id = $staffaward");
		 while($result_award = mysql_fetch_array($query_award))
		 {
		  $br = "<br>";
		  $sum_award++;
		  $award = $award.$result_award[name].$br;
		  $id_awardtype = $result_award[id_awardtype];
		  $query_awardtype = mysql_query("SELECT code FROM awardtype WHERE id = $id_awardtype");
		  while($result_awardtype = mysql_fetch_array($query_awardtype))
		  {
		   $br = "<br>";
		   $sum_awardtype++;
		   $awardtype = $awardtype.$result_awardtype[code].$br;   
		  }
		 }
		}
		$award = $award.$awardtype;
		$sum_award_awardtype = $sum_award + $sum_awardtype;
		if(empty($award)) $award = "&nbsp;";




		
		
		
		$trows .= "
		<tr>
		<td align=center>$i</td>
		<td>$shortname</td>
		<td valign=\"top\">$mesto</td>
		<td valign=\"top\">$date_staffed</td>
		<td width=\"$width\" valign=\"top\">$place</td>
		<td valign=\"top\">$date_trips</td>
		<td>$mark_id</td>
		<td>$ka_visits</td>
		<td valign=\"top\">$ran</td>
		<td>$an</td>
		<td valign=\"top\">$oth</td>
		<td valign=\"top\">$award</td>
		</tr>";
		$id_edtype = "";
		$mesto = "";
		$date_staffed = "";
		$place = "";
		$date_trips = "";
		$mark_id = "";
		$ka_visits = "";
		$ran = "";
		$an = "";
		$oth = "";
		$award = "";
		$awardtype = "";
		$i++;
		if(empty($sum_staff_pps)) $sum_staff_pps = "0";
		if(empty($sum_place)) $sum_place = "0";		 
		if(empty($sum_ran)) $sum_ran = "0";
		if(empty($sum_an)) $sum_an = "0";
		if(empty($sum_oth)) $sum_oth = "0";
		if(empty($sum_award_awardtype)) $sum_award_awardtype = "0";
		if(empty($sum_staffed)) $sum_staffed = "0";
		if(empty($rus)) $rus = "0";
		if(empty($za_rub)) $za_rub = "0";
	}

	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td>№ п/п</td>
	<td>Фамилия И.О. работника</td>
	<td>Место прохождения стажировки / повышения квалификации</td>
	<td width=\"165\">Время прохождения стажировки / повышения квалификации</td>
	<td>Место научной поездки</td>
	<td width=\"165\">Время научной поездки</td>
	<td>Оценка по результатам контрольного или взаимного посещения</td>
	<td>Дата проведения контрольного или взаимного посещения</td>
	<td>Звание РАН</td>
	<td>Звания общественных академий</td>
	<td>Другие звания</td>
	<td>Награды и поощрения</td>
	</tr>
	$trows
    <tr>
    <td colspan=\"2\">&Sigma; ППС - $sum_staff_pps</td>
    <td colspan=\"2\">&Sigma; стажировок / повышений квалификации - $sum_staffed, в .т.ч. в России - $rus, за рубежом - $za_rub</td>
    <td colspan=\"2\">&Sigma; научных поездок - $sum_place</td>
    <td colspan=\"2\">&nbsp;</td>
    <td width=\"99\">&Sigma; званий РАН - $sum_ran</td>
    <td width=\"109\">&Sigma; званий общественных    академий - $sum_an</td>
    <td width=\"60\">&Sigma; других званий - $sum_oth</td>
    <td width=\"86\">&Sigma; наград и поощрений - $sum_award_awardtype</td>
    </tr>
	</table>
	";

}

function fReportUvp($header,$did,$pstart,$pend,$isclosed = 1) {
	
	$trows = "";
	$query_ka_periods = mysql_query("SELECT end_date, start_date FROM ka_periods WHERE id >= '$pstart' AND id <= '$pend'");
	$result_ka_periods = mysql_fetch_array($query_ka_periods);
	$start_date = $result_ka_periods[start_date];
    $end_date = $result_ka_periods[end_date];
	$query_depstaff = "SELECT s.id, s.shortname FROM staff s, depstaff ds WHERE ds.id_dep = '$did' AND ds.id_officercls = '85037001' AND s.id=ds.id_staff ORDER BY s.shortname ASC";
	$result_depstaff = mysql_query($query_depstaff);
	$i = 1;
	while (list($id_staff,$shortname) = mysql_fetch_array($result_depstaff)) {
		$query_staffed = mysql_query("SELECT id_staff, id_edtype, DATE_FORMAT(begdate,'%d.%m.%Y') as eurodatebeg, DATE_FORMAT(enddate,'%d.%m.%Y') as eurodateend FROM staffed WHERE id_staff = $id_staff AND edsign IN(3,8) AND DATE(begdate) >= '$start_date' AND DATE(enddate) <= '$end_date' ORDER BY id ASC");
		$sum_staff_uvp++;
	// Место прохождения стажировки / повышения квалификации
	    while($result_staffed = mysql_fetch_array($query_staffed))
        {
		 $br = "<br>";
		 $tire = "&nbsp;-&nbsp;";
		 $sum_staffed++;
		 $id_edtype = $result_staffed[id_edtype];
		 $date_staffed = $date_staffed.$result_staffed[eurodatebeg].$tire.$result_staffed[eurodateend].$br;
         switch($id_edtype)
         {
          case 253361021:
            $strana = "В России";
			$rus++;
            break;
          case 253361172:
            $strana = "За рубежом";
			$za_rub++;
            break;
		 }
		 $mesto = $mesto.$strana.$br;
		 $sum_staffed = $rus+$za_rub;
		}
		if(empty($mesto)) $mesto = "&nbsp;";
		if(empty($date_staffed)) $date_staffed = "&nbsp;";


		$query_ka_trips = mysql_query("SELECT place, DATE_FORMAT(start_date,'%d.%m.%Y') as eurodatestart, DATE_FORMAT(end_date,'%d.%m.%Y') as eurodateend FROM ka_trips WHERE staff_id = $id_staff AND period_id >= '$pstart' AND period_id <= '$pend'");		
	// Место научной поездки
	    while($result_ka_trips = mysql_fetch_array($query_ka_trips))
        {
		 $br = "<br>";
		 $tire = "&nbsp;-&nbsp;";
		 $place = $place.$result_ka_trips[place].$br;
		 $date_trips = $date_trips.$result_ka_trips[eurodatestart].$tire.$result_ka_trips[eurodateend].$br;
		 $sum_place++;
		}
		if(empty($place)) $place = "&nbsp;";
		if(empty($date_trips)) $date_trips = "&nbsp;";
		
		
		$query_edstatus = mysql_query("SELECT id_edstatus FROM staff WHERE id = $id_staff");		
	// Ран
// ran

    $qran = "SELECT es.name FROM staffed se, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939185 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";
    $rran = mysql_query($qran);
    if (mysql_num_rows($rran) > 0) {
	list ($ran) = mysql_fetch_array($rran);
	$sum_ran++;
    } else {
	$ran = "&nbsp;";
    }
    
// otr an

    $q_an = "SELECT es.name FROM staffed se, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939309 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";
    $r_an = mysql_query($q_an);
    if (mysql_num_rows($r_an) > 0) {
	list ($an) = mysql_fetch_array($r_an);
	$sum_an++;
    } else {
	$an = "&nbsp;";
    }

    $qoth = "SELECT es.name FROM staffed se, edstatus es WHERE se.edsign=1 AND es.id_edstatustype=226939334 AND se.id_edstatus=es.id AND se.id_staff=$id_staff ORDER BY se.doc_when DESC LIMIT 0,1";
    $roth = mysql_query($qoth);
    if (mysql_num_rows($roth) > 0) {
	list ($oth) = mysql_fetch_array($roth);
	$sum_oth++;
    } else {
	$oth = "&nbsp;";
    }



		$query_staffaward = mysql_query("SELECT id_award FROM staffaward WHERE id_staff = $id_staff");		
	// Награды и поощрения
	    while($result_staffaward = mysql_fetch_array($query_staffaward))
        {
		 $staffaward = $result_staffaward[id_award];
		 $query_award = mysql_query("SELECT name, id_awardtype FROM award WHERE id = $staffaward");
		 while($result_award = mysql_fetch_array($query_award))
		 {
		  $br = "<br>";
		  $sum_award++;
		  $award = $award.$result_award[name].$br;
		  $id_awardtype = $result_award[id_awardtype];
		  $query_awardtype = mysql_query("SELECT code FROM awardtype WHERE id = $id_awardtype");
		  while($result_awardtype = mysql_fetch_array($query_awardtype))
		  {
		   $br = "<br>";
		   $sum_awardtype++;
		   $awardtype = $awardtype.$result_awardtype[code].$br;   
		  }
		 }
		}
		$award = $award.$awardtype;
		$sum_award_awardtype = $sum_award + $sum_awardtype;
		if(empty($award)) $award = "&nbsp;";

		$trows .= "
		<tr>
		<td align=center>$i</td>
		<td>$shortname</td>
		<td>$mesto</td>
		<td>$date_staffed</td>
		<td>$place</td>
		<td>$date_trips</td>
		<td>$an</td>
		<td>$oth</td>
		<td>$award</td>
		</tr>";
		
		$id_edtype = "";
		$date_staffed = "";
		$place = "";
		$date_trips = "";
		$an = "";
		$oth = "";
		$award = "";
		$awardtype = "";
		$mesto = "";
		$i++;
		if(empty($sum_staff_pps)) $sum_staff_pps = "0";
		if(empty($sum_place)) $sum_place = "0";		 
		if(empty($sum_an)) $sum_an = "0";
		if(empty($sum_oth)) $sum_oth = "0";
		if(empty($sum_staffed)) $sum_staffed = "0";
		if(empty($rus)) $rus = "0";
		if(empty($za_rub)) $za_rub = "0";
	}

	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td>№ п/п</td>
	<td>Фамилия И.О. работника</td>
	<td>Место прохождения стажировки / повышения квалификации</td>
	<td>Время прохождения стажировки / повышения квалификации</td>
	<td>Место научной поездки</td>
	<td>Время научной поездки</td>
	<td>Звания общественных академий</td>
	<td>Другие звания</td>
	<td>Награды и поощрения</td>
	</tr>
	$trows
    <tr>
    <td colspan=\"2\"><p>&Sigma; УВП - $sum_staff_uvp</p></td>
    <td width=\"202\" colspan=\"2\">&Sigma; стажировок / повышений квалификации - $sum_staffed, в .т.ч. в России - $rus, за рубежом - $za_rub</td>
    <td width=\"166\" colspan=\"2\">&Sigma; научных поездок - $sum_place</td>
    <td width=\"98\">&Sigma; званий общественных    академий - $sum_an</td>
    <td width=\"71\">&Sigma; других званий - $sum_oth</td>
    <td width=\"78\">&Sigma; наград и поощрений $sum_award_awardtype</td>
    </tr>
	</table>
	";

}

function fReportTrips($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT s.shortname, t.aim, t.result, DATE_FORMAT(t.start_date,'%d.%m.%Y'), DATE_FORMAT(t.end_date,'%d.%m.%Y'), t.place, tt.name FROM ka_trips t, ka_trip_types tt, staff s, ka_dep_periods dp WHERE dp.period_id=t.period_id AND dp.dep_id=t.dep_id AND s.id=t.staff_id AND tt.id = t.trip_type_id AND t.dep_id='$did' AND (t.period_id >= '$pstart') AND (t.period_id <= '$pend') AND (dp.is_closed=$isclosed) ORDER BY t.id ASC";
	$r = mysql_query($q);
	$i = 1;
	while (list($sname,$aim,$result,$sdate,$edate,$place,$type) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td align=center>$i</td>
		<td>$sname</td>
		<td>$aim</td>
		<td>&nbsp; $result</td>
		<td>$sdate - $edate</td>
		<td>$place</td>
		<td>$type</td>
		</tr>";
		$i++;
	}

	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td>№ п/п</td>
	<td>Работник</td>
	<td>Цель поездки</td>
	<td>Результат поездки</td>
	<td>Срок</td>
	<td>Место</td>
	<td>Тип</td>
	</tr>
	$trows
	</table>
	";

}

function fReportVisits($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT v.id, s.shortname,  DATE_FORMAT(v.visit_date,'%d.%m.%Y'), m.name FROM staff s, ka_visits v, ka_marks m, ka_dep_periods dp WHERE v.mark_id=m.id AND v.dep_id='$did' AND s.id=v.staff_id AND v.period_id=dp.period_id AND v.dep_id=dp.dep_id AND (v.period_id >= '$pstart') AND (v.period_id <= '$pend') AND (dp.is_closed=$isclosed) ORDER BY v.id ASC";
	$r = mysql_query($q);
	$i = 1;
	while (list($vid, $sname,$vdate,$mark) = mysql_fetch_array($r)) {
		$visitors = "";
		$qq = "SELECT s.shortname FROM staff s, ka_visit_staff vs WHERE s.id=vs.staff_id AND vs.visit_id=$vid";
		$rr = mysql_query($qq);
		while (list($vname) = mysql_fetch_array($rr)) {$visitors .= $vname."<br>";}
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$sname</td>
		<td>$visitors</td>
		<td>$vdate</td>
		<td>$mark</td>
		</tr>";
		$i++;
	}

	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Посещаемый</td>
	<td>Посетители</td>
	<td>Дата</td>
	<td>Оценка</td>
	</tr>
	$trows
	</table>
	";

}

function fReportAnkEducQuality($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT a.id, a.group_id, a.students_num, DATE_FORMAT(a.date,'%d.%m.%Y') as adate, a.ok_prep_num, a.all_prep_num FROM ka_ank_edu a, ka_dep_periods dp WHERE a.dep_id='$did' AND a.dep_id=dp.dep_id AND a.period_id=dp.period_id AND (a.period_id >= '$pstart') AND (a.period_id <= '$pend') AND (dp.is_closed=$isclosed) ORDER BY adate ASC, a.group_id ASC";
	$r = mysql_query($q);
	$i = 1;
	$level = array();
	while (list($aid, $gid,$studnum,$adate,$okprepnum,$allprepnum) = mysql_fetch_array($r)) {

		$np = array();
		$qq = "SELECT `num_ok` FROM ka_ank_edu_i WHERE `id`='$aid'";
		$rr = mysql_query($qq);
		while (list($numok) = mysql_fetch_array($rr)) {
			$np[] = $numok;
		}
		$level[$i] = round(array_sum($np)/($allprepnum * $studnum) * 1000)/1000;
		$trows .= "
		<tr align=center>
		<td>$i</td>
		<td>$gid</td>
		<td>$studnum</td>
		<td>$adate</td>
		<td>".$level[$i]."</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td>№ п/п</td>
	<td>Номер группы</td>
	<td>Количество анкетируемых студентов</td>
	<td>Дата анкетирования</td>
	<td>Уровень качества преподавания<br>\nпо результатам анкетирования</td>
	</tr>
	$trows
	<tr align=center><td colspan=4>Среднее значение</td><td>".(@round(array_sum($level)/($i-1)*1000)/1000)."</td></tr>
	</table>
	";
}

function fReportAnkStaffSat($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT a.id, a.staff_num, a.quest_num, DATE_FORMAT(a.date,'%d.%m.%Y') as adate FROM ka_ank_staff a, ka_dep_periods dp WHERE a.dep_id='$did' AND a.dep_id=dp.dep_id AND a.period_id=dp.period_id AND (a.period_id >= '$pstart') AND (a.period_id <= '$pend') AND (dp.is_closed=$isclosed) ORDER BY adate ASC";
	$r = mysql_query($q);
	$i = 1;
	$level = array();
	while (list($aid,$num,$questnum,$adate) = mysql_fetch_array($r)) {

		$np = array();
		$qq = "SELECT `ok_num` FROM ka_ank_staff_i WHERE `id`='$aid'";
		$rr = mysql_query($qq);
		while (list($numok) = mysql_fetch_array($rr)) {
			$np[] = $numok;
		}
		$level[$i] = round(array_sum($np)/($num * $questnum) * 1000)/1000;

		$trows .= "
		<tr align=center>
		<td>$i</td>
		<td>$num</td>
		<td>$adate</td>
		<td>".$level[$i]."</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td>№ п/п</td>
	<td>Количество анкетируемых работников</td>
	<td>Дата анкетирования</td>
	<td>Удовлетворенность работников</td>
	</tr>
	$trows
	<tr align=center><td colspan=3>Среднее значение</td><td>".(@round(array_sum($level)/($i-1)*1000)/1000)."</td></tr>
	</table>
	";
}

function fReportAnkStudSat($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT a.id, a.group, a.stud_num, DATE_FORMAT(a.date,'%d.%m.%Y') as adate, a.quest_num FROM ka_ank_stud a, ka_dep_periods dp WHERE a.dep_id='$did' AND a.dep_id=dp.dep_id AND a.period_id=dp.period_id AND (a.period_id >= '$pstart') AND (a.period_id <= '$pend') AND (dp.is_closed=$isclosed) ORDER BY adate ASC, a.group ASC";
	$r = mysql_query($q);
	$i = 1;
	$level = array();
	while (list($aid,$gid,$studnum,$adate,$questnum) = mysql_fetch_array($r)) {

		$np = array();
		$qq = "SELECT `ok_num` FROM ka_ank_stud_i WHERE `id`='$aid'";
		$rr = mysql_query($qq);
		while (list($numok) = mysql_fetch_array($rr)) {
			$np[] = $numok;
		}
		$level[$i] = round(array_sum($np)/($studnum * $questnum) * 1000)/1000;

		$trows .= "
		<tr align=center>
		<td>$i</td>
		<td>$gid</td>
		<td>$studnum</td>
		<td>$adate</td>
		<td>".$level[$i]."</td>
		</tr>";
		$i++;
	}

	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td>№ п/п</td>
	<td>Номер группы</td>
	<td>Количество анкетируемых студентов</td>
	<td>Дата анкетирования</td>
	<td>Удовлетворенность студентов</td>
	</tr>
	$trows
	<tr align=center><td colspan=4>Среднее значение</td><td>".(@round(array_sum($level)/($i-1)*1000)/1000)."</td></tr>
	</table>
	";
}

function fReportPublScience($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT d.code, p.id, p.author, p.name, p.year, p.volume, 
		p.pagestotal, p.pages, l.name, p.type_id, pt.name, f.name, s.sid, s.sname, t.tname,
		p.city, p.editor, pl.name,
		p.journal, p.journal_num,
		p.depository, p.regnum,
		cl.name,
		p.conference, p.time  

		FROM dep d, ka_publ p LEFT JOIN ka_publ_levels pl ON p.pub_level=pl.id LEFT JOIN ka_contest_levels cl ON p.level=cl.id, ka_lang l, dict_spec s, dict_trend t, ka_publ_types pt, ka_publ_forms f, ka_dep_periods dp 

		WHERE p.dep_id='$did' 
		AND d.id=p.dep_id
		AND p.dep_id=dp.dep_id 

		AND p.lang_id = l.id
		AND p.spec_id = s.sid
		AND p.trend_id = t.tid
		AND p.type_id = pt.id
		AND p.form_id = f.id
		AND p.period_id=dp.period_id 

		AND (p.period_id >= '$pstart') AND (p.period_id <= '$pend') AND (dp.is_closed=$isclosed) 

		ORDER BY d.code, p.author ASC";


//echo $q;
	$r = mysql_query($q);
	$i = 1;

//	while (list($aid,$author,$name,$year,$volume,$pages,$lname,$vid,$form,$sid,$sname,$tname) = mysql_fetch_array($r)) {

	while (list($dep,$aid,$author,$name,$year,$volume,$pagestotal,$pages,$lname,
			$vidid,$vid,$form,$sid,$sname,$tname,
			$city, $editor,$publevel,$journal,$journal_num,
			$deposit, $regnum,
			$publevel2,
			$conf, $conftime
			) = mysql_fetch_array($r)) {

		
		$authorstable = "<table border=0 cellspacing=0 cellpadding=0 width=100%>";
		$qa = "SELECT ps.type_Id, ps.staff_id, s.shortname, ps.author FROM ka_publ_staff ps LEFT JOIN staff s ON ps.staff_id=s.id WHERE ps.publ_id = $aid ORDER BY ps.order_number ASC"; 
		$ra = mysql_query($qa);
		while (list($atype,$astaffid,$ashortname,$aauthor) = mysql_fetch_array($ra)) {
			if ($atype == 1) {
				$aname = $ashortname;
				$atypename = "работник кафедры";
			} else {
				$aname = $aauthor;
				switch ($atype) {
					case 2 : $atypename = "сторонний работник";break;
					case 3 : $atypename = "аспирант кафедры";break;
					case 4 : $atypename = "студент";break;
				}
			}
			
			$authorstable .= "<tr valign=top><td class=small><nobr>$aname &nbsp;</nobr></td><td class=small>$atypename</td></tr>";
		}
		$authorstable .= "</table>";

		$publev = "&nbsp;";
		switch ($vidid) {
			case 8  : $outpdata = "$city: $editor, $year - $pages с."; break;
			case 10 : $outpdata = "$journal $journal_num/$city: $editor, $year, с. $pages"; $publev=$publevel; break;
			case 9  :
			case 11 : $outpdata = "$city, $deposit, $regnum"; break;
			case 12 :
			case 13 : $outpdata = "$conf, $conftime, $city, $editor, $year, с. $pages"; $publev=$publevel2; break;
			case 14 : $outpdata = "$year г."; break;
			default : $outpdata = "-----"; break;
		}

		$trows .= "
		<tr valign=top align=center>
		<td class=small>$i</td>
		<td class=small>$author</td>
		<td class=small>$authorstable</td>
		<td class=small align=left>$name</td>
		<td class=small>$outpdata</td>
		<td class=small>$pagestotal</td>
		<td class=small>$volume</td>
		<td class=small>$lname</td>
		<td class=small>$form</td>
		<td class=small>$vid</td>
		<td class=small>$publev</td>
		<td class=small>$sid</td>
		<td class=small align=left>$tname</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td class=small>№ п/п</td>
	<td class=small>Авторы (КОНТРОЛЬНОЕ ПОЛЕ)</td>
	<td class=small>Авторы</td>
	<td class=small>Название публикации</td>
	<td class=small>Выходные данные</td>
	<td class=small>Кол-во страниц</td>
	<td class=small>Объем, п/л</td>
	<td class=small>Язык публикации</td>
	<td class=small>Форма публикации</td>
	<td class=small>Вид публикации</td>
	<td class=small>Уровень публикации</td>
	<td class=small>Шифр специальности</td>
	<td class=small>Научное направление</td>
	</tr>
	$trows
	</table>
	";
}



function fReportStudConc($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT c.student, c.group_id, s.shortname, c.name, c.spec_id, t.tname, c.grnti_id, c.contest, c.place, f.name, w.name, at.name, cl.name, ct.name, DATE_FORMAT(c.start_date,'%d.%m.%Y'), DATE_FORMAT(c.end_date,'%d.%m.%Y')

		FROM ka_st_contests c, ka_fin_source f, ka_work_types w, staff s, dict_trend t, ka_dep_periods dp, ka_award_types at, ka_contest_levels cl, ka_contest_types ct 

		WHERE dp.period_id=c.period_id 
		AND c.fin_source_id=f.id
		AND dp.dep_id=c.dep_id 
		AND c.trend_id = t.tid
		AND c.work_type_id = w.id
		AND c.award_id = at.id
		AND c.level_id = cl.id
		AND c.contest_type_id = ct.id
		AND s.id=c.staff_id 
		AND c.dep_id='$did' 
		AND (c.period_id >= '$pstart') AND (c.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		ORDER BY c.id ASC";
//echo $q;
	$r = mysql_query($q);
	$i = 1;
	while (list($sname,$gid,$sleader,$name,$spec,$trend,$grnti,$contest,$place,$finsource,$worktype,$award,$level,$form,$datestart,$dateend) = mysql_fetch_array($r)) {
		$trows .= "
		<tr valign=top align=center>
		<td class=small>$i</td>
		<td class=small>$sname</td>
		<td class=small>$gid</td>
		<td class=small>$sleader</td>
		<td class=small>&nbsp; $name</td>
		<td class=small>$worktype</td>
		<td class=small>$spec</td>
		<td class=small>$trend</td>
		<td class=small>$grnti</td>
		<td class=small>$form</td>
		<td class=small>$contest</td>
		<td class=small>$place<br><br>с $datestart по $dateend</td>
		<td class=small>$level</td>
		<td class=small>$award</td>
		<td class=small>$finsource</td>
		</tr>";
		$i++;

	}


	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td class=small>№ п/п</td>
	<td class=small>ФИО студента</td>
	<td class=small>Номер группы</td>
	<td class=small>ФИО научного руководителя</td>
	<td class=small>Название работы</td>
	<td class=small>Характер работы</td>
	<td class=small>Шифр специаль-ности</td>
	<td class=small>Научное направление</td>
	<td class=small>Код ГРНТИ</td>
	<td class=small>Форма проведения конкурса</td>
	<td class=small>Наименование конкурса</td>
	<td class=small>Место и время проведения</td>
	<td class=small>Уровень конкурса</td>
	<td class=small>Вид награды</td>
	<td class=small>Источник финансирования</td>
	</tr>
	$trows
	</table>
	";

}

function fReportStaffConc($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT c.author, c.name, c.spec_id, t.tname, c.grnti_id, c.contest, c.place, w.name, at.name, cl.name,  DATE_FORMAT(c.start_date,'%d.%m.%Y'), DATE_FORMAT(c.end_date,'%d.%m.%Y')

		FROM ka_staff_contests c, ka_work_types w, dict_trend t, ka_dep_periods dp, ka_award_types at, ka_contest_levels cl

		WHERE dp.period_id=c.period_id 
		AND dp.dep_id=c.dep_id 
		AND c.trend_id = t.tid
		AND c.work_type_id = w.id
		AND c.award_id = at.id
		AND c.level_id = cl.id
		AND c.dep_id='$did' 
		AND (c.period_id >= '$pstart') AND (c.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		ORDER BY c.id ASC";
//echo $q;
	$r = mysql_query($q);
	$i = 1;
	while (list($sname,$name,$spec,$trend,$grnti,$contest,$place,$worktype,$award,$level,$datestart,$dateend) = mysql_fetch_array($r)) {
		$trows .= "
		<tr valign=top align=center>
		<td class=small>$i</td>
		<td class=small>$sname</td>
		<td class=small>&nbsp; $name</td>
		<td class=small>$worktype</td>
		<td class=small>$spec</td>
		<td class=small>$trend</td>
		<td class=small>$grnti</td>
		<td class=small>$contest</td>
		<td class=small>$place<br><br>с $datestart по $dateend</td>
		<td class=small>$level</td>
		<td class=small>$award</td>
		</tr>";
		$i++;

	}


	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr align=center>
	<td class=small>№ п/п</td>
	<td class=small>ФИО работника</td>
	<td class=small>Название работы</td>
	<td class=small>Характер работы</td>
	<td class=small>Шифр специальности</td>
	<td class=small>Научное направление</td>
	<td class=small>Код ГРНТИ</td>
	<td class=small>Наименование конкурса</td>
	<td class=small>Место и время проведения</td>
	<td class=small>Уровень конкурса</td>
	<td class=small>Вид награды</td>
	</tr>
	$trows
	</table>
	";

}

function fReportMeasures($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT m.name, m.place, DATE_FORMAT(m.start_date,'%d.%m.%Y'), DATE_FORMAT(m.end_date,'%d.%m.%Y'), mt.name, cl.name, m.author, m.spec_id, t.tname
		FROM ka_measures m,  ka_measure_types mt, ka_dep_periods dp, ka_contest_levels cl, dict_trend t 
		WHERE dp.period_id=m.period_id 
		AND m.type_id=mt.id 
		AND m.level_id=cl.id 
		AND m.trend_id=t.tid 
		AND dp.dep_id=m.dep_id 
		AND m.dep_id='$did' 
		AND (m.period_id >= '$pstart') AND (m.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		ORDER BY m.start_date ASC";
	$r = mysql_query($q);
	$i = 1;
	while (list($name,$place,$sdate,$edate,$type,$level,$author,$spec,$trend) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$name</td>
		<td>$place</td>
		<td>$sdate - $edate</td>
		<td>$type</td>
		<td>$level</td>
		<td>$author</td>
		<td>$spec</td>
		<td>$trend</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Наименование мероприятия</td>
	<td>Место проведения</td>
	<td>Время проведения</td>
	<td>Вид мероприятия</td>
	<td>Уровень мероприятия</td>
	<td>ФИО участника</td>
	<td>Шифр специальности</td>
	<td>Научное направление</td>
	</tr>
	$trows
	</table>
	";

}

function fReportCources($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT c.name, ct.name, d.code, d.name, s.shortname, DATE_FORMAT(c.changedate,'%d.%m.%Y')
		FROM ka_cources c, ka_cource_types ct, dict_directions d, staff s, ka_dep_periods dp 
		WHERE c.dep_id='$did' 
		AND c.type_id=ct.id
		AND c.dep_id=dp.dep_id 
		AND c.dir_id=d.id 
		AND c.staff_id=s.id 
		AND c.period_id=dp.period_id 
		AND (c.period_id >= '$pstart') AND (c.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		ORDER BY c.name ASC";
	$r = mysql_query($q);
	$i = 1;
	while (list($name,$status,$scode,$sname,$author,$mdate) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$name</td>
		<td>$status</td>
		<td>$scode $sname</td>
		<td>$author</td>
		<td>$mdate</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Наименование курса</td>
	<td>Статус курса</td>
	<td>Направление подготовки или специальность</td>
	<td>Фамилия И.О. автора</td>
	<td>Дата изменения статуса</td>
	</tr>
	$trows
	</table>
	";
}

function fReportLabs($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT l.title, s.shortname, lt.name, ld.name
		FROM ka_laboratories l, staff s, ka_lab_types lt, ka_lab_def ld, ka_dep_periods dp 
		WHERE l.dep_id='$did' 
		AND l.staff_id=s.id 
		AND l.type_id=lt.id 
		AND l.lab_def_id=ld.id 
		AND l.dep_id=dp.dep_id 
		AND l.period_id=dp.period_id 
		AND (l.period_id >= '$pstart') AND (l.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		ORDER BY l.title ASC";
	$r = mysql_query($q);
	$i = 1;
	while (list($name,$zavlab,$type,$property) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$name</td>
		<td>$zavlab</td>
		<td>$type</td>
		<td>$property</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Наименование лаборатории</td>
	<td>Фамилия И.О. заведующего</td>
	<td>Вид лаборатории</td>
	<td>Отличительное свойство</td>
	</tr>
	$trows
	</table>
	";
}

function fReportExhibitions($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT e.exhibition, e.place, e.start_date, e.end_date, cl.name, e.author, e.name, a.name
		FROM ka_exhibitions e, ka_award_ex a, ka_contest_levels cl, ka_dep_periods dp 
		WHERE e.dep_id='$did' 
		AND e.dep_id=dp.dep_id 
		AND e.award_id=a.id 
		AND e.level_id=cl.id 
		AND e.period_id=dp.period_id 
		AND (e.period_id >= '$pstart') AND (e.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		ORDER BY e.start_date ASC";
	$r = mysql_query($q);
	$i = 1;
	while (list($name,$place,$start,$end,$level,$staffname,$exponat,$award) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$name</td>
		<td>$place</td>
		<td>$start - $end</td>
		<td>$level</td>
		<td>$staffname</td>
		<td>$exponat</td>
		<td>$award</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Наименование выставки</td>
	<td>Место проведение выставки</td>
	<td>Время проведения</td>
	<td>Уровень выставки</td>
	<td>Фамилия И.О. работника</td>
	<td>Экспонат</td>
	<td>Награда</td>
	</tr>
	$trows
	</table>
	";
}



function fReportEducTechnologies($header,$did,$pstart,$pend,$isclosed) {
	
	$trows = "";
	$q = "SELECT e.name, e.num
		FROM ka_educ_techn e, ka_dep_periods dp 
		WHERE e.dep_id='$did' 
		AND e.dep_id=dp.dep_id 
		AND e.period_id=dp.period_id 
		AND (e.period_id >= '$pstart') AND (e.period_id <= '$pend') AND (dp.is_closed=$isclosed) 
		";
	$r = mysql_query($q);
	$i = 1;
	while (list($name,$amount) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$name</td>
		<td>$amount</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Наименование показателя</td>
	<td>Значение</td>
	</tr>
	$trows
	</table>
	";
}

function fReportActives($header,$did,$pstart,$pend,$source,$isclosed) {
	
	$trows = "";
	$q = "SELECT t.name, a.name, a.num, a.cost, a.place
		FROM ka_assets a, ka_dep_periods dp, ka_asset_types t
		WHERE a.dep_id='$did' 
		AND a.type_id=t.id 
		AND a.dep_id=dp.dep_id 
		AND a.period_id=dp.period_id 
		AND (a.period_id >= '$pstart') AND (a.period_id <= '$pend') AND (dp.is_closed=$isclosed) AND (a.fin_source = '$source')
		";
//echo $q;
	$r = mysql_query($q);
	$i = 1;
	while (list($type,$name,$quantity,$cost,$place) = mysql_fetch_array($r)) {
		$trows .= "
		<tr>
		<td>$i</td>
		<td>$type</td>
		<td>$name</td>
		<td>$quantity</td>
		<td>$cost</td>
		<td>$place</td>
		</tr>";
		$i++;
	}
	return "
	<h5 align=center>$header</h5>
	<table width=100% cellspacing=0 cellpadding=0 border=1>
	<tr>
	<td>№ п/п</td>
	<td>Вид актива</td>
	<td>Полное наименование</td>
	<td>Количество</td>
	<td>Стоимость, руб.</td>
	<td>Местонахождение</td>
	</tr>
	$trows
	</table>
	";
}

?>