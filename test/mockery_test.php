<?php
require_once '../vendor/autoload.php';

class JustToCheckMockeryTest extends PHPUnit_Framework_TestCase {

    protected function tearDown() {
        \Mockery::close();
    }
    function testMockeryWorks() {
        $mock = \Mockery::mock('AClassToBeMocked');
        $mock->shouldReceive('someMethod')->once();
        $workerObject = new AClassToWorkWith;
        $workerObject->doSomethingWith($mock);
    }
}

class AClassToBeMocked {}

class AClassToWorkWith {

    function doSomethingWith($anotherClass) {
        return $anotherClass->someMethod();
    }
}
