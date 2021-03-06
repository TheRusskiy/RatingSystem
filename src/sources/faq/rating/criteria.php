<?php
require_once "version.php";
require_once __DIR__.'/../dao/versions_dao.php';
// BE CAREFUL WITH MOVING THIS FILE, IT'S USED IN VERIFICATION
class Criteria {
    public function __construct($map = array(
        'id'=>null,
        'fetch_type'=>"",
        'fetch_value'=>"",
        'name'=>"",
//        'year_limit'=>0,
//        'year_2_limit'=>0,
//        'multiplier'=>0,
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
//            $map["year_limit"]=$obj->year_limit;
//            $map["year_2_limit"]=$obj->year_2_limit;
//            $map["multiplier"]=$obj->multiplier;
//            $map["creation_date"]=$obj->creation_date;
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
        if (isset($map["version_count"])){
            $this->version_count = $map["version_count"];
        }
//        $this->year_limit = $map["year_limit"];
//        $this->year_2_limit = $map["year_2_limit"];
//        $this->creation_date = isset($map["creation_date"]) ? $map["creation_date"] : date("Y-m-d");
//        if (gettype($this->creation_date)=="string"){
//            $this->creation_date = date('Y-m-d', strtotime($this->creation_date));
//        }
        $this->result = null;
        $this->value = null;
        $this->has_records = false;
        $this->records = array();
//        $this->multiplier = $this->make_multiplier($map["multiplier"]);
        $this->options = $this->make_options();
    }

    public static function fetch_types_index(){
        return array('sql'=>"SQL запрос", 'php' => "PHP файл", 'manual' => "Вручную", 'manual_options' => "Вручную из вариантов");
    }
    public function fetch_types(){
        return self::fetch_types_index();
    }

    public function fetch_type_to_string(){
        $types = $this->fetch_types();
        return $types[$this->fetch_type];
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

    public function getVersions(){
        if (isset($this->versions_value)){
            return $this->versions_value;
        }
        $this->versions_value = VersionsDao::all($this->id);
        return $this->versions_value;
    }

    public function setVersions($versions){
        $this->versions_value = $versions;
    }
    public function properties_for_json(){
        $obj = array();
        $obj["id"]=$this->id;
        $obj["name"]=$this->name;
        $obj["description"]=$this->description;
        $obj["fetch_type"]=$this->fetch_type;
        $obj["fetch_value"]=$this->fetch_value;
//        $obj["year_limit"]=$this->year_limit;
//        $obj["year_2_limit"]=$this->year_2_limit;
//        $obj["multiplier"]=$this->multiplier_to_string();
//        $obj["creation_date"]=$this->creation_date;
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
        if (isset($this->version_count)){
            $obj["version_count"] = $this->version_count;
        }
        return $obj;
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