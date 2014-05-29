<?php
require_once(dirname(__FILE__).'/../dao/seasons_dao.php');
class Season {
    public function __construct($id, $from, $to) {
        $this->id = $id;
        $this->from_date = $from;
        $this->to_date = $to;
        $this->from_period = self::period_from_date($from);
        $this->to_period = self::period_from_date($to);
    }

    public function previous(){
        if (isset($this->cachedPrevious)){
            return $this->cachedPrevious;
        }
        $this->cachedPrevious = SeasonsDao::find(intval($this->id)-1);
        return $this->cachedPrevious;
    }

    public function split($from, $to){
        if (strtotime($to) < strtotime($from)){
            throw new Exception("Start date is less than end date!");
        }
        $dates = array();
        array_unshift($dates , $to);
        while($this->year($to)>$this->year($from)){
            $year = $this->year($to);
            $year_before = $year - 1;
            array_unshift($dates, "$year-01-01");
            array_unshift($dates, "$year_before-12-31");
            $to = "$year_before-12-31";
        }
        array_unshift($dates , $from);
        return $dates;
    }

    private function year($date){
        // date format is "yyyy-mm-dd"
        return intval(strtok($date, '-'));
    }

    // unused, but good for reference on how to modify dates
    private function year_before($date){
        $date = new DateTime($date);
        $date->modify('-1 year');
        return $date->format('Y-m-d');
    }

    public static function period_from_date($date)
    {
        $query = "SELECT id FROM ka_periods " .
            "WHERE start_date <= '$date' " .
            "AND end_date >= '$date'";
        $row = mysql_fetch_array(mysql_query($query));
        return intval($row[0]);
    }

    public function properties_for_json(){
        $properties = new stdClass();
        $properties->id = $this->id;
        $properties->from_date = $this->from_date;
        $properties->to_date = $this->to_date;
        return $properties;
    }
}