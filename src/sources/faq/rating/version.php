<?php
require_once(dirname(__FILE__).'/../dao/versions_dao.php');
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
        }
        else {
            $this->id = $attrs["id"];
            $this->criteria_id = $attrs["criteria_id"];
            $this->multiplier = $attrs["multiplier"];
            $this->year_limit = $attrs["year_limit"];
            $this->year_2_limit = $attrs["year_2_limit"];
            $this->creation_date = $attrs["creation_date"];
        }
    }

    public function properties_for_json(){
        $properties = new stdClass();
        $properties->id = $this->id;
        $properties->criteria_id = $this->criteria_id;
        $properties->multiplier = $this->multiplier;
        $properties->year_limit = $this->year_limit;
        $properties->year_2_limit = $this->year_2_limit;
        $properties->creation_date = $this->creation_date;
        return $properties;
    }
}