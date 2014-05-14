<?php
class AppController {
    public function __construct(){
        $this->current_user = null;
    }

    function wrap($content_path, $variables = array()){
        $this->execute_before();
        $content = render($content_path, $variables);
        return $content;
    }

    public function current_user(){
        if ($this->current_user != null){
            return $this->current_user;
        } else {
            if (session("user_id")==null){
                return null;
            }
            $this->current_user = UsersDao::find(session("user_id"));
            return $this->current_user;
        }
    }
}