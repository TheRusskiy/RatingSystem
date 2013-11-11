<?php
require_once '../test/test_helper.php';

class DbTest extends PHPUnit_Framework_TestCase {

    function testConnection() {
        $this->assertTrue(connect_test_db());
    }

    function testSetup(){
        $result = mysql_query("
          SELECT
            time
          FROM
            testings
          ORDER BY id DESC
          LIMIT 1
          ");

        date_default_timezone_set('Europe/Moscow');
        while($row = mysql_fetch_array($result))
        {
            $date = strtotime($row['time']);//date('Y-m-d H:i:s', strtotime($row['time']));
        }
        $now = new DateTime();//new DateTime('now', new DateTimeZone(date_default_timezone_get()));

        $this->assertLessThanOrEqual($now->getTimestamp(), $date); // <<< THIS SHIT IS FREAKING BACKWARDS! >_<
    }
}