<?php
function require_all ($path) {
    $files = glob(dirname(__FILE__)."/".$path.'/*.php');
    foreach ($files as $filename){
        require_once $filename;
    }
}
require_all('controllers');
require_all('dao');
require_all('rating');
class Router {
    public function __construct(){
        $controller_name = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : "home";
        $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "index";
        $controller = ucfirst($controller_name)."Controller";
        $this->controller = new $controller();
    }

    public function execute(){
        ParamProcessor::Instance()->reset();
        return $this->controller->{$this->action}();
    }
}