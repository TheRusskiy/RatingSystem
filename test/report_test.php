<?php
require_once '../vendor/autoload.php';
require_once '../src/sources/rating/report.php';

class TestReport extends PHPUnit_Framework_TestCase {
    protected function setUp(){
        connect_test_db();
    }

    function testInitialize() {
        $report = new Report();
    }
}