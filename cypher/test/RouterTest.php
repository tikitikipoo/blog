<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/21
 * Time: 22:47
 * To change this template use File | Settings | File Templates.
 */

namespace cypher\test;

require_once dirname(__DIR__).'/bootstrap.php';

use cypher\Config;
use cypher\Router;

require __DIR__ . DIRECTORY_SEPARATOR  . 'config' . DIRECTORY_SEPARATOR .'config.php';

class RouterTest extends \PHPUnit_Framework_TestCase {


    public function test_パターンが正しく設定できること()
    {

        $Router = new Router(Config::read('routes'));
        $routes = $Router->getRoues();
        $this->assertEquals(1, 1, '正しくパターンが設定されていること1');
    }

    public  function test_パス解析が正しく動作すること()
    {
        $Router = new Router(Config::read('routes'));
        $result = $Router->resolve('/posts/view/10');
        $expected = array(
            'controller' => 'posts',
            'action' => 'view',
            'id' => '10',
            '0' => '10'
        );
        $this->assertEquals($expected, $result, '/posts/view/:idのルーティングが正しく動作すること');


        $result = $Router->resolve('/items/index/10/20');
        $expected = array(
            'controller' => 'items',
            'action' => 'index',
            '0' => 10,
            '1' => 20
        );
        $this->assertEquals($expected, $result, '/items/index/10/20のルーティングが正しく動作すること');


        $result = $Router->resolve('/posts');
        $expected = array(
            'controller' => 'posts',
            'action' => 'index'
        );
        $this->assertEquals($expected, $result, '/postsのルーティングが正しく動作すること');


        $result = $Router->resolve('/articles/edit/10');
        $expected = array(
            'controller' => 'articles',
            'action' => 'edit',
            '0' => 10
         );
        $this->assertEquals($expected, $result, '/articles/edit/10のルーティングが正しく動作すること');

    }
}
