<?php

//......................................................................................................................
//нарисовать структуру подразделения

function draw_deps($deps,$module) {
    
  $draw = "";
  
  if (count($deps)==0) return "Такого подразделения не существует!";
    
  foreach ($deps as $dep) {
    
    $s = "";
    $id = $dep['id'];
    $name = $dep['name'];
    $code = $dep['code'];
    if (strlen($name)>60) $name=substr($name,0,30)."... ($code)";
    for($k=2;$k<=$dep['level'];$k++) {$s.="------";}
    $textlink = ($module=="")?$name:"<a href='?$module&id=$id'>$name</a>";
    $draw.="$s $textlink<br />";
  }
  return $draw;
}

//........................................................................................................
//нарисовать работников подразделения

function draw_depstaff($depstaff,$module) {   
  
  global $deps;
  
  $draw = "";
  if (count($deps)==0) return "";
  if (count($depstaff)==0) return "В подразделении нет работников";
  $draw.="<h3>Работники подразделения \"".$deps[0]['name']."\" </h3>";
  $draw.="В подразделении ".count($depstaff)." работников<br /><br />";
    
  $draw.= "<table border='1'>";
  $draw.= "<tr><td>ФИО</td>
             <td>Должность</td>
             <td>Ставка</td>
             <td>совм.</td>
             <td>&nbsp;</td>
             <td>Учёная степень</td>
             <td>Учёное звание</td>
             <td>Дата рожедния</td>
             <td>Пол</td>
          </tr>";
    
  foreach ($depstaff as $worker) {
      
    $id=$worker['id'];
    $shortname=$worker['shortname'];
    $name=$worker['name'];
    $secondname=$worker['secondname'];
    $surname=$worker['surname'];
    $degree=$worker['degreename'];
    $statusname=$worker['statusname'];
    $birth=$worker['birth'];
    $sex=($worker['sex']==1)?"мужской":"женский";
    $rateacc=$worker['rateacc'];
    $post=$worker['post'];
    $code=$worker['code'];
    $isp=$worker['isp'];
    if ($isp==0)  {$sovm="совм.";}
    else $sovm="";
    
    $name = ($module=="")?"$surname $name $secondname":"<a href='?$module&id=$id'>$surname $name $secondname</a>";
    
    $draw.= "<tr><td>$name</td>
               <td>$post</td>
               <td>$rateacc</td>
               <td>&nbsp;$sovm</td>
               <td>$code</td>
               <td>&nbsp;$degree</td>
               <td>&nbsp;$statusname</td>
               <td>$birth</td>
               <td>$sex</td>
            </tr>";
    
  }
    
  $draw.= "</table>";
  
  return $draw;
} 

//........................................................................................................................
//нарисовать штатное расписание подразделения

function draw_post($postdep) {         
 
  global $deps;
  
  if (count($deps)==0) return "";
  if (count($postdep)==0) return "В подразделении нет штатных должностей";
  $draw = "";
  $draw.="<h3>Штатное расписание подразделения \"".$deps[0]['name']."\" </h3>";
  $draw.="В подразделении ".count($postdep)." штатных должностей<br /><br />";
 
  $draw.="<table border='1'>";
  $draw.="<tr><td>Должность</td>
           <td>Ставка</td>
        </tr>";
  
 foreach ($postdep as $post) {
 
  $draw.= "<tr><td>".$post['postname']."</td>
           <td>".$post['rateacc']."</td>
           </tr>";
  }
      
  $draw.= "</table>";
  return $draw;
}

//......................................................................................................................
//дерево подразделений

function tree($uid) {
  
    global $deps;
    $sql = "SELECT id, name, hierlevel, parent, code FROM dep WHERE parent='$uid' AND flag_hide='0' ORDER BY name ASC";
    $a = mysql_query($sql);
    
    while(list($iddep,$name,$level,$parent,$code) = mysql_fetch_array($a)) {
  
      $deps[]=array('id' => $iddep, 'name' => $name, 'code' => $code, 'level' => $level, 'parent' => $parent);
      tree($iddep); 
  
    }
}

//......................................................................................................................
//выбирает все подразделения, являющиеся потомками подразделения по его id
//результат в $deps - глобальном массиве

function get_deps($iddep) {
 
  global $deps;
  
  $q = "SELECT d.name, d.hierlevel, d.code, d.parent FROM dep d WHERE d.id ='$iddep' AND d.flag_hide='0' ORDER BY d.name ASC";
  $r = mysql_query($q);
  $deps = array();
  
  if (mysql_num_rows($r)!=0) {  
    $row = mysql_fetch_array($r); 
    $depname = trim($row['name']);
    $level = trim($row['hierlevel']);
    $code = trim($row['code']);
    $parent = trim($row['parent']);
       
    $deps[] = array('id' => $iddep, 'name' => $depname, 'code' => $code, 'level' => $level, 'parent' => $parent);
  }  
  tree($iddep);
  
    
  return $deps;
  
}

//......................................................................................................................
//удаляет из массива повторяющихся работников, ставки складываются, совместительство выставляется основным если есть

function delete_double_staff($result) {

  $i = 0;
  $n=count($result)-1;
  
  while ($i<=$n) {
  
    $id = $result[$i]['id'];
    $k = $i+1;
    while ($k<=$n) {
        
        if (($result[$k]['id']!=0)&&($id==$result[$k]['id'])) {
         
          $result[$i]['isp']=$result[$i]['isp']+$result[$k]['isp'];
          $result[$i]['rateacc'] =  $result[$i]['rateacc'] + $result[$k]['rateacc'];
          $result[$k]['id'] =  0;
        }
        $k++;
   }
   $i++;
  }
  
  $depstaff = array();
  
  foreach ($result as $staff) {
  
    if (!($staff['id'] == 0)) $depstaff[] = $staff;   
  
  }  
  return $depstaff;
}

//......................................................................................................................
//возвращает массив с работниками подразделения, к каждому приписан номер подразделения

function get_dep_staff($iddep) {
   
  $q = "SELECT s.id, s.shortname, 
        CONCAT(UPPER(SUBSTRING(s.name,1,1)),LOWER(SUBSTRING(s.name FROM 2))) as name, 
        CONCAT(UPPER(SUBSTRING(s.secondname,1,1)),LOWER(SUBSTRING(s.secondname FROM 2))) as secondname,
        CONCAT(UPPER(SUBSTRING(s.surname,1,1)),LOWER(SUBSTRING(s.surname FROM 2))) as surname, 
        DATE_FORMAT(s.birthday,\"%d.%m.%Y\"), s.sex, s.degr, s.stat, s.academ, ds.rateacc, pt.name, pet.isprimary, o.code  
        FROM staff s, depstaff ds, postdep pd, post p, posttype pt, postexectype pet, officercls o 
        WHERE ds.id_dep='$iddep' AND ds.id_staff=s.id  AND ds.id_postdep=pd.id AND pd.id_post=p.id AND p.id_posttype=pt.id 
        AND ds.id_postexectype=pet.id AND ds.id_officercls=o.id 
        ORDER BY s.shortname ASC, pet.isprimary DESC";
  $r = mysql_query($q);

  
  $result = array();
  
  while (list($id,$shortname,$name,$secondname,$surname,$birth,$sex,$degr,$stat,$academ,$rateacc,$post,$isp,$code) = mysql_fetch_array($r)) {
  
    $q1 = "SELECT LOWER(ed.code) as code FROM eddegree ed, staff s WHERE s.id='$id' AND s.id_eddegree=ed.id";
    $r1 = mysql_query($q1);
    $row = mysql_fetch_array($r1); 
    $degreename = ($row['code']==NULL)?"":$row['code'];
   
    $q2 = "SELECT LOWER(es.name) as name FROM edstatus es, staff s WHERE s.id='$id' AND s.id_edstatus=es.id";
    $r2 = mysql_query($q2);
    $row = mysql_fetch_array($r2); 
    $statusname = ($row['name']==NULL)?"":$row['name'];
    
    $result[] = array ('shortname' => $shortname,
               'id' => $id,
               'name'=> $name,
               'secondname' => $secondname,
               'surname' => $surname,
               'birth' => $birth,
               'sex' => $sex,
               'degr' => $degr,
               'academ' => $academ,
               'stat' => $stat,
               'rateacc' => $rateacc,
               'post' => $post,
               'code' => $code,
               'degreename' => $degreename,
               'statusname' => $statusname,
               'isp' => $isp,
               'iddep' => $iddep
               );
  }
  
  $depstaff = delete_double_staff($result); 
      
  return $depstaff; 
  
} 

//......................................................................................................................
//возвращает список всех работников всех подразделений из массива $deps

function get_all_deps_staff($deps) {
  
  $depstaff = array();
        
  foreach($deps as $dep)  {
    $id = $dep['id'];
    $depstaff = array_merge($depstaff, get_dep_staff($id));    
  }

  $result =  delete_double_staff($depstaff); 
  
  asort($result);
  return $result; 
  
} 

//......................................................................................................................
//выдаёт штатное расписание подразделения по его id
//результатом возвращает массив 

function get_post_dep($iddep) {
  
  $q = "SELECT pd.id, ROUND(SUM(pd.rateacc)*100)/100, p.name, p.id, DATE_FORMAT(pd.datebeg,\"%d.%m.%Y\"), 
        DATE_FORMAT(pd.dateend,\"%d.%m.%Y\") FROM postdep pd, post p, posttype pt 
        WHERE pd.id_dep='$iddep' AND pd.id_post=p.id AND p.id_posttype=pt.id GROUP BY p.name";
  $r = mysql_query($q);
    
  $postdep = array();  
    
  while (list($id,$rateacc,$postname,$postid,$datebeg,$dateend) = mysql_fetch_array($r)) {
  
    $postdep[] = array('postname' => $postname,
                       'id' => $id,  
                       'postid' => $postid, 
                       'iddep' => $iddep,
                       'rateacc' => $rateacc, 
                       'datebeg' => $datebeg, 
                       'dateend' => $dateend);
  
  }
  return($postdep);
}

//......................................................................................................................
//возвращает штатное расписание всех подразделений из массива $deps, ставки одинаковых должностей складываются

function get_all_post_deps($deps) {
  
  $post_deps = array();
  
  foreach($deps as $dep)  {
    $id = $dep['id'];
    $post_deps = array_merge($post_deps, get_post_dep($id));    
  }
        
  //сложить ставки одинаковых должностей

  $i = 0;
  $n=count($post_deps)-1;
    
  while ($i<=$n) {
  
    $postid = $post_deps[$i]['postid'];
    $k = $i+1;
    while ($k<=$n) {
        
        if (($post_deps[$k]!=0)&&($postid==$post_deps[$k]['postid'])) {
            $post_deps[$i]['rateacc'] =  $post_deps[$i]['rateacc'] + $post_deps[$k]['rateacc'];
            $post_deps[$k]['postid'] = 0;   
        }
        $k++;
   }
   $i++;
  } 
  
  $result = array();
  
  foreach ($post_deps as $post) {
  
    if (!($post['postid'] == 0)) $result[] = array('postname' => $post ['postname'],
                                                   'postid' => $post ['postid'],
                                                   'iddep' => $post ['iddep'], 
                                                   'rateacc' => $post ['rateacc']
                                                  );   
  
  }   
  asort($result);
  return $result; 
  
} 

?>