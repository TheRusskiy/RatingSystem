<?php
class User {
    public function __construct($map){
        $this->id = $map["id"];
        $this->name = $map["name"];
        if (!isset($map["permissions"])){
            $map["permissions"] = "";
        }
        if (!isset($map["role"])){
            $map["role"] = "operator";
        }
        $this->permissions = null;
        $this->set_permissions_from_string($map["permissions"]);
        $this->role = $map["role"];
    }
    public function attributes(){
        $attrs = array();
        $attrs['id'] = $this->id;
        $attrs['name'] = $this->name;
        $attrs['role'] = $this->role;
        $attrs['permissions'] = $this->permissions;
        return $attrs;
    }

    public function set_permissions_from_string($string)
    {
        if ($string==null){
            $string = "";
        }
        $hash = json_decode ("{}"); # enforce object creation instead of empty array()
        $tokens = explode("|", $string);
        foreach($tokens as $t){
            if($t==""){continue;}
            $hash->$t=true;
        }
        $this->permissions =  $hash;
    }

    public static function permissions_to_string($object)
    {
        $string = "";
        foreach($object as $key=>$value){
            if ($value === "true" or $value === true){
                $string.=$key."|";
            }
        }
        return $string;
    }
} 