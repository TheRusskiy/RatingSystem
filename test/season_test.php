<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/rating/season.php';

class TestSeason extends PHPUnit_Framework_TestCase {

    function testCreateSeason() {
        $season = new Season("2012-01-01", "2013-01-01");
        $this->assertEquals($season->from_date, "2012-01-01");
        $this->assertEquals($season->to_date, "2013-01-01");
        $this->assertEquals($season->from_period, 178);
        $this->assertEquals($season->to_period, 4785);
//        $this->assertEquals($splitter->split("2013-01-01", "2013-12-31"),
//                                        array("2013-01-01", "2013-12-31"));
    }
    function testCanGetPreviousSeason(){
        $season = new Season("2012-01-01", "2013-01-01");
        $prev = $season->previous();
        $this->assertEquals($prev->from_date, "2011-01-01");
    }
}