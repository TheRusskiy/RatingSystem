<?php
require_once '../vendor/autoload.php';
require_once '../test/test_helper.php';

class TestQuery extends PHPUnit_Framework_TestCase {

    function testInitialize() {
        connect_test_db();
        $queryText = "SELECT * FROM staff";
        $query = new RatingQuery($queryText);
        $query->execute();
    }

    function testQueryReturnValue() {
        //todo
    }
}