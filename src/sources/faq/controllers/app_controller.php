<?php
class AppController {
    function render($path, $vars = array()){
        extract($vars);
//        return include(dirname(__FILE__)."/../views/".$path.'.php');
        ob_start();
        include(dirname(__FILE__)."/../views/".$path.'.php');
        $xhtml = ob_get_clean();
        return $xhtml;
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