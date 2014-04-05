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
        'description'=>""
    )){
        $this->id = $map["id"];
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

    public function fetch_types(){
        return array('sql'=>"SQL запрос", 'php' => "PHP файл", 'manual' => "Вручную", 'manual_options' => "Вручную из вариантов");
    }

    public function calculation_types(){
        return array('sum'=>"Сумма", 'max' => "Максимум", 'exists' => "Существует");
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
        if ($this->fetch_type!='manual_options'){
            return null;
        }
        $obj = array();
        $obj["id"]=$this->id;
        $obj["title"]=$this->name;
        $obj["description"]=$this->description;
        $options = array();
        $i = 0;
        foreach($this->options as $option){
            $options_obj=array();
            $options_obj["value"]=$i++;
            $options_obj["name"]=$option;
            $options[]=$options_obj;
        }
        $options = array_shift($options);
        $obj["options"]=$options;
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