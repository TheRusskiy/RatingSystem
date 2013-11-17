<?php

class Criteria {
    public function __construct($map){
        $this->id = $map["id"];
        $this->fetch_type = $map["fetch_type"];
        $this->fetch_value = $map["fetch_value"];
        $this->name = $map["name"];
        $this->year_limit = $map["year_limit"];
        $this->calculation_type = $map["calculation_type"];
        $this->result = null;
        $this->value = null;
        $this->has_records = false;
        $this->multiplier = $this->make_multiplier($map["multiplier"]);
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

}