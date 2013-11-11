<?php
require_once '../test/test_helper.php';
require_once '../src/sources/rating/criteria_calculator.php';

class TestCriteriaCalculator extends PHPUnit_Framework_TestCase {

    protected function setUp(){
        connect_test_db();
    }

    function testInitialize(){
        $query = "SELECT * FROM staff";
        $criteria = new Criteria(array(
            "id" => 1,
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
        $calculator = new CriteriaCalculator();
        $calculator->calculate($criteria);
    }

    function testCalculateSql(){
        $query = "SELECT count(*) FROM staff";
        $criteria = new Criteria(array(
            "id" => 2,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "multiplier" => 10,
            "year_limit" => 100,
            "calculation_type" => "sql/php"
        ));
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 70);
    }

    function testCalculatePhp(){
        $file = "../test/php_queries/q1.php";
        $criteria = new Criteria(array(
            "id" => 3,
            "fetch_type" => "php",
            "fetch_value" => $file,
            "name" => "name of criteria",
            "multiplier" => 10,
            "year_limit" => 100,
            "calculation_type" => "sql/php"
        ));
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 170);
    }

    function testCalculateManually(){
        $criteria = new Criteria(array(
            "id" => 4,
            "fetch_type" => "manual",
            "fetch_value" => "", // doesn't matter
            "name" => "name of criteria",
            "multiplier" => 10,
            "year_limit" => 100,
            "calculation_type" => "sum"
        ));
        $_REQUEST['from_date'] = '2013-01-01';
        $_REQUEST['to_date'] = '2014-01-01';
        $_REQUEST['staff_id'] = '1';
        $calculator = new CriteriaCalculator();

        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 40);

        $criteria->calculation_type = "max";
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 20);

        $criteria->calculation_type = "exists";
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 10);
    }

    function testCalculateManuallyFromOptions(){
        $criteria = new Criteria(array(
            "id" => 5,
            "fetch_type" => "manual_options",
            "fetch_value" => "v1\nv2\nv3",
            "name" => "name of criteria",
            "multiplier" => '25|15|10',
            "year_limit" => 100,
            "calculation_type" => "sum"
        ));
        $_REQUEST['from_date'] = '2013-01-01';
        $_REQUEST['to_date'] = '2014-01-01';
        $_REQUEST['staff_id'] = '1';
        $calculator = new CriteriaCalculator();

        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 50);

        $criteria->calculation_type = "max";
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 25);
    }
}