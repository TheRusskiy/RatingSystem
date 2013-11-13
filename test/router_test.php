<?php
require_once '../test/test_helper.php';
require_once '../src/sources/faq/router.php';

class TestRouter extends PHPUnit_Framework_TestCase {

    protected function tearDown() {
        \Mockery::close();
    }

    function testDefault(){
        $router = new Router();
        $this->assertEquals(get_class($router->controller), "HomeController");
        $this->assertEquals($router->action, "index");

        $mock = \Mockery::mock('HomeController');
        $router->controller = $mock;
        $mock->shouldReceive('index')->once();
        $router->execute();
    }

    function testControllerAndAction(){
        $_REQUEST['controller'] = 'some';
        $_REQUEST['action'] = 'some_action';
        $mock = \Mockery::mock('SomeController');
        $router = new Router();
        $this->assertEquals(get_class($router->controller), "SomeController");
        $this->assertEquals($router->action, "some_action");

        $router->controller = $mock;
        $mock->shouldReceive('some_action')->once();
        $router->execute();
    }

}