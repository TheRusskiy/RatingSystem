<?php
require_once(dirname(__FILE__).'/../dao/versions_dao.php');
require_once(dirname(__FILE__).'/../dao/criteria_dao.php');
class Version {
    public function __construct($attrs) {
        if (isset($attrs->criteria_id)){
            if (isset($attrs->id)){
                $this->id = $attrs->id;
            }
            $this->criteria_id = $attrs->criteria_id;
            $this->multiplier = $attrs->multiplier;
            $this->year_limit = $attrs->year_limit;
            $this->year_2_limit = $attrs->year_2_limit;
            $this->creation_date = $attrs->creation_date;
            if (isset($attrs->criteria)){
                $this->setCriteria($attrs->criteria);
            }
        }
        else {
            if (isset($attrs["id"])) {
                $this->id = $attrs["id"];
            }
            $this->criteria_id = $attrs["criteria_id"];
            $this->multiplier = $attrs["multiplier"];
            $this->year_limit = $attrs["year_limit"];
            $this->year_2_limit = $attrs["year_2_limit"];
            $this->creation_date = $attrs["creation_date"];
            if (isset($attrs["criteria"])){
                $this->setCriteria($attrs["criteria"]);
            }
        }
        $this->multiplier = $this->make_multiplier($this->multiplier);
    }

    public function setCriteria($criteria){
        $this->criteria = $criteria;
    }

    public function getCriteria(){
        if (isset($this->criteria)){
            return $this->criteria;
        }
        $this->criteria = CriteriaDao::find($this->criteria_id);
        return $this->criteria;
    }

    public function properties_for_json(){
        $properties = new stdClass();
        $properties->id = $this->id;
        $properties->criteria_id = $this->criteria_id;
        $properties->multiplier = $this->multiplier_to_string();
        $properties->year_limit = $this->year_limit;
        $properties->year_2_limit = $this->year_2_limit;
        $properties->creation_date = $this->creation_date;
        return $properties;
    }

    private function make_multiplier($value){
        if ($this->getCriteria()->fetch_type=='manual_options'){
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
}