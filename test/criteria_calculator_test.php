<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/rating/criteria_calculator.php';

class TestCriteriaCalculator extends PHPUnit_Framework_TestCase {

    protected function setUp(){
        connect_test_db();
        // Just some dummy values for tests that don't need those
        ParamProcessor::Instance()->set_season_id('1');
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
        $this->assertEquals($result->score, 70);
        $this->assertEquals($result->value, 7);
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
        $this->assertEquals($result->score, 0);
        $this->assertEquals($result->value, 0);
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
        ParamProcessor::Instance()->set_season_id(1);
        ParamProcessor::Instance()->set_staff_id('2');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result->score, 20);
        $this->assertEquals($result->value, 2);
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
        ParamProcessor::Instance()->set_season_id(3); // 2012
        ParamProcessor::Instance()->set_staff_id('3');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result->score, 20);
        $this->assertEquals($result->value, 6);
        $this->assertEquals($result->value_with_limit, 2);
    }

    function testCalculateSqlWith2YearLimit(){
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
        ParamProcessor::Instance()->set_season_id(3); // 2012
        ParamProcessor::Instance()->set_staff_id('4');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        // 50 for 2011, 30 for 2012, year limit = 30, two year limit = 50,
        // score after limits:
        // 30 for 2011
        // 50-30=20 for 2012
        $this->assertEquals($result->score, 20);
        $this->assertEquals($result->value, 3);
        $this->assertEquals($result->value_with_limit, 3);
        $this->assertEquals($result->value_with_2_limit, 2);
    }

    function testTakesAllYearsIntoAccount(){
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
        ParamProcessor::Instance()->set_season_id(3); // 2012
        ParamProcessor::Instance()->set_staff_id('5');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        // 40 for 2010, 40 for 2011, 30 for 2012, year limit = 30, two year limit = 50,
        // score after limits:
        // 30 for 2010
        // 50-30=20 for 2011
        // 50-20=30 for 2012
        $this->assertEquals($result->score, 30);
        $this->assertEquals($result->value, 3);
        $this->assertEquals($result->value_with_limit, 3);
        $this->assertEquals($result->value_with_2_limit, 3);
    }

    function testTakesAllYearsIntoAccount_first_year(){
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
            "year_2_limit" => 40,
            "calculation_type" => "sum"
        ));
        ParamProcessor::Instance()->set_season_id(1); // 2010
        ParamProcessor::Instance()->set_staff_id('6');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result->score, 30);
        $this->assertEquals($result->value, 5);
        $this->assertEquals($result->value_with_limit, 3);
        $this->assertEquals($result->value_with_2_limit, 3);
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
        $this->assertEquals($result->score, 170);
        $this->assertEquals($result->value, 17);
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
        ParamProcessor::Instance()->set_season_id(4);
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result->score, 40);
        $this->assertEquals($result->value, 4);
        $this->assertEquals(sizeof($result->records), 3);
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
        ParamProcessor::Instance()->set_season_id(4);
        ParamProcessor::Instance()->set_staff_id('1');

        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $result = $calculator->calculate($criteria);
        $this->assertEquals($result->score, 0);
        $this->assertEquals($result->value, 0);
        $this->assertEquals(sizeof($result->records), 0);
    }
//
//    function testCalculateManuallyFromOptions(){
//        $this->build_criteria = function(){
//            return new Criteria(array(
//                "id" => 5,
//                "fetch_type" => "manual_options",
//                "fetch_value" => "v1|v2|v3",
//                "name" => "name of criteria",
//                "description" => "",
//                "multiplier" => '25|15|10',
//                "year_limit" => 100,
//                "year_2_limit" => 0,
//                "calculation_type" => "sum"
//            ));
//        };
//        ParamProcessor::Instance()->set_season_id(4);
//        ParamProcessor::Instance()->set_staff_id('1');
//        $calculator = new CriteriaCalculator();
//
//        $criteria = $this->build_criteria->__invoke();
//        $result = $calculator->calculate($criteria);
//        $this->assertEquals($result, 75);
//        $this->assertEquals($criteria->value, array(2,2,1,1)); // first digit is for 0 values
//        $this->assertEquals($criteria->has_records, true);
//        $this->assertEquals(sizeof($criteria->records), 6);
//    }
//
//    function testCalculateManuallyFromOptionsNoRecords(){
//        $this->build_criteria = function(){
//            return new Criteria(array(
//                "id" => -1,
//                "fetch_type" => "manual_options",
//                "fetch_value" => "v1|v2|v3",
//                "name" => "name of criteria",
//                "description" => "",
//                "multiplier" => '25|15|10',
//                "year_limit" => 100,
//                "year_2_limit" => 0,
//                "calculation_type" => "sum"
//            ));
//        };
//        ParamProcessor::Instance()->set_season_id(4);
//        ParamProcessor::Instance()->set_staff_id('1');
//        $calculator = new CriteriaCalculator();
//
//        $criteria = $this->build_criteria->__invoke();
//        $result = $calculator->calculate($criteria);
//        $this->assertEquals($result, 0);
//        $this->assertEquals($criteria->value, array(0,0,0,0)); // first digit is for 0 values
//        $this->assertEquals($criteria->has_records, false);
//        $this->assertEquals(sizeof($criteria->records), 0);
//    }
}