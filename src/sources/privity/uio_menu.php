<?php
   function uio_menu($number,$itemsMenu,$level,$db)
  {
	  
	//  $level++;
	  $edit = mysql_query("SELECT * FROM `menu` where prev=$level order by label",$db);
      $rows=mysql_num_rows($edit);
      $m = mysql_fetch_array($edit);
	  if($rows>0){
		if($level==0) $itemsMenu.="<ul id='menu'>";
		else  $itemsMenu.="<ul >"; 
		
		 for($i=0;$i<$rows;$i++){
			$way = $m['way'];
            $label=$m['label'];
            $prev = $m['prev'];
			$id = $m['id'];
			$itemsMenu.= "<li><a href='".$way."'>".$label."</a>";
			$itemsMenu.=uio_menu($id,$imensMenu,$id,$db);
			// $itemsMenu.="</li>";
			$m = mysql_fetch_array($edit);
			if($i==($rows-1))$itemsMenu.="</ul></li>";
		 }
		 
		
	  }
	  else  $itemsMenu.="</li>";
	  
    return 	$itemsMenu;    
  }
?>