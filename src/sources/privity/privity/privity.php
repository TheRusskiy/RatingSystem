<?php
session_start();
include "config.php";

include_once ("sources/privity/uio_add_form2.php");
//include_once ("sources/privity/uio_addToBase.php");
include_once ("sources/privity/uio_dopMenu.php");
//include_once ("sources/privity/uio_SpravochnikPodForm.php");
//include_once ("sources/privity/uio_spravochnikKorpusovForm.php");
//include_once ("sources/privity/uio_editPodrazdeleniya.php");
//include_once ("sources/privity/uio_SpravochnikOtvetstvennogoLicaForm.php");
//include_once ("sources/privity/uio_editSotrudniki.php");
//include_once ("sources/privity/uio_SpravochnikUchastnikForm.php");
//include_once ("sources/privity/uio_editUchastniki.php");
//include_once ("sources/privity/uio_spravochnikRejimForm.php");
//include_once ("sources/privity/uio_editRejim.php");
//include_once ("sources/privity/uio_editKorpus.php");
include "core/skin.php";
include_once "sources/privity/uio_menu.php";
include_once "editForm.php";
$db = mysql_connect($CONFS['sql_host'] ,$CONFS['sql_user'] 	,$CONFS['sql_pass'] 	); 
 mysql_select_db($CONFS['sql_database'] ,$db);
 $menuitems="<style>
		#menu ul {
      margin: 0px;
      padding: 0px;
      list-style:none;
      width:350px;
	  font-size:14px;
    }
	#menu  ul li {
  position: relative;
  border-bottom:1px solid #ccc;
 
  }
  #menu li ul {
  
  left: 200px;
  top: 0;
  display: none;
  }
  
  #menu ul li a {
  display: block;
  text-decoration: none;
  color: #777;
  background: #fff;
  padding: 5px;
  } 
  #menu  li:hover ul { display: block; }
  #menu li:hover  a {
  color:#333;

  } 
  #menu  li:hover ul a:hover {
  background-color:#cccccc;
  background-image:none;
  color:#FFFFFF;
  }
  #menu li:hover ul, #menu li.jshover ul {
�
}

#menu li:hover  a, #menu li.jshover a {
�
}

#menu li:hover ul a:hover, #menu li.jshover ul a:hover {
�
}
  </style> 
  ";
  $menuitems="";
if(!isset($_GET['nav'])) {
	
  echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), "");
}
if($_GET['nav']==dob) {
	//include_once ("sources/privity/uio_add_form2.php");
	$_GET['buttonName']="�������� ������";
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), add($db));
}
if($_GET['nav']==edit) {
	////include_once ("sources/privity/uio_add_form2.php");
	$_GET['buttonName']="������ ���������";
	$_GET['r']="edit";
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), edit($db));
}
if($_GET['nav']==editForm) {
	////include_once ("sources/privity/uio_add_form2.php");
	$_GET['buttonName']="������ ���������";
	$_GET['r']="edit";
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), add($db));
}
if($_GET['nav']==addToBase) {
	include_once ("sources/privity/uio_addToBase.php");
	print_r($_POST);
	addToBase($db);
    echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), $_POST['result']);
}
if($_GET['nav']==delPom) {
       include_once ("sources/privity/uio_addToBase.php");
       $_POST['del']=='������� ������ � ���������';
	//   print_r($_POST);
	addToBase($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), $_POST['result']);
}
if($_GET['nav']==inventarizaciya) {
   	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"" );//dopolMenu(2)
}
if($_GET['nav']==dictionary) {
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), "");//dopolMenu(1)
}
if($_GET['nav']==otcheti) {
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), "");//dopolMenu(3)
}
if($_GET['nav']==dicKor) {
	include_once ("sources/privity/uio_spravochnikKorpusovForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),korpus($db));
}
if($_GET['nav']==editKorpus) {
	include_once ("sources/privity/uio_editKorpus.php");
	editKorpus($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicPod) {
	include_once ("sources/privity/uio_SpravochnikPodForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),podrazdeleniya($db));
}
if($_GET['nav']==editPod) {
	include_once ("sources/privity/uio_editPodrazdeleniya.php");
	editPod($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicRabPod) {
	include_once ("sources/privity/uio_SpravochnikOtvetstvennogoLicaForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),OtvetstvennoeLico($db));
}
if($_GET['nav']==editRabPod) {
	include_once ("sources/privity/uio_editSotrudniki.php");
	editOtvetLica($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicUch) {
	include_once ("sources/privity/uio_SpravochnikUchastnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),Uchastnik($db));
}
if($_GET['nav']==editUch) {
	include_once ("sources/privity/uio_editUchastniki.php");
	editUch($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicRejim) {
	include_once ("sources/privity/uio_spravochnikRejimForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),rejim($db));
}
if($_GET['nav']==editRejim) {
	include_once ("sources/privity/uio_editRejim.php");
	editRejim($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}

if($_GET['nav']==otchHistory) {
	$_GET['buttonName']="������ ���������";
	$_GET['r']="otchetHistoryTeh";
		echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),edit($db));
}
if($_GET['nav']==otHis) {
	include_once("sources/privity/uio_otchetiHistoryTeh.php");
	$_GET['buttonName']="������ ���������";
	$_GET['r']="otchetHistoryTeh";
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), historyTeh($db));
}

if($_GET['nav']==otchHistoryIspolzovaniya) {
	//$_GET['buttonName']="������ ���������";
	$_GET['r']="otchetHistoryIspolzovaniya";
		echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),edit($db));
}
if($_GET['nav']==otHisIspolzovaniya) {
	include_once("sources/privity/uio_otchetiHistoryIspolzovaniya.php");
	$_GET['buttonName']="������ ���������";
	$_GET['r']="otchetHistoryTeh";
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), historyIspolzovaniya($db));
}

if($_GET['nav']==otKartochka) {
	$_GET['buttonName']="������ ���������";
	$_GET['r']="otchet";
		echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),edit($db));
}
if($_GET['nav']==kartochka) {
	include_once("sources/privity/uio_otchetiKartochkaForm.php");
	$_GET['buttonName']="������ ���������";
	$_GET['r']="otchet";
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db), kartochka($db)."<br><a href='sources//privity/uio_otchetiKartochkaLoad.php?Nomer_komnatiEdit=".$Nomer_komnatiEdit."&Nomer_korpusaEdit=".$Nomer_korpusaEdit."'>������� �����</a>");
}
if($_GET['nav']==otBalans) {
	include_once("sources/privity/uio_queryPomesheniya.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),Form($db,0));
}
if($_GET['nav']==otBalansWith) {
	include_once("sources/privity/uio_queryPomesheniya.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),Form($db,1));
}
if($_GET['nav']==otBalansWithout) {
	include_once("sources/privity/uio_queryPomesheniya.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),Form($db,2));
}




if($_GET['nav']==dicSost) {
	$_POST['nameTable']="��������� ���������";
	$_POST['button']="�������� ����� ���������";
	$_POST['table']="sostoyanie";
	$_POST['col']="label";
	$_POST['nextNav']="editSost";
	include_once("sources/privity/uio_spravochnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spForm($db));
}
if($_GET['nav']==editSost) {
	$_POST['table']="sostoyanie";
	$_POST['col']="label";
	include_once("sources/privity/uio_editSpForm.php");
	editSpForm($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}


if($_GET['nav']==dicEtag) {
	$_POST['nameTable']="����";
	$_POST['button']="�������� ����� ����";
	$_POST['table']="etag";
	$_POST['col']="number";
	$_POST['nextNav']="editEtag";
	include_once("sources/privity/uio_spravochnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spForm($db));
}
if($_GET['nav']==editEtag) {
	$_POST['table']="etag";
	$_POST['col']="number";
	include_once("sources/privity/uio_editSpForm.php");
	editSpForm($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicPrav) {
	$_POST['nameTable']="��� �����";
	$_POST['button']="�������� ����� ��� �����";
	$_POST['table']="vidprava";
	$_POST['col']="vid";
	$_POST['nextNav']="editPrav";
	include_once("sources/privity/uio_spravochnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spForm($db));
}
if($_GET['nav']==editPrav) {
	$_POST['table']="vidprava";
	$_POST['col']="vid";
	include_once("sources/privity/uio_editSpForm.php");
	editSpForm($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicKategoriya) {
	$_POST['nameTable']="��������� ���������";
	$_POST['button']="�������� ����� ��������� ���������";
	$_POST['table']="kategoriyapomesheniya";
	$_POST['col']="kat";
	$_POST['nextNav']="editKategoriya";
	include_once("sources/privity/uio_spravochnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spForm($db));
}
if($_GET['nav']==editKategoriya) {
	$_POST['table']="kategoriyapomesheniya";
	$_POST['col']="kat";
	include_once("sources/privity/uio_editSpForm.php");
	editSpForm($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}
if($_GET['nav']==dicIspol) {
	$_POST['nameTable']="��� �������������";
	$_POST['button']="�������� ����� ��� �������������";
	$_POST['table']="vidispolzovaniya";
	$_POST['col']="vid";
	$_POST['nextNav']="editIspol";
	include_once("sources/privity/uio_spravochnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spForm($db));
}
if($_GET['nav']==editIspol) {
	$_POST['table']="vidispolzovaniya";
	$_POST['col']="vid";
	include_once("sources/privity/uio_editSpForm.php");
	editSpForm($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}

if($_GET['nav']==dicObremenenie) {
	$_POST['nameTable']="����������� ���������";
	$_POST['button']="�������� ����� �����������";
	$_POST['table']="obremenenie";
	$_POST['col']="obrem";
	$_POST['nextNav']="editObremenenie";
	include_once("sources/privity/uio_spravochnikForm.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spForm($db));
}
if($_GET['nav']==editObremenenie) {
	
	$_POST['table']="obremenenie";
	$_POST['col']="obrem";
	include_once("sources/privity/uio_editSpForm.php");
	editSpForm($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
}

if($_GET['nav']==dicArenda) {
	
	include_once("sources/privity/uio_SpravochnikArendatorov.php");
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),spArenda($db));
}
if($_GET['nav']==editArenda) {
	
	include_once("sources/privity/uio_editArenda.php");
	editArenda($db);
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),"");
	
}

if($_GET['nav']==search) {
	
	//if(isset($_POST['Structurnoe_podrazdlenie'])){
	 $st = $_POST['Structurnoe_podrazdlenie'];
	//}
	//else 
	//{
	//	$st=-1;
		
	//}
//	if(isset($_POST['ot'])){
	//	if(isset($_POST['do'])){
	        $ot = $_POST['ot'];
			$do = $_POST['do'];
	       
	//	}
//	}
	//else 
	//{
	//	$ot = -1;
	//	$do = -1;
		
//}
	include_once("sources/privity/uio_queryAccomidationOnPod.php");
	echo $vid;
	echo fSkin ("���������� �������������� �����������",uio_menu(0,$menuitems,0,$db),Accomintadion($db,$_POST['vid'],$st,$ot,$do));
	
}
//action='uio_editData.php'
//("http://".$_SERVER['HTTP_HOST']."/sources/privity/uio_add.php?buttonName=�������� ������");//"/sources/privity/uio_add.php?buttonName=�������� ������";
//echo "sdfdsf";

/* }
else {echo fSkin ("���������� �������������� �����������","<br><a href='sources/privity/uio_inventarizaciya.php'>�������������� </a>"."<br><a href='sources/privity/uio_otcheti.php'>������</a>","");

}*/
//$url2 = "http://".$_SERVER['HTTP_HOST'];
//echo $url ;


//echo $_SERVER['DOCUMENT_ROOT'] ;
//$url3 = $_SERVER['DOCUMENT_ROOT']."/sources/privity/uio_spravochniki.php";
//echo "http://".$_SERVER['HTTP_HOST']."/sources/privity/uio_add.php?buttonName=�������� ������" ;
//include($url3); 
//echo add();
 ?>






