<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(dirname(__DIR__)) . DS);
}


if (!defined('APP_DIR')) {
    define('APP_DIR', ROOT_DIR . 'app' . DS);
}

define('CY_DIR', ROOT_DIR . DS . 'cypher' . DS);
define('CONTROLLER_DIR', CY_DIR . 'test/controller' . DS);
define('CONFIG_DIR', CY_DIR . 'test/config' . DS);

// autoload
require_once CY_DIR . 'SplClassLoader.php';

$ClassLoader = new cypher\SplClassLoader(
    array(
        ROOT_DIR,
        CONTROLLER_DIR,
        CY_DIR
    )
);
$ClassLoader->register();
