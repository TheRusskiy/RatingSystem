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
            "multiplier" => 10,
            "year_limit" => 100,
            "calculation_type" => "sum"
        ));
        $this->assertEquals($criteria->fetch_type, "sql");
        $this->assertEquals($criteria->fetch_value, $query);
        $this->assertEquals($criteria->name, "name of criteria");
        $this->assertEquals($criteria->multiplier, 10);
        $this->assertEquals($criteria->year_limit, 100);
        $this->assertEquals($criteria->calculation_type, "sum");
    }

    function testCriteria() {
//        $queryText = "SELECT count(*) FROM staff";
//        $query = new RatingQuery($queryText);
//        $this->assertEquals(7, $query->execute());
    }
}