<?php
function url($text, $href){
    return "<a href = $href>$text</a>";
}
function href($controller, $action, $params = array()){
    return "/?".http_build_query(array_merge(array('controller'=>$controller, 'action' =>$action), $params));
}

function pagination($link, $page_count, $current_page){
    $result = "<div id='pagination'>";
    $range = 3;
    $p = 0;
    $print_dots = false;
    while($p <= $page_count){
        $p++;
        if(abs($current_page-$p)<$range || abs(1-$p)<$range || abs($page_count-$p+1)<$range){
            if ($print_dots){
                $result.="<b>... </b>";
                $print_dots = false;
            }
            $page_link = modify_url($link, array("page"=>$p));
            $result.="<a href=$page_link#pagination>$p</a> ";
        } else {
            $print_dots = true;
        }
    }
    $result.="</div>";
    return $result;
}
function link_for_teacher($teacher, $text = 'rating'){
    return url($text, href("teachers", "show", array('id' => $teacher['id'])));
}

function hidden_field($name, $value){
    return "<input type='hidden' name='$name' value='$value'/>";
}