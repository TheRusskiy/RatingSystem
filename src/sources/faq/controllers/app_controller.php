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
        $head = render("head", $variables);
        $header = render("header", $variables);
        $content = render($content_path, $variables);
        $footer = render("footer", $variables);
        return $this->check_etag($head.$header.$content.$footer);
    }

    function wrap_html($html, $variables = array()){
        $head = render("head", $variables);
        $header = render("header", $variables);
        $footer = render("footer", $variables);
        return $this->check_etag($head.$header.$html.$footer);
    }

    function check_etag($html){
        $etag=md5($html);
        $headers = apache_request_headers();
        $old_etag = "invalid etag";
        if (isset($headers['If-None-Match'])){
            $old_etag = $headers['If-None-Match'];
        }
        header("Etag: $etag");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        if ($old_etag==$etag){
            header("HTTP/1.0 304 Not Modified");
            exit();
        } else {
            return $html;
        }
    }
}