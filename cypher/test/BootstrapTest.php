<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 1:00
 * To change this template use File | Settings | File Templates.
 */

namespace cypher\test;

require_once dirname(dirname(__FILE__)).'/bootstrap.php';

class BootstrapTest extends \PHPUnit_Framework_TestCase {


    public function test_ディレクトリ設定が正しいこと()
    {

        $expected = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
        $this->assertEquals($expected, ROOT_DIR, 'ROOTのパスが正しいこと');

        $expected = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
        $this->assertEquals($expected, APP_DIR, 'APPのパスが正しいこと');

    }
}
