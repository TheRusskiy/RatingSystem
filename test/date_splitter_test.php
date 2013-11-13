<?php
require_once '../test/test_helper.php';
require_once '../src/sources/rating/date_splitter.php';

class TestDateSplitter extends PHPUnit_Framework_TestCase {

    function testNoSplit() {
        $splitter = new DateSplitter();
        $this->assertEquals($splitter->split("2013-01-01", "2013-12-31"),
                                        array("2013-01-01", "2013-12-31"));
    }

    function testSplitOneYear() {
        $splitter = new DateSplitter();
        $this->assertEquals($splitter->split("2012-01-01", "2013-12-31"),
           array("2012-01-01", "2012-12-31", "2013-01-01", "2013-12-31"));
    }

    function testSplitInTheMiddle() {
        $splitter = new DateSplitter();
        $this->assertEquals($splitter->split("2012-06-01", "2013-10-10"),
           array("2012-06-01", "2012-12-31", "2013-01-01", "2013-10-10"));
    }

    function testSplitTwoYears() {
        $splitter = new DateSplitter();
        $this->assertEquals($splitter->split("2011-01-01", "2013-12-31"),
            array("2011-01-01", "2011-12-31","2012-01-01", "2012-12-31", "2013-01-01", "2013-12-31"));
    }

    function testSplitSameDay() {
        $splitter = new DateSplitter();
        $this->assertEquals($splitter->split("2013-06-06", "2013-06-06"),
            array("2013-06-06", "2013-06-06"));
    }

    /**
     * @expectedException Exception
     */
    public function testThrowsOnWrongRange(){
        $splitter = new DateSplitter();
        $splitter->split("2013-01-01", "2012-01-01");
    }
}