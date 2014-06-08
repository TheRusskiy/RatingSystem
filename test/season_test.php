<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/dao/seasons_dao.php';
require_once '../src/sources/faq/dao/versions_dao.php';
require_once '../src/sources/faq/rating/season.php';

class TestSeason extends PHPUnit_Framework_TestCase {

    function testCreateSeason() {
        $season = new Season(3, "2012-01-01", "2012-12-31");
        $this->assertEquals($season->from_date, "2012-01-01");
        $this->assertEquals($season->to_date, "2012-12-31");
        $this->assertEquals($season->from_period, 178);
        $this->assertEquals($season->to_period, 4784);
    }

    function testCanGetPreviousSeason(){
        $season = new Season(3, "2012-01-01", "2012-12-31");
        $prev = $season->previous();
        $this->assertEquals($prev->from_date, "2011-01-01");
        $this->assertEquals($prev->to_date, "2011-12-31");
    }

    function testReturnsNullIfSeasonFirst(){
        $season = new Season(1, "2010-01-01", "2010-12-31");
        $this->assertEquals(null, $prev = $season->previous());
    }

    function testGetsAllVersionsFromCriteria(){
        $season = new Season(1, "2010-01-01", "2010-12-31");
        $saved_version = new Version(array(
            "criteria_id"=>100,
            "multiplier"=>10,
            "year_limit"=>100,
            "year_2_limit"=>0,
            "creation_date"=>"2010-01-01"
        ));
        VersionsDao::insert($saved_version);
        $season_criteria = new stdClass();
        $season_criteria->id = $saved_version->id;
        SeasonsDao::insert_criteria_versions(array($season_criteria),$season->id);

        $criteria_id = 666;
        $version = $season->getVersionFromCriteria($criteria_id);
        $this->assertEquals(null, $version);

        $criteria_id = 100;
        $version = $season->getVersionFromCriteria($criteria_id);
        $this->assertEquals($saved_version, $version);
    }
}