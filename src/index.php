<?php
  
session_start(); 
  
$error="";

if (isset($_SESSION['error'])) {
  switch ($_SESSION['error']) {
    
    case "1":   //������������ ������������
      $error="������������ ������������ �� 10 �����<br />";
      break;
      
    case "2":  //�������� ������
      $error="�������� ��� ������������ ��� ������. ��������, ����� 5 ������� ����� ��������� ������ ������������ ����� ������������ �� 10 �����!<br />";
      break;
      
    case "3":  //�������� ������ ��� ��� ������������
      $error="�������� ��� ������������ ��� ������. ��������, ����� 5 ������� ����� ��������� ������ ������������ ����� ������������ �� 10 �����!<br />";
      break; 
    
  }  
  unset($_SESSION['error']);
}

if (!(isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])AND (!isset($_POST['auth_name']))) {   //���� �� ������������
	echo fLoginForm($error);
  exit;
}

require("config.php");
require("sources/core/functions.php");
connect_db();
$out = "";

function write_log($act,$comment)  {              
  
  global $id_user;
  global $ip;
  if (isset($_SESSION['user_id'])) $id_user = $_SESSION['user_id'];
  if (isset($_SESSION['ip'])) $ip = $_SESSION['ip'];
  $q = "UPDATE user SET lastact='$act' WHERE id='$id_user'";
  $r = mysql_query($q);         
  $sSQL = "INSERT INTO log_user (id, id_user, ip, logtime, act, comment) 
           VALUES (NULL, '$id_user', '$ip', NOW(), '$act', '$comment')";
  mysql_query($sSQL);  
}

if (isset($_POST['check'])) {  //�����������

  $name = mysql_real_escape_string($_POST['auth_name']);
  $pass = md5(mysql_real_escape_string($_POST['auth_pass']));
  $ip = $_SERVER['REMOTE_ADDR'];
  $query = "SELECT id, id_group FROM user WHERE name LIKE BINARY '$name' AND flag_hide=0";
  $res = mysql_query($query);
  sleep(1);
  if (list($id_user, $id_group) = mysql_fetch_array($res)) {     //���� ���� ����� ������������, ���������, ������������ �� ��� ���
    $q = "SELECT UNIX_TIMESTAMP(lastlogintime) as lastlogintime 
          FROM log_attempts WHERE id_user='$id_user' AND ip LIKE '$ip'
          ORDER BY lastlogintime DESC";
    $r = mysql_query($q);
	
    $row = mysql_fetch_array($r);
    $lastlogintime = $row['lastlogintime'];
    if ((mysql_num_rows($r)>4)&&((time()-$lastlogintime)<$time_for_block)) { //������������ ������������
      $_SESSION['error'] = 1;
      header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      exit;
    }
    else {     //������������ �� ������������
      $qpass = "SELECT * FROM user WHERE name LIKE BINARY '$name' AND pass='$pass' 
    		AND ( ('$ip' REGEXP `ipmask`) OR (`ipmask` = '') )";     //��������� ������
      $rpass = mysql_query($qpass);
      if ($row = mysql_fetch_assoc($rpass)) {            //���������� ������ 
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        if ($id_group==10) $_SESSION['user_name'] = "admin"; //������������ ��������� � ���������������
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['error'] = 0;
        $out.= "����������� ������ �������";
        write_log("log in","");       
        $q = "DELETE FROM log_attempts WHERE UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(lastlogintime)>1800 OR id_user='$id_user'";
        $r = mysql_query($q);         //������� ��� ������ ����������� �������� ��� ���������� ��������� ������������
        $q = "UPDATE user SET lastlogin=NOW() WHERE id='$id_user'";
        $r = mysql_query($q);         //����� ����� ���������� �����
      } 
      else {                              //������������ ������, ���������� ������� ����� � ���� � ������� log_attempts � log_user
        $q = "INSERT INTO log_attempts (id, id_user, lastlogintime, ip) 
              VALUES (NULL, '$id_user', NOW(), '$ip')";
        $r = mysql_query($q);
        write_log("try log in","");
        $_SESSION['error'] = 2;
        sleep(1);
        header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        exit;
      }
    } 
  }
  else {                        //��� ������ ������������
    $q = "INSERT INTO log_incorrect (id, name, logtime, ip)     
          VALUES (NULL, '$name', NOW(), '$ip')";           //���������� ������� ����� � log_incorrect
    $r = mysql_query($q);
    $_SESSION['error'] = 3;
    header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    exit;
  }
}  

if (isset($_GET['logout'])) {  //����� �� �����������
  write_log("log out","");
  session_destroy();
  header("Location: https://".$_SERVER['HTTP_HOST']);
  exit;
}

if ($_SESSION['user_name']=="admin") {         //���� ���� �������������

  require('sources/admin/admin.php');  
  exit;

}

/*
if ( (isset($_GET['staff'])) && (isset($_GET['id'])) ) {     //���� ��������� ���������� � ����������

  require('sources/core/all_about_staff.php');  
  $id = (int)$_GET['id'];
  echo draw_staff($id,"");
  exit;

}
*/

//.....................................................................................................................
  
require('sources/core/all_about_dep.php');  
  
class info {

	var $user_id;     
	var $id_group;     
	var $user_name;
  var $user_ip;          
	var $iddep;              
	var $depname;       
  var $arechildren;      
	var $arm;    
  var $codearm;              
	var $deps;                
  var $depstaff;           
  var $postdep;            
  var $composite;        
  var $armname;        

    

	//.............................................................
  //������������� ������� �������
  function info() {
			
    $this->user_id = $_SESSION['user_id'];
    $this->user_name = $_SESSION['user_name'];
    $this->user_ip = $_SESSION['ip'];
  	$sql = "SELECT dep.name,  user.id_group, user.id_dep, groupuser.arm, groupuser.name as gname, groupuser.arm as armname,  groupuser.composite, groupuser.message
            FROM user, dep, groupuser WHERE user.id='$this->user_id' AND user.id_group=groupuser.id 
            AND dep.id=user.id_dep";
    $a = mysql_query($sql);

    $row = mysql_fetch_array($a);
    $this->id_group = $row['id_group'];
    $this->iddep = $row['id_dep'];
    $this->depname = $row['name'];
    $this->arm = $row['arm'];
    $this->codearm = $row['gname'];
    $this->armname = $row['armname'];
    $this->composite = $row['composite'];
    $this->message = $row['message'];
      
    $this->deps = get_deps($this->iddep);
    if (count($this->deps)==1) {
		$this->arechildren=0;
    } else {
	$this->arechildren=1;
    }
    
    $this->depstaff = get_all_deps_staff($this->deps);
    $this->postdep = get_all_post_deps($this->deps);
  }
	 
}

  $object = new info;
   
  if (($object->iddep==0)||($object->arm=="")) {
    $out="��� ������ ������������ �� ������� ������������� ���� ������� �����";
  }
  
  else {
  $out ="";
//
//		����� ��� ������ ��� ������: 
//		http://monitoring.ssau.ru/index.php?act=reports&report=cafedra&page=totalactivity
//

	if ($object->composite == 0) {

		require("sources/core/skin.php");

		$modulereq = (isset($_GET["report"])) ? $_GET["report"] : "main";

		$menu = array();
		$q = "SELECT r.module, r.name FROM reports r, report_users u WHERE u.id_groupuser='".$object->id_group."' AND u.id_report=r.id";
		$r = mysql_query($q);
		while (list($module,$armname) = mysql_fetch_array($r)) {
			$menu[$armname] = "report=$module";
			if ($module == $modulereq) {
				require("sources/reports/$module/$module.php");
				$out .= $result->out;
				$menu .= $result->navmenu;
			}
		}
		
		if ($modulereq == "main") {
			$out = $object->message;
		}

		$menutxt = ""; 
		foreach ($menu as $k => $v) {
			if (ereg("report","^$v")) {
				$curval = $v;
				$menutxt .= "<br><b><a href=index.php?act=reports&$v>$k</a></b><br>\n";
			} else {
				$menutxt .= "<div align=left><a href=index.php?act=reports&$curval&page=$v>$k</a></div>\n";
			}
		}
		$out = (!isset($_GET["print"])) ? fSkin($object->armname,$menutxt,$out) : fSkinPrint($object->armname,$menutxt,$out);
		echo $out;
		exit();
	} else {

		require("sources/".$object->codearm."/".$object->codearm.".php");

	}
  
  /*  $out.="<p><a href='?logout'>�����</a></p>"; 
    $out.="����� ������������: ".$object->user_id."<br />"; 
    $out.="����� �������������: $object->iddep <br />���: $object->arm <br />";
 
    $out .= "<h3>��������� ������������� \"".$object->deps[0]['name']."\"</h3>";
    $out .= draw_deps($object->deps,"");
    $out .= draw_depstaff($object->depstaff,"staff");
    $out .= draw_post($object->postdep);
    //$id = $object->iddep;
    //$out .= "������� �� ��� ������ <a href='/sources/caf/caf.php?id=$id'>���</a>";
   */ 
    
 	
  }
  
echo $out;

// ========================================= functions ===========================

function fLoginForm($error = "") {

return "<html>
  <head>
    <meta http-equiv=Content-Type content='text/html; charset=windows-1251'>
    <title>���������� ������������ ������������� ������������</title>
    <link type=text/css href=/styles/common.css rel=stylesheet>
  </head>
  <body bottommargin=0 leftmargin=0 rightmargin=0 topmargin=0 bgcolor=#FFFFFF>
<form method=POST>
<table border=0 width=100% height=100%>
<tr>
<td align=center valign=center>
<table width=500 height=80 cellspacing='0' cellpadding='0' border=0>
<tr>
	<td width=1   bgcolor=#7F99BE rowspan=5><img src=/images/blank.gif width=1></td>
	<td width=140 height=80 align=center valign=center bgcolor=#7F99BE><img src=/images/ssaulogo.gif width=120 height=60></td>
	<td width=358 valign=center bgcolor=#7F99BE><h3 style='color:#ffffff'>������� ����������� ������������ ������������� ������������</h3></td>
	<td width=1   bgcolor=#7F99BE rowspan=5><img src=/images/blank.gif></td>
</tr>
</table>
<table width=500 height=220 cellspacing='0' cellpadding='0' border=0>
<tr height=1>
	<td width=1   bgcolor=#7F99BE rowspan=5><img src=/images/blank.gif width=1 height=1></td>
	<td width=200 bgcolor=#7F99BE><img src=/images/blank.gif width=1 height=1></td>
	<td width=298 bgcolor=#7F99BE><img src=/images/blank.gif width=1 height=1></td>
	<td width=1   bgcolor=#7F99BE rowspan=5><img src=/images/blank.gif width=1 height=1></td>
</tr>
<tr>
	<td colspan=2 height=80 align=center>&nbsp; <b style='color:red'>$error</b></td>
</tr>
<tr>
	<td align=right>����� &nbsp; &nbsp; </td>
	<td><input type=text maxlength=20 name=auth_name></td>
</tr>
<tr>
	<td align=right>������ &nbsp; &nbsp; </td>
	<td><input type=password maxlength=20 name=auth_pass></td>
</tr>
	<td>&nbsp;</td>
	<td><input type=submit name=check value='����'></td>
<tr>
	<td colspan=4 height=1 bgcolor=#7F99BE><img src=/images/blank.gif></td>
</tr>
</table>
<table width=500 height=80 cellspacing='0' cellpadding='0' border=0>
<tr height=1>
	<td width=1   bgcolor=#7F99BE rowspan=2><img src=/images/blank.gif width=1></td>
	<td width=498 height=1 valign=center bgcolor=#7F99BE></td>
	<td width=1   bgcolor=#7F99BE rowspan=2><img src=/images/blank.gif></td>
</tr>
<tr>
	<td width=498 valign=center bgcolor=#FFFFFF>
		<p>
		<font color=red>�������� ������������� ��� \"�������\"!</font> ��� ���������� ������ ��� ��������� <a href=http://www.adobe.com/products/flashplayer/ target=_blank>���������� Adobe Flash Player 10</a>
		<br><br>
�� �������� ������ ������� ���������� �� ���.:<br>
45-62, ������ ������� ����������,<br>
44-46, ������ ������� ����������<br>
		<br><br>

		<b>���������� �������</b><br>
		<i>02.04.2010</i>: ���������� ��� \"�������\": ��������� 1 ���������, ����������� � �������� ��������� ������� � ����������� ����� �����.
		<br>
		</p>
		&nbsp; <img src=/images/pdf.gif> <a href=/files/monitoring_userlist.pdf>����������  �� ������� ������� ������������� � ������</a><br>
		&nbsp; <img src=/images/pdf.gif> <a href=/files/monitoring_arm_cafedra.pdf>���������� ������������ ��� &quot;�������&quot; ������</a><br>
		&nbsp; <img src=/images/pdf.gif> <a href=/files/monitoring_passwords.pdf>���������� �� ����������� ��������� ������ � ������</a><br>
</td>
</tr>
<tr>
	<td colspan=3 height=1 bgcolor=#7F99BE><img src=/images/blank.gif></td>
</tr>
</table>

</td></tr></table>
</form>
</body>
</html>
";

}
  
?>