<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 15:08
 * To change this template use File | Settings | File Templates.
 */

namespace cypher\test;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Request.php';
use cypher\Request;


class RequestTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function test_パスが正常にパースできること()
    {
        ////////////
        // パターン1
        ////////////

        $request = array(
            'server'  => array(
                'REQUEST_URI' => '/foo/bar/list',
                'SCRIPT_NAME' => '/foo/bar/index.php',
            ),
            'post'    => array(),
            'get'     => array(),
            'request' => array(),
            'files'   => array(),
            'cookie'  => array(),
            'env'     => array(),
        );

        $Request = Request::create($request);
        $result = $Request->getBasePath();
        $expected = '/foo/bar';

        $this->assertEquals($expected, $result, '正しくペースパスが抽出されていること1');

        $result = $Request->getRequestPath();
        $expected = "/list";
        $this->assertEquals($expected, $result, '正しくリクエストパスが抽出されていること1');

        ////////////
        // パターン2
        ////////////

        $request = array(
            'server'  => array(
                'REQUEST_URI' => '/index.php/list?foo=bar',
                'SCRIPT_NAME' => '/index.php',
            ),
            'post'    => array(),
            'get'     => array(),
            'request' => array(),
            'files'   => array(),
            'cookie'  => array(),
            'env'     => array(),
        );

        $Request = Request::create($request);
        $result = $Request->getBasePath();
        $expected = '/index.php';

        $this->assertEquals($expected, $result, '正しくペースパスが抽出されていること2');

        $result = $Request->getRequestPath();
        $expected = "/list";
        $this->assertEquals($expected, $result, '正しくリクエストパスが抽出されていること2');

        ////////////
        // パターン3
        ////////////

        $request = array(
            'server'  => array(
                'REQUEST_URI' => '/',
                'SCRIPT_NAME' => '/index.php',
            ),
            'post'    => array(),
            'get'     => array(),
            'request' => array(),
            'files'   => array(),
            'cookie'  => array(),
            'env'     => array(),
        );

        $Request = Request::create($request);
        $result = $Request->getBasePath();
        $expected = '';

        $this->assertEquals($expected, $result, '正しくペースパスが抽出されていること2');

        $result = $Request->getRequestPath();
        $expected = "/";
        $this->assertEquals($expected, $result, '正しくリクエストパスが抽出されていること2');

    }
}
