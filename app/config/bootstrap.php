<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/21
 * Time: 23:32
 * To change this template use File | Settings | File Templates.
 */
$env = $_SERVER['APP_ENV'];

if ($env === 'development') {
    error_reporting(-1);
    ini_set('display_errors', 'On');
}

require dirname(__FILE__) . DS . 'config.php';


