<?php

class Criteria {
    public function __construct($map = array(
        'id'=>null,
        'fetch_type'=>"",
        'fetch_value'=>"",
        'name'=>"",
        'year_limit'=>0,
        'multiplier'=>0,
        'calculation_type'=>""
    )){
        $this->id = $map["id"];
        $this->fetch_type = $map["fetch_type"];
        $this->fetch_value = $map["fetch_value"];
        $this->name = $map["name"];
        $this->year_limit = $map["year_limit"];
        $this->calculation_type = $map["calculation_type"];
        $this->result = null;
        $this->value = null;
        $this->has_records = false;
        $this->records = array();
        $this->multiplier = $this->make_multiplier($map["multiplier"]);
        $this->options = $this->make_options();
    }

    public function calculation_types(){
        return array('sql', 'php', 'manual', 'manual_options');
    }
    public function multiplier_to_string(){
        $m = $this->multiplier;
        if(is_int($m)){
            return $m;
        } else {
            // in PHP arrays are assigned by copy, so there's no danger of messing up an original
            array_shift($m);
            return implode("|", $m);
        }
    }

    public function value_to_string(){
        $m = $this->value;
        if(is_int($m)){
            return $m;
        } else {
            // in PHP arrays are assigned by copy, so there's no danger of messing up an original
            array_shift($m);
            return implode("|", $m);
        }
    }

    public function result_to_string(){
        if($this->has_records){
            return $this->result;
        } else {
            return '?';
        }
    }

    private function make_multiplier($value){
        if ($this->fetch_type=='manual_options'){
            $multis = explode('|', $value);
            array_unshift($multis , '0');
            $multiplier = array();
            for ($i=0; $i<count($multis); $i++){
                $multiplier[$i] = intval($multis[$i]);
            }
            return $multiplier;
        } else {
            return intval($value);
        }
    }

    private function make_options(){
        if ($this->fetch_type=='manual_options'){
            $options = explode("\n", $this->fetch_value);
            array_unshift($options , '-');
            return $options;
        } else {
            return null;
        }
    }

}