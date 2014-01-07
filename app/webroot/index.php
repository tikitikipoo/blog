<?php
# __DIR__ # /path/to/app/webroot
# dirname(__DIR__) # /path/to/app
# dirname(dirname(__DIR__)) # /path/to

# __FILE__ # /path/to/app/webroot/index.php
# dirname(__FILE__) # /path/to/app/webroot
# dirname(dirname(__FILE__)) # /path/to/app
# dirname(dirname(dirname(__FILE__))) # /path/to/app
function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    if (error_reporting() === 0)
    {
        return;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('exception_error_handler');

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(dirname(dirname(__FILE__))) . DS);
}

if (!defined('APP_DIR')) {
    define('APP_DIR', ROOT_DIR . 'app' . DS);
}

if (!include (ROOT_DIR . DS . 'cypher' .DS . 'bootstrap.php')) {
    throw new Exception("app bootstrap.php could not be found");
}

if (!include (APP_DIR. 'config' . DS . 'bootstrap.php')) {
    throw new Exception("core bootstrap.php could not be found");
}

// Applicationの実行
$Dispatcher = new \cypher\Dispatcher();
$Dispatcher->dispatch();
