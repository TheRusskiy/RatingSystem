<?php


class AppController {
    function head(){
        return include('./sources/faq/views/head.php');
//        return include('../views/head.php');
    }

    function footer(){
//        return include('../views/footer.php');
        return include('./sources/faq/views/footer.php');
    }

    function wrap($content){
        return $this->head().$content.$this->footer();
    }

}