<?php
class User {
    public function __construct($map){
        $this->id = $map["id"];
        $this->name = $map["name"];
    }
    public function json(){
        $attrs = array();
        $attrs['id'] = $this->id;
        $attrs['name'] = $this->name;
        return json_encode($attrs) ;
    }
} 