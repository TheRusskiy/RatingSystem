<?php

function require_relative($source, $path){
    return require_once dirname($source).'/'.$path;
}
function _or_(){
    foreach(func_get_args() as $arg){
        if ($arg == true) {return $arg;}
    }
    return false;
}