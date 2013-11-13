<?php

class DateSplitter {
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
}