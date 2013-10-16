<?php
require_once '../vendor/autoload.php';
require_once '../src/sources/rating/Report.php';

class TestReport extends PHPUnit_Framework_TestCase {

    function testInitialize() {
        $report = new Report();
    }
}