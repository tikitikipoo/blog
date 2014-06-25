<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 9:37
 * To change this template use File | Settings | File Templates.
 */

namespace cypher\test;

use cypher\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        Config::write(
            array('default' => '1')
        );
    }

    public function tearDown()
    {
    }

    public function test_設定が正しく登録されるか()
    {
        $result = Config::read('default');
        $expected = '1';
        $this->assertEquals($expected, $result, "値が等しい事");

        Config::write('add', '2');
        $result = Config::read('add');
        $expected = '2';
        $this->assertEquals($expected, $result, "値が等しい事");

        Config::write('array', array('one' => 'first', 'two' => 'second'));
        $result = Config::read('array');
        $expected = array('one' => 'first', 'two' => 'second');
        $this->assertEquals($expected, $result, "値が等しい事");

        Config::write(array('default' => 100));
        $result = Config::read('default');
        $expected = '100';
        $this->assertEquals($expected, $result, "値が等しい事");
    }
}
