<?php
namespace cypher\test;

require_once dirname(__DIR__).'/bootstrap.php';
require_once dirname(__FILE__).'/bootstrap.php';

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
        parent::tearDown();
    }

    /**
     * @test
     */
    public function test_findController()
    {
        $Sample = \cypher\Dispatcher::findController('SampleController');

    }
}

class DummySession {
}
