<?php

//по номеру сотрудника выдаёт всю информацию о нём

function draw_staff($id,$module) {
  
  $draw = "";
  $ID_STAFF = $id;
  $q = "SELECT id, shortname, name, secondname, surname, DATE_FORMAT(birthday,\"%d.%m.%Y\") FROM staff WHERE staff.id ='$id' ORDER BY staff.shortname ASC";
  $r = mysql_query($q);
  if (mysql_num_rows($r)==0) return "Такого работника не существует";
  
  while (list($id,$shortname,$name,$secondname,$surname,$birthday) = mysql_fetch_array($r)) {
  
    $q1 = "SELECT LOWER(ed.code) as code FROM eddegree ed, staff s WHERE s.id='$id' AND s.id_eddegree=ed.id";
    $r1 = mysql_query($q1);
    $row = mysql_fetch_array($r1); 
    $actdegreename = ($row['code']==NULL)?"":$row['code'];
    
    $q2 = "SELECT LOWER(es.name) as name FROM edstatus es, staff s WHERE s.id='$id' AND s.id_edstatus=es.id";
    $r2 = mysql_query($q2);
    $row = mysql_fetch_array($r2); 
    $actstatusname = ($row['name']==NULL)?"":$row['name'];
  
  // место работы, должность
  	$pd = "<ul>";
  	$qp = "SELECT d.id, d.name as dname, pt.name as pname, ds.rateacc, pet.isprimary as isp FROM posttype pt, dep d, depstaff ds, postdep pd, post p, postexectype pet WHERE pet.id=ds.id_postexectype AND pt.id=p.id_posttype AND d.id=ds.id_dep AND pd.id=ds.id_postdep AND p.id=pd.id_post AND ds.id_staff = '$id' ORDER BY pet.isprimary DESC";
  	$rp = mysql_query($qp);
  	
    while (list($iddep,$dname,$pname,$rateacc,$isp) = mysql_fetch_array($rp)) {
  	  $pname=trim($pname);$dname=trim($dname);
  	  $textdeplink = ($module=="")?"$dname":"<a href='?$module&id=$iddep'>$dname</a>";
  	  $pd .= "<li>$pname, $textdeplink, $rateacc ставки";
  	  if ($isp == 1) {$pd .= ", Основное <br>";}
  	  $pd .= "</li>";
    }
    $pd .= "</ul>";
  	
  // образование
  	$pe = "<ul>";
  	$qet = "SELECT edsign, DATE_FORMAT(se.begdate,\"%Y\") as begdate, DATE_FORMAT(se.enddate,\"%Y\") as enddate, se.id_edtype as typeid, se.id_edinst as instid, se.id_edinstfac as facid, se.id_edspec as specid, se.id_eddegree as degreeid, se.id_edstatus as statusid FROM staffed se WHERE se.id_staff = '$id' ORDER BY DATE_FORMAT(se.begdate,\"%Y\") ASC, DATE_FORMAT(se.enddate,\"%Y\") ASC";
    $ret = mysql_query($qet);
  	
    while (list($edsign, $begdate, $enddate, $typeid, $instid, $facid, $specid, $degreeid, $statusid) = mysql_fetch_array($ret)) {
  	  
  	  $begdate = (($begdate==NULL)?"":($begdate));
  	  $enddate = (($enddate==NULL)?"":($enddate));
  	  if ($begdate==$enddate)   
        $date=$begdate;
      else 
        $date = (($begdate!="")&&($enddate!=""))?"$begdate - $enddate":($begdate.$enddate);
  	  
      
      if ($typeid==25806001||$typeid==25807001||$typeid==25808001) {  //среднее общее, среднее полное, начальное профессиональное
  	    $qetn = "SELECT edtype.name as typename FROM edtype WHERE edtype.id='$typeid' ";        
        $rtn = mysql_query($qetn);
        $row = mysql_fetch_array($rtn); 
        $typename = trim($row['typename']);
        $pe .= "<li>$typename</li>"; 
      }
      
      elseif (($typeid==0)||($typeid==25812001)) {   //если степень или звание
        if ($degreeid!=0) {
          $qsd = "SELECT eddegree.name as degreename FROM eddegree WHERE eddegree.id='$degreeid' ";        
          $red = mysql_query($qsd);
          $row = mysql_fetch_array($red); 
          $degreename = trim($row['degreename']);
          $pe .= "<li>$enddate Присвоена учёная степень \"$degreename\"</li>"; 
        }
        if ($statusid!=0) {
          $qsd = "SELECT edstatus.name as statusname FROM edstatus WHERE edstatus.id='$statusid' ";        
          $red = mysql_query($qsd);
          $row = mysql_fetch_array($red); 
          $statusname = trim($row['statusname']);
          $pe .= "<li>$enddate Присвоено учёное звание \"$statusname\"</li>"; 
        }
      }
      
      else {  //неполное высшее, высшее, среднее техническое, среднееспециальное, дополнительное, проф. переподготовка
        if (($typeid==25810001)||($typeid==23371001)||($typeid==99480503)||($typeid==25809001)||($typeid==93217001)||($typeid==94221001)||(($typeid==25812001)&&($statusid==0)&&($degreeid==0))) {
          $qetn = "SELECT ei.name as instname FROM edinst ei WHERE ei.id='$instid'";      
          $rtn = mysql_query($qetn);
          $row = mysql_fetch_array($rtn); 
          $instname = ((mysql_num_rows($rtn)==0)?"":trim($row['instname'])); 
          $qetn = "SELECT eif.name as facname FROM edinstfac eif WHERE eif.id='$facid'";      
          $rtn = mysql_query($qetn);
          $row = mysql_fetch_array($rtn); 
          $facname = ((mysql_num_rows($rtn)==0)?"":", факультет \"".trim($row['facname'])."\""); 
          $qetn = "SELECT es.name as specname FROM edspec es WHERE es.id='$specid'";      
          $rtn = mysql_query($qetn);
          $row = mysql_fetch_array($rtn); 
          $specname = ((mysql_num_rows($rtn)==0)?"":", специальность \"".trim($row['specname'])."\""); 
          $pe .= "<li>$date $instname".$facname.$specname."</li>"; 
        }
        else {  //докторантура, асприрантура, адъюнктура, стажировка, повышение квалификации
          $qetn = "SELECT CONCAT(LOWER(SUBSTRING(name,1,1)),SUBSTRING(name FROM 2)) as typename 
                   FROM edtype WHERE edtype.id='$typeid' ";        
          $rtn = mysql_query($qetn);
          $row = mysql_fetch_array($rtn); 
          $typename = trim($row['typename']);
        //  $typename[2] = strtolower($typename[2]);
          $qetn = "SELECT ei.name as instname FROM edinst ei WHERE ei.id='$instid'";      
          $rtn = mysql_query($qetn);
          $row = mysql_fetch_array($rtn); 
          $instname = ((mysql_num_rows($rtn)==0)?"":trim($row['instname']).","); 
          $instname =  ($edsign==3)?"Повышение квалификации":$instname;                    //повышение квалификации
          $instname =  ($edsign==8)?"Стажировка":$instname;                                //стажировка
          $pe .= "<li>$date $instname $typename</li>"; 
        }     
      }
  	}
  	$pe .= "</ul>";
  
  
  //награды
  	$qr = "SELECT DATE_FORMAT(sa.awarddate,\"%Y\"), a.name FROM award a, staffaward sa WHERE a.id=sa.id_award AND sa.id_staff='$id'";
  	$rr = mysql_query($qr);
  	$pa = "<ul>";
    while (list($awarddate,$aname) = mysql_fetch_array($rr)) {
  	  $awarddate = (($awarddate==NULL)?"":trim($awarddate).",");
  		$pa .= "<li>$awarddate $aname</li>";
  	}
  	$pa .= "</ul>";
  	
    $draw .= "<h3>$surname $name $secondname</h3>";
    $draw .= $actdegreename==""?"":"Учёная степень: $actdegreename <br />";
    $draw .= $actstatusname==""?"":"Учёное звание: $actstatusname <br />"; 
    $draw .= "Дата рождения: $birthday<br /><br />";
  	$draw .= ((mysql_num_rows($rp)==0)?"":"Место работы и занимаемая должность: <br /> $pd").((mysql_num_rows($ret)==0)?"":"Образование: <br /> $pe").((mysql_num_rows($rr)==0)?"":"Награды: <br /> $pa");
  
  }	
  $draw .= "<br />";
  $q = "SELECT CONCAT(UPPER(SUBSTRING(s.name,1,1)),LOWER(SUBSTRING(s.name FROM 2))) as name, 
        CONCAT(UPPER(SUBSTRING(s.secondname,1,1)),LOWER(SUBSTRING(s.secondname FROM 2))) as secondname,
        CONCAT(UPPER(SUBSTRING(s.surname,1,1)),LOWER(SUBSTRING(s.surname FROM 2))) as surname, actual 
        FROM staffhistoryname s WHERE id_staff=$ID_STAFF and actual IS NOT NULL";
  $r = mysql_query($q);
  while (list($name, $secondname, $surname, $actual) = mysql_fetch_array($r)) {
    $draw .= "До $actual имя: $surname $name $secondname <br />";
  }
  return "<br />".$draw;
}

?>