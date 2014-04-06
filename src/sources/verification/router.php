<?php
class Router {
    public function __construct(){
        $controller_name = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : "home";
        $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "index";
        $controller = $this->to_controller_class_name($controller_name);
        $this->controller = new $controller();
    }

    public function execute(){
        return $this->controller->{$this->action}();
    }

    /**
     * converts some_name to SomeNameController
     */
    private function to_controller_class_name($controller_name)
    {
        $tokens = explode('_', $controller_name);
        $uppercase_tokens = array();
        foreach ($tokens as $t) {
            array_push($uppercase_tokens, ucfirst($t));
        }
        array_push($uppercase_tokens, "Controller");
        $controller = implode("", $uppercase_tokens);
        return $controller;
    }
}