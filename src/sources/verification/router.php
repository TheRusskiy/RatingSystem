<?php
require_once('ability.php');
class Router {
    public function __construct(){
        $this->controller_name = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : "home";
        $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "index";
        $controller = $this->to_controller_class_name($this->controller_name);
        $this->controller = new $controller();
        $this->ability = new Ability();
    }

    public function execute(){
        if ($this->ability->is_allowed($this->controller->current_user(), $this->controller_name, $this->action)){
            return $this->controller->{$this->action}();
        } else {
            return 'not allowed';
        }
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