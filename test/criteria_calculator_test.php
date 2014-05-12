<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/rating/criteria_calculator.php';

class TestCriteriaCalculator extends PHPUnit_Framework_TestCase {

    protected function setUp(){
        connect_test_db();
        // Just some dummy values for tests that don't need those
        ParamProcessor::Instance()->set_from_date('1980-01-01');
        ParamProcessor::Instance()->set_to_date('1980-01-10');
        ParamProcessor::Instance()->set_staff_id('99999');
    }

    protected  function tearDown(){
        ParamProcessor::Instance()->unset_from_date();
        ParamProcessor::Instance()->unset_to_date();
        ParamProcessor::Instance()->unset_staff_id();
        ParamProcessor::Instance()->unset_season_id();
    }
    function testInitialize(){
        $query = "SELECT * FROM staff";
        $criteria = new Criteria(array(
            "id" => 1,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "multiplier" => 10,
            "description" => "",
            "year_limit" => 100,
            "year_2_limit" => 0,
            "calculation_type" => "sum"
        ));
        $this->assertEquals($criteria->id, 1);
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
            "description" => "",
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "calculation_type" => "sum"
        ));
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 70);
        $this->assertEquals($criteria->value, 7);
        $this->assertEquals($criteria->has_records, true);
    }

    function testCalculateSqlNoRecords(){
        $query = "SELECT count(*) FROM staff WHERE 1=2";
        $criteria = new Criteria(array(
            "id" => 2,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "multiplier" => 10,
            "description" => "",
            "year_limit" => 100,
            "year_2_limit" => 0,
            "calculation_type" => "sum"
        ));
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 0);
        $this->assertEquals($criteria->value, 0);
        // Sql calculation should always say there are records
        $this->assertEquals($criteria->has_records, true);
    }


    function testCalculateSqlWithPlaceholders(){
        $query =
<<<EOF
    SELECT count(*)
    FROM some_entries
    WHERE
    staff_id = @staff_id@
    AND period_id >= @from_period_id@
    AND period_id <= @to_period_id@
EOF;
        $criteria = new Criteria(array(
            "id" => 6,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "multiplier" => 10,
            "description" => "",
            "year_limit" => 100,
            "year_2_limit" => 0,
            "calculation_type" => "sum"
        ));
        ParamProcessor::Instance()->set_from_date('2010-01-10');
        ParamProcessor::Instance()->set_to_date('2013-03-09');
        ParamProcessor::Instance()->set_staff_id('2');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 50);
    }


    function testCalculateSqlWithYearLimit(){
        $query =
<<<EOF
    SELECT count(*)
    FROM some_entries
    WHERE
    staff_id = @staff_id@
    AND period_id >= @from_period_id@
    AND period_id <= @to_period_id@
EOF;

        $criteria = new Criteria(array(
            "id" => 6,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "multiplier" => 10,
            "description" => "",
            "year_limit" => 20,
            "year_2_limit" => 0,
            "calculation_type" => "sum"
        ));
        ParamProcessor::Instance()->set_from_date('2011-01-01');
        ParamProcessor::Instance()->set_to_date('2013-03-10');
        ParamProcessor::Instance()->set_staff_id('3');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 50);
        $this->assertEquals($criteria->value, 10);
        $this->assertEquals($criteria->has_records, true);
    }

    function testUsesSeasonId(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => 4,
                "fetch_type" => "manual",
                "fetch_value" => "", // doesn't matter
                "name" => "name of criteria",
                "description" => "",
                "multiplier" => 10,
                "year_limit" => 100,
                "year_2_limit" => 0,
                "calculation_type" => "sum"
            ));
        };
        ParamProcessor::Instance()->set_season_id('4');
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 40);
        $this->assertEquals($criteria->value, 4);
        $this->assertEquals($criteria->has_records, true);
        $this->assertEquals(sizeof($criteria->records), 3);
    }

    function testCalculateSqlWith2YearLimit(){
        return;
        $query =
<<<EOF
    SELECT count(*)
    FROM some_entries
    WHERE
    staff_id = @staff_id@
    AND period_id >= @from_period_id@
    AND period_id <= @to_period_id@
EOF;

        $criteria = new Criteria(array(
            "id" => 6,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "multiplier" => 10,
            "description" => "",
            "year_limit" => 30,
            "year_2_limit" => 50,
            "calculation_type" => "sum"
        ));
        ParamProcessor::Instance()->set_from_date('2012-03-10');
        ParamProcessor::Instance()->set_to_date('2013-03-10');
        ParamProcessor::Instance()->set_staff_id('4');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals(10, $result);
        $this->assertEquals($criteria->value, 3);
        $this->assertEquals($criteria->has_records, true);
    }

    function testCalculatePhp(){
        $file = "../test/php_queries/q1.php";
        $criteria = new Criteria(array(
            "id" => 3,
            "fetch_type" => "php",
            "fetch_value" => $file,
            "name" => "name of criteria",
            "description" => "",
            "multiplier" => 10,
            "year_limit" => 200,
            "year_2_limit" => 0,
            "calculation_type" => "sum"
        ));
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 170);
        $this->assertEquals($criteria->value, 17);
        $this->assertEquals($criteria->has_records, true);
    }

    function testCalculateManually(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => 4,
                "fetch_type" => "manual",
                "fetch_value" => "", // doesn't matter
                "name" => "name of criteria",
                "description" => "",
                "multiplier" => 10,
                "year_limit" => 100,
                "year_2_limit" => 0,
                "calculation_type" => "sum"
            ));
        };
        ParamProcessor::Instance()->set_from_date('2013-01-01');
        ParamProcessor::Instance()->set_to_date('2014-01-01');
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 40);
        $this->assertEquals($criteria->value, 4);
        $this->assertEquals($criteria->has_records, true);
        $this->assertEquals(sizeof($criteria->records), 3);
    }

    function testManuallyNoRecords(){
        $this->build_criteria = function (){
            return new Criteria(array(
                "id" => -1,
                "fetch_type" => "manual",
                "fetch_value" => "", // doesn't matter
                "name" => "name of criteria",
                "description" => "",
                "multiplier" => 10,
                "year_limit" => 100,
                "year_2_limit" => 0,
                "calculation_type" => "sum"
            ));
        };
        ParamProcessor::Instance()->set_from_date('2013-01-01');
        ParamProcessor::Instance()->set_to_date('2014-01-01');
        ParamProcessor::Instance()->set_staff_id('1');

        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 0);
        $this->assertEquals($criteria->result, 0);
        $this->assertEquals($criteria->value, 0);
        $this->assertEquals($criteria->has_records, false);
        $this->assertEquals(sizeof($criteria->records), 0);

        $criteria = $this->build_criteria->__invoke();
        $criteria->calculation_type = "sum";
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 0);
        $this->assertEquals($criteria->result, 0);
        $this->assertEquals($criteria->value, 0);
        $this->assertEquals($criteria->has_records, false);
    }

    function testCalculateManuallyFromOptions(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => 5,
                "fetch_type" => "manual_options",
                "fetch_value" => "v1|v2|v3",
                "name" => "name of criteria",
                "description" => "",
                "multiplier" => '25|15|10',
                "year_limit" => 100,
                "year_2_limit" => 0,
                "calculation_type" => "sum"
            ));
        };
        ParamProcessor::Instance()->set_from_date('2013-01-01');
        ParamProcessor::Instance()->set_to_date('2014-01-01');
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 75);
        $this->assertEquals($criteria->value, array(2,2,1,1)); // first digit is for 0 values
        $this->assertEquals($criteria->has_records, true);
        $this->assertEquals(sizeof($criteria->records), 6);
    }

    function testCalculateManuallyFromOptionsNoRecords(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => -1,
                "fetch_type" => "manual_options",
                "fetch_value" => "v1|v2|v3",
                "name" => "name of criteria",
                "description" => "",
                "multiplier" => '25|15|10',
                "year_limit" => 100,
                "year_2_limit" => 0,
                "calculation_type" => "sum"
            ));
        };
        ParamProcessor::Instance()->set_from_date('2013-01-01');
        ParamProcessor::Instance()->set_to_date('2014-01-01');
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result, 0);
        $this->assertEquals($criteria->value, array(0,0,0,0)); // first digit is for 0 values
        $this->assertEquals($criteria->has_records, false);
        $this->assertEquals(sizeof($criteria->records), 0);
    }
}