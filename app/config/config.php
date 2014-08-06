<?php
/**
 * アプリ固有の設定
 *
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 9:59
 * To change this template use File | Settings | File Templates.
 */
use cypher\Config;

Config::write(
    'database_default',
    array(
        'host'     => 'localhost',
        'dbname'   => 'cypher_blog_dev',
        'dsn'      => 'mysql:host=localhost;dbname=cypher_blog_dev',
        'user'     => 'root',
        'password' => 'localhost',
        'timeout'  => '3'
    )
);

Config::write('salt' , '1234567890');