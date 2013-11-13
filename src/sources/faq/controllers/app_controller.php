<?php
class AppController {
    function render($path){
        return include(dirname(__FILE__)."/../views/".$path.'.php');
    }
    function head(){
        return $this->render("head");
    }

    function footer(){
        return $this->render("footer");
    }

    function wrap($content){
        return $this->head().$content.$this->footer();
    }

}