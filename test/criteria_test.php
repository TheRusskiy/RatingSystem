<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/rating/criteria.php';

class TestCriteria extends PHPUnit_Framework_TestCase {

    protected function setUp(){
        connect_test_db();
    }

    function testInitialize(){
        $query = "SELECT * FROM staff";
        $criteria = new Criteria(array(
            "id" => 0,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "description" => "",
        ));
        $this->assertEquals($criteria->fetch_type, "sql");
        $this->assertEquals($criteria->fetch_value, $query);
        $this->assertEquals($criteria->name, "name of criteria");
        $this->assertEquals($criteria->versions(), array());
    }

}