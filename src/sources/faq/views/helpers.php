<?php
function href($controller, $action, $params = array()){
    return "href="."/?".http_build_query(array_merge(array('controller'=>$controller, 'action' =>$action), $params));
}