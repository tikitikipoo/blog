<?php
namespace cypher\test;

use cypher\Model;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->Dispatcher = new \cypher\Dispatcher(array(
            'session' => 'DummySession'
        ));
        parent::setUp();
    }


    public function tearDown()
    {
        unset($this->Dispatcher);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function test_findController()
    {
//        $Sample = \cypher\Dispatcher::findController('SampleController');

    }
}

class DummySession {
}
