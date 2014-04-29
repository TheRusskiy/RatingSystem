<?php

class Season {
    public function __construct($from, $to) {
        $this->from_date = $from;
        $this->to_date = $to;
        $this->from_period = self::period_from_date($from);
        $this->to_period = self::period_from_date($to);
    }

    public function previous(){
        if (isset($this->cachedPrevious)){
            return $this->cachedPrevious;
        }
        $new_from_date = $this->year_before($this->from_date);
        $new_to_date = $this->year_before($this->to_date);
        $this->cachedPrevious = new Season($new_from_date, $new_to_date);
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
}