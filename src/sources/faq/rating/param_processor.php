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

    public function get_season_id(){
        if (isset($this->season_id)){
            return $this->season_id;
        }
        if (isset($_REQUEST['season_id']) || isset($_SESSION['season_id'])){
            return mysql_real_escape_string(_or_($_REQUEST['season_id'], $_SESSION['season_id']));
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

    public function get_from_date(){
        if (isset($this->from_date)){
            return $this->from_date;
        }
        if (isset($_REQUEST['from_date']) || isset($_SESSION['from_date'])){
            return mysql_real_escape_string(_or_($_REQUEST['from_date'], $_SESSION['from_date']));
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
        if (isset($_REQUEST['to_date']) || isset($_SESSION['to_date'])){
            return mysql_real_escape_string(_or_($_REQUEST['to_date'], $_SESSION['to_date']));
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
        if (isset($_REQUEST['staff_id']) || isset($_SESSION['staff_id'])){
            return mysql_real_escape_string(_or_($_REQUEST['staff_id'], $_SESSION['staff_id']));
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