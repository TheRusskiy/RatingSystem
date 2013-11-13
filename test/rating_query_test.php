<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/rating/rating_query.php';

class TestQuery extends PHPUnit_Framework_TestCase {

    protected function setUp(){
        connect_test_db();
    }

    function testQueryReturnValue() {
        $queryText = "SELECT count(*) FROM staff";
        $query = new RatingQuery($queryText);
        $this->assertEquals(7, $query->execute());
    }
}