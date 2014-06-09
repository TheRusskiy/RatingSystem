<?php
class ParamProcessor {
    public static function Instance(){
        static $inst = null;
        if ($inst === null) {
            $inst = new ParamProcessor();
        }
        return $inst;
    }

    private function __construct() {

    }

    public function reset(){
        $this->unset_season_id();
        $this->unset_from_date();
        $this->unset_to_date();
        $this->unset_staff_id();

    }
    public function get_season_id(){
        if (isset($this->season_id)){
            return $this->season_id;
        }
        if (isset($_REQUEST['season_id'])){
            return mysql_real_escape_string($_REQUEST['season_id']);
        } elseif (isset($_SESSION['season_id'])){
            return mysql_real_escape_string($_SESSION['season_id']);
        } else {
            return null;
        }
    }

    public function set_season_id($value){
        $this->season_id = $value;
    }

    public function unset_season_id(){
        unset($this->season_id);
    }

    public function set_season($value){
        $this->season = $value;
    }

    public function unset_season(){
        unset($this->season);
    }

    public function get_from_date(){
        if (isset($this->from_date)){
            return $this->from_date;
        }
        if (isset($_REQUEST['from_date'])){
            return mysql_real_escape_string($_REQUEST['from_date']);
        } elseif (isset($_SESSION['from_date'])){
            return mysql_real_escape_string($_SESSION['from_date']);
        } else {
            return null;
        }
    }

    public function set_from_date($value){
        $this->from_date = $value;
    }

    public function unset_from_date(){
        unset($this->from_date);
    }

    public function get_to_date(){
        if (isset($this->to_date)){
            return $this->to_date;
        }
        if (isset($_REQUEST['to_date'])){
            return mysql_real_escape_string($_REQUEST['to_date']);
        } elseif (isset($_SESSION['to_date'])){
            return mysql_real_escape_string($_SESSION['to_date']);
        } else {
            return null;
        }
    }

    public function set_to_date($value){
        $this->to_date = $value;
    }

    public function unset_to_date(){
        unset($this->to_date);
    }


    public function get_staff_id(){
        if (isset($this->staff_id)){
            return $this->staff_id;
        }
        if (isset($_REQUEST['staff_id'])){
            return mysql_real_escape_string($_REQUEST['staff_id']);
        } elseif (isset($_SESSION['staff_id'])){
            return mysql_real_escape_string($_SESSION['staff_id']);
        } else {
            return null;
        }
    }

    public function set_staff_id($value){
        $this->staff_id = $value;
    }

    public function unset_staff_id(){
        unset($this->staff_id);
    }
}