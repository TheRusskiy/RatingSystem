<?php
class AppController {
    function execute_before(){
        if (params('from_date')!=null){
            session('from_date', params('from_date'));
        }
        if (params('to_date')!=null){
            session('to_date', params('to_date'));
        }
    }

    function wrap($content_path, $variables = array()){
        $this->execute_before();
        $content = render($content_path, $variables);
        return $content;
    }
}