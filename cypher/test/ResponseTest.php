<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */

namespace cypher\test;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Response.php';
use cypher\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        parent::setUp();
        $this->Response = new Response();
    }


    public function tearDown()
    {
        unset($this->Response);
        parent::tearDown();
    }

}
