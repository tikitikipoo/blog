<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/21
 * Time: 23:31
 * To change this template use File | Settings | File Templates.
 */

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(dirname(__FILE__)) . DS);
}


if (!defined('APP_DIR')) {
    define('APP_DIR', ROOT_DIR . 'app' . DS);
}

define('CY_DIR', ROOT_DIR . DS . 'cypher' . DS);
define('CONTROLLER_DIR', APP_DIR . 'controller' . DS);
define('MODEL_DIR', APP_DIR . 'model' . DS);
define('LIB_DIR', APP_DIR . 'lib' . DS);

// autoload
require CY_DIR . 'SplClassLoader.php';

$ClassLoader = new cypher\SplClassLoader(
    array(
        ROOT_DIR,
        CY_DIR,
        CONTROLLER_DIR,
        MODEL_DIR,
        LIB_DIR
    )
);
$ClassLoader->register();
