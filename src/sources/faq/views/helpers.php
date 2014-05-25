<?php
function url($text, $href, $attrs = array()){
    $attrs_text = "";
    foreach($attrs as $name => $value){
        $attrs_text.= "$name='$value'";
    }
    return "<a $attrs_text href = $href>$text</a>";
}
function href($controller, $action, $params = array()){
    return "/?".http_build_query(array_merge(array('controller'=>$controller, 'action' =>$action), $params));
}

function pagination($link, $page_count, $current_page, $params = array()){
    $result = "<ul class='pagination' id='pagination'>";
    $range = 3;
    $p = 0;
    $print_dots = false;
    while($p <= $page_count){
        $p++;
        if(abs($current_page-$p)<$range || abs(1-$p)<$range || abs($page_count-$p+1)<$range){
            if ($print_dots){
                $result.="<li><a><b>...</b></a></li>";
                $print_dots = false;
            }
            $page_link = modify_url($link, array_merge(array("page"=>$p), $params));
            $result.="<li><a href=$page_link#pagination>$p</a></li>";
        } else {
            $print_dots = true;
        }
    }
    $result.="</ul>";
    return $result;
}
function link_for_teacher($teacher, $text = 'rating'){
    $id = "";
    if (gettype($teacher)=='array'){
        $id = $teacher['id'];
    } else {
        $id = $teacher->id;
    }
    return url($text, href("teachers", "show", array('id' => $id)));
}

function link_to_calculate_rating($teacher){
    $id = $teacher['id'];
    $value = $teacher['value'];
    $is_data_complete = $teacher['is_data_complete'];
    if ($value!==null) {
        $warning = $is_data_complete > 0 ? "" : "(?)";
        return $value.$warning;
    }
    return url(
        "Вычислить",
        href("teachers", "calculate_rating", array('id' => $id)),
        array('id' => "calculation_link_$id", 'class' => "calculation_link")
    );
}

function hidden_field($name, $value){
    return "<input type='hidden' name='$name' value='$value'/>";
}

function selected($k1, $k2){
    return $k1===$k2 ? "selected" : "";
}