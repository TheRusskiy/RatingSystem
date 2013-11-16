<?php
class AppController {
    function execute_before(){
        if (params('from')!=null){
            session('from', params('from'));
        }
        if (params('to')!=null){
            session('to', params('to'));
        }
    }

    function wrap($content, $variables = array()){
        $this->execute_before();
        $footer = render("footer", $variables);
        $head = render("head", $variables);
        $header = render("header", $variables);
        return $head.$header.$content.$footer;
    }
}