<?php
/**
 * ルーティングの定義
 */

use cypher\Config;

Config::write(
    'routes',
    array(
        '/' => array('controller' => 'top', 'action' => 'index'),
        '/:controller' => array('action' => 'index'),
        '/posts/view/:id' => array('controller' => 'posts', 'action' => 'view'),
        '/admin/:controller/:action' => array('prefix' => 'admin'),
    )
);
