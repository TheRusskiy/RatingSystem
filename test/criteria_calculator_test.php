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
            "description" => "",
        ));
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 1,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        $this->assertEquals($version->getCriteria(), $criteria);
        $this->assertEquals($criteria->id, 1);
        $this->assertEquals($criteria->fetch_type, "sql");
        $this->assertEquals($criteria->fetch_value, $query);
        $this->assertEquals($criteria->name, "name of criteria");
        $calculator = new CriteriaCalculator();
        $calculator->calculate($version);
    }

    function testCalculateSql(){
        $query = "SELECT count(*) FROM staff";
        $criteria = new Criteria(array(
            "id" => 2,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "description" => ""
        ));
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 2,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "description" => ""
        ));
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 2,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "description" => ""
        ));
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 3,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        ParamProcessor::Instance()->set_season_id(1);
        ParamProcessor::Instance()->set_staff_id('2');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "description" => ""
        ));
        $version = new Version(array(
            "id" => 6,
            "criteria_id" => 2,
            "multiplier" => 10,
            "year_limit" => 20,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        ParamProcessor::Instance()->set_season_id(3); // 2012
        ParamProcessor::Instance()->set_staff_id('3');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "id" => 10,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "description" => ""
        ));
        CriteriaDao::insert($criteria);

        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 10,
            "multiplier" => 10,
            "year_limit" => 30,
            "year_2_limit" => 50,
            "creation_date" => "2014-06-05"
        ));
        VersionsDao::insert($version);
        $season_criteria = new stdClass();
        $season_criteria->id = $version->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),3);
        SeasonsDao::insert_criteria_versions(array($season_criteria),2);

        $version->setCriteria($criteria);
        ParamProcessor::Instance()->set_season_id(3); // 2012
        ParamProcessor::Instance()->set_staff_id('4');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "id" => 9,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "description" => ""
        ));
        CriteriaDao::insert($criteria);

        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 9,
            "multiplier" => 10,
            "year_limit" => 30,
            "year_2_limit" => 50,
            "creation_date" => "2014-06-05"
        ));
        VersionsDao::insert($version);
        $season_criteria = new stdClass();
        $season_criteria->id = $version->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),3);

        $version->setCriteria($criteria);
        ParamProcessor::Instance()->set_season_id(3); // 2012
        ParamProcessor::Instance()->set_staff_id('5');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "id" => 8,
            "fetch_type" => "sql",
            "fetch_value" => $query,
            "name" => "name of criteria",
            "description" => ""
        ));
        CriteriaDao::insert($criteria);

        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 8,
            "multiplier" => 10,
            "year_limit" => 30,
            "year_2_limit" => 40,
            "creation_date" => "2014-06-05"
        ));
        VersionsDao::insert($version);
        $season_criteria = new stdClass();
        $season_criteria->id = $version->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),1);

        $version->setCriteria($criteria);
        ParamProcessor::Instance()->set_season_id(1); // 2010
        ParamProcessor::Instance()->set_staff_id('6');
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            "description" => ""
        ));
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 3,
            "multiplier" => 10,
            "year_limit" => 200,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        $calculator = new CriteriaCalculator();
        $result = $calculator->calculate($version);
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
            ));
        };

        ParamProcessor::Instance()->set_season_id(4);
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 4,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        $result = $calculator->calculate($version);
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
                "description" => ""
            ));
        };
        ParamProcessor::Instance()->set_season_id(4);
        ParamProcessor::Instance()->set_staff_id('1');

        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => -1,
            "multiplier" => 10,
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05"
        ));
        $version->setCriteria($criteria);
        $result = $calculator->calculate($version);
        $this->assertEquals($result->score, 0);
        $this->assertEquals($result->value, 0);
        $this->assertEquals(sizeof($result->records), 0);
    }

    function testCalculateManuallyFromOptions(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => 5,
                "fetch_type" => "manual_options",
                "fetch_value" => "v1|v2|v3",
                "name" => "name of criteria",
                "description" => ""
            ));
        };
        ParamProcessor::Instance()->set_season_id(4);
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 5,
            "multiplier" => "25|15|10",
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05",
            "criteria" => $criteria
        ));
        $result = $calculator->calculate($version);
        $this->assertEquals($result->score, 75);
        $this->assertEquals($result->value, array(2,2,1,1)); // first digit is for 0 values
        $this->assertEquals(sizeof($result->records), 6);
    }

    function testCalculateManuallyFromOptionsWith2YearLimit(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => 6,
                "fetch_type" => "manual_options",
                "fetch_value" => "v1|v2|v3",
                "name" => "name of criteria",
                "description" => ""
            ));
        };
        ParamProcessor::Instance()->set_season_id(3);
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        CriteriaDao::insert($criteria);

        $version = new Version(array(
            "id" => 1,
            "criteria_id" => 6,
            "multiplier" => "10|10|10",
            "year_limit" => 30,
            "year_2_limit" => 50,
            "creation_date" => "2014-06-05",
            "criteria" => $criteria
        ));
        VersionsDao::insert($version);
        $season_criteria = new stdClass();
        $season_criteria->id = $version->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),3);
        SeasonsDao::insert_criteria_versions(array($season_criteria),2);

        $result = $calculator->calculate($version);
        $this->assertEquals($result->score, 20);
        $this->assertEquals($result->value, array(0,3,0,0)); // first digit is for 0 values
        $this->assertEquals(sizeof($result->records), 3);
    }

    function testCalculateManuallyFromOptionsWith2YearLimitDifferentVersions(){
        $this->build_criteria = function(){
            return new Criteria(array(
                "id" => 7,
                "fetch_type" => "manual_options",
                "fetch_value" => "v1|v2|v3",
                "name" => "name of criteria",
                "description" => ""
            ));
        };
        ParamProcessor::Instance()->set_season_id(3);
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        CriteriaDao::insert($criteria);

        $version = new Version(array(
            "criteria_id" => 7,
            "multiplier" => "10|10|10",
            "year_limit" => 30,
            "year_2_limit" => 50,
            "creation_date" => "2014-06-05",
            "criteria" => $criteria
        ));
        VersionsDao::insert($version);
        $season_criteria = new stdClass();
        $season_criteria->id = $version->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),3);

        $version2 = new Version(array(
            "criteria_id" => 7,
            "multiplier" => "20|20|20",
            "year_limit" => 30,
            "year_2_limit" => 50,
            "creation_date" => "2014-06-05",
            "criteria" => $criteria
        ));
        VersionsDao::insert($version2);
        $season_criteria = new stdClass();
        $season_criteria->id = $version2->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),2);

        $result = $calculator->calculate($version);
        $this->assertEquals($result->score, 20);
        $this->assertEquals($result->value, array(0,3,0,0)); // first digit is for 0 values
        $this->assertEquals(sizeof($result->records), 3);
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
                "year_2_limit" => 0
            ));
        };
        ParamProcessor::Instance()->set_season_id(3);
        ParamProcessor::Instance()->set_staff_id('1');
        $calculator = new CriteriaCalculator();

        $criteria = $this->build_criteria->__invoke();
        $version = new Version(array(
            "id" => 1,
            "criteria_id" => -1,
            "multiplier" => "25|15|10",
            "year_limit" => 100,
            "year_2_limit" => 0,
            "creation_date" => "2014-06-05",
            "criteria" => $criteria
        ));
        $result = $calculator->calculate($version);
        $this->assertEquals($result->score, 0);
        $this->assertEquals($result->value, array(0,0,0,0)); // first digit is for 0 values
        $this->assertEquals(sizeof($criteria->records), 0);
    }
}