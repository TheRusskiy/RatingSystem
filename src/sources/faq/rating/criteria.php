<?php
// BE CAREFUL WITH MOVING THIS FILE, IT'S USED IN VERIFICATION
class Criteria {
    public function __construct($map = array(
        'id'=>null,
        'fetch_type'=>"",
        'fetch_value'=>"",
        'name'=>"",
        'year_limit'=>0,
        'multiplier'=>0,
        'calculation_type'=>"",
        'description'=>"",
        'external_records'=>0
    ))
    {
        if (is_a($map, 'stdClass')){
            $obj = $map;
            $map = array();
            if (isset($obj->id)){
                $map["id"]=$obj->id;
            }
            else {
                $map["id"]=null;
            }
            if (isset($obj->fetch_value)){
                $map["fetch_value"]=$obj->fetch_value;
            }
            else {
                $map["fetch_value"]=null;
            }
            if (isset($obj->external_records)){
                $map["external_records"]=$obj->external_records;
            }
            else {
                $map["external_records"]=false;
            }
            if (isset($obj->description)){
                $map["description"]=$obj->description;
            }
            else {
                $map["description"]="";
            }
            $map["fetch_type"]=$obj->fetch_type;
            $map["name"]=$obj->name;
            $map["year_limit"]=$obj->year_limit;
            $map["multiplier"]=$obj->multiplier;
            $map["calculation_type"]=$obj->calculation_type;
            $map["creation_date"]=$obj->creation_date;
        }
        $this->id = $map["id"];
        if (!isset($map["external_records"]) || empty($map["external_records"])){
            $this->external_records = false;
        } else {
            $this->external_records = true;
        }
        $this->fetch_type = $map["fetch_type"];
        $this->fetch_value = $map["fetch_value"];
        $this->name = $map["name"];
        $this->description = $map["description"];
        $this->year_limit = $map["year_limit"];
        $this->calculation_type = $map["calculation_type"];
        $this->creation_date = isset($map["creation_date"]) ? $map["creation_date"] : date("Y-m-d");
        $this->result = null;
        $this->value = null;
        $this->has_records = false;
        $this->records = array();
        $this->multiplier = $this->make_multiplier($map["multiplier"]);
        $this->options = $this->make_options();
    }

    public static function fetch_types_index(){
        return array('sql'=>"SQL запрос", 'php' => "PHP файл", 'manual' => "Вручную", 'manual_options' => "Вручную из вариантов");
    }
    public function fetch_types(){
        return self::fetch_types_index();
    }

    public static function calculation_types_index(){
        return array('sum'=>"Сумма", 'max' => "Максимум", 'exists' => "Существует");
    }
    public function calculation_types(){
        return self::calculation_types_index();
    }
    public function calculation_type_to_string(){
        $types = $this->calculation_types();
        return $types[$this->calculation_type];
    }
    public function fetch_type_to_string(){
        $types = $this->fetch_types();
        return $types[$this->fetch_type];
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

    public function external_records_int(){
        if ($this->external_records){
            return 1;
        } else {
            return 0;
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

    public function option_for($value){
        if ($this->fetch_type=='manual_options'){
            $option = array();
            $option["name"]=$this->options[intval($value)];
            $option["value"]=$value;
            return $option;
        } else {
            return null;
        }
    }

    public function properties_for_json(){
        $obj = array();
        $obj["id"]=$this->id;
        $obj["name"]=$this->name;
        $obj["description"]=$this->description;
        $obj["fetch_type"]=$this->fetch_type;
        $obj["fetch_value"]=$this->fetch_value;
        $obj["calculation_type"]=$this->calculation_type;
        $obj["year_limit"]=$this->year_limit;
        $obj["multiplier"]=$this->multiplier_to_string();
        $obj["creation_date"]=$this->creation_date;
        $obj["external_records"]=$this->external_records;
        if ($this->fetch_type!='manual_options'){
            $obj["options"]=null;
        } else {
            $options = array();
            $i = 0;
            foreach($this->options as $option){
                $options_obj=array();
                $options_obj["value"]=$i++;
                $options_obj["name"]=$option;
                $options[]=$options_obj;
            }
            array_shift($options);
            $obj["options"]=$options;
        }
        return $obj;
    }

    private function make_multiplier($value){
        if ($this->fetch_type=='manual_options'){
            $multis = explode('|', $value);
            array_unshift($multis , '0');
            $multiplier = array();
            for ($i=0; $i<count($multis); $i++){
                $multiplier[$i] = intval(trim($multis[$i]));
            }
            return $multiplier;
        } else {
            return intval($value);
        }
    }

    private function make_options(){
        if ($this->fetch_type=='manual_options'){
            $options = explode("|", $this->fetch_value);
            array_unshift($options , '-');
            $new_options = array();
            foreach($options as $o){
                $new_options[]=trim($o);
            }
            return $new_options;
        } else {
            return null;
        }
    }

}