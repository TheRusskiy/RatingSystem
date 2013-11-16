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

    function head(){
        return render("head");
    }

    function footer(){
        return render("footer");
    }

    function wrap($content){
        $this->execute_before();
        return $this->head().$content.$this->footer();
    }
}