<?php
// This file can only be required once due to flash setup code
if (isset($GLOBALS['helpers_called'])){
    throw new Exception("Helpers can only be required once!");
} else {
    $GLOBALS['helpers_called'] = true;
}

function session($param, $value = "UNDEFINED_VALUE"){
    global $_CURRENT_SESSION;
    if (!isset($_CURRENT_SESSION) || $_CURRENT_SESSION == null){
        $_CURRENT_SESSION = array();
        $GLOBALS['$_CURRENT_SESSION'] = $_CURRENT_SESSION;
    }
    if ($value!="UNDEFINED_VALUE" )
    {   // SET VALUE
        $_SESSION[$param]=$value;
    }
    else
    {   // GET VALUE
        if (isset($_CURRENT_SESSION[$param])){
            $result = $_CURRENT_SESSION[$param];
        } elseif (isset($_SESSION[$param])) {
            $result = $_SESSION[$param];
        } else {
            $result = null;
        }
        return $result;
    }
}
// Flash setup code
session('old_flash', session('new_flash'));
session('new_flash', null);

function flash($param, $value = "UNDEFINED_VALUE", $now = false){
    $new_flash = session('new_flash');
    $new_flash = ($new_flash == null) ? array() : $new_flash;
    $old_flash = session('old_flash');
    $old_flash = ($old_flash == null) ? array() : $old_flash;
    if ($value!="UNDEFINED_VALUE" )
    {   // SET VALUE
        $new_flash[$param] = $value;
        session('new_flash', $new_flash);
    }
    else
    {   // GET VALUE
        if (isset($new_flash[$param]) && $now){
            $result = $new_flash[$param];
        }
        elseif (isset($old_flash[$param])) {
            $result = $old_flash[$param];
        }
        else {
            $result = null;
        }
        return $result;
    }
}

function keep_flash(){
    $old_flash = session('old_flash');
    foreach ($old_flash as $key => $value) {
        flash($key, $value);
    }
}

function params($param, $default = null){
    return isset($_REQUEST[$param]) ? $_REQUEST[$param] : $default;
}

function params_from_url($url){
    $parts = parse_url($url);
    parse_str($parts['query'], $query);
    return $query;
}

function modify_url($url, $new_params){
    $old_params = params_from_url($url);
    $old_params = ($old_params == null) ? array() : $old_params;
    $url = "/?".http_build_query(array_merge($old_params, $new_params));
    return $url;
}

function redirect($url, $params = array()){
    $url = modify_url($url, $params);
    header("Location: $url");
}