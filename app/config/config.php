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
    'detabase',
    array(
        'user' => 'pgadmin',
        'password' => '',
    )
);
