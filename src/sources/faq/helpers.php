<?php

function require_relative($source, $path){
    return require_once dirname($source).'/'.$path;
}