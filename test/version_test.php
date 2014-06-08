<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/rating/criteria.php';
require_once '../src/sources/faq/rating/version.php';

class TestVersion extends PHPUnit_Framework_TestCase {

    protected function setUp(){
        connect_test_db();
    }

    function testInitialize(){
        $version = new Version(array(
            "id" => 0,
            "criteria_id" => 0,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $this->assertEquals($version->id, 0);
        $this->assertEquals($version->criteria_id, 0);
        $this->assertEquals($version->multiplier, 10);
        $this->assertEquals($version->year_limit, 100);
        $this->assertEquals($version->year_2_limit, 0);
        $this->assertEquals($version->creation_date, "2014-06-05");
    }

}