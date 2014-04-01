<?php
class Router {
    public function __construct(){
        $controller_name = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : "home";
        $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "index";
        $controller = ucfirst($controller_name)."Controller";
        $this->controller = new $controller();
    }

    public function execute(){
        return $this->controller->{$this->action}();
    }
}