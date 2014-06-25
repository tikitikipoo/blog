<?php
namespace cypher\test;

use cypher\Controller;
use cypher\HttpNotFoundException;

require_once dirname(__FILE__).'/controller/SampleController.php';


class ControllerTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $dispatcher = new \cypher\Dispatcher(array(
            'session' => 'DummyCSession'
        ));

        $this->controller = new Controller($dispatcher);
    }
    public function tearDown()
    {
        unset($this->controller);
        parent::tearDown();
    }
    /**
     * @test
     */
    public function test()
    {
        try {
            $this->controller->forward404();
            $this->assertTrue(false, 'この処理を通っていないこと');
        } catch(HttpNotFoundException $e) {
            $this->assertTrue(true, 'この処理を通っていること');
        }
    }
}

class DummyCSession {}
