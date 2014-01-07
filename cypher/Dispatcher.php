<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 0:27
 * To change this template use File | Settings | File Templates.
 */

namespace cypher;


class Dispatcher {

    protected $debug = false;
    protected $Request;
    protected $Response;
    protected $Session;
    protected $settings;

    private static $controller_dir;
    private static $view_dir;

    public function __construct($settings = array())
    {
        $default = array(
            'request'  => null,
            'response' => null,
            'session'  => null,
            'debug'    => false,
        );

        $this->settings = array_merge($default, $settings);

        $this->setDebugMode($this->settings['debug']);
        $this->configure();
        $this->init();
    }

    protected function setDebugMode($debug)
    {
        if ($debug) {
            $this->debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    public function init()
    {
        $this->Request  = is_null($this->settings['request']) ? new Request() : $this->settings['request'];
        $this->Response = is_null($this->settings['response']) ? new Response() : $this->settings['response'];
        $this->Session  = is_null($this->settings['session']) ? new Session(): $this->settings['session'];
        $this->Router   = new Router($this->registerRoutes());
    }

    /**
     * Routerからコントローラーを特定しレスポンスを送信するまでを管理
     */
    public function dispatch()
    {
        try {

            $params = $this->Router->resolve($this->Request->getRequestPath());

            $controller = $params['controller'];
            $action     = $params['action'];

            $this->runAction($controller, $action, $params);

        } catch(HttpNotFoundException $e) {

        }

        $this->Response->send();

    }


    protected function configure()
    {
    }

    protected function registerRoutes()
    {
        return Config::read('routes');
    }

    public function isDebugMode()
    {
        return $this->debug;
    }

    public function getRequest()
    {
        return $this->Request;
    }

    public function getResponse()
    {
        return $this->Response;
    }

    public function getSession()
    {
        return $this->Session;
    }

    public static function getControllerDir()
    {
        if (self::$controller_dir) {
            return self::$controller_dir;
        }
        return CONTROLLER_DIR;
    }

    public function setControllerDir($controller_dir)
    {
        if ($this->isDebugMode()) {
            self::$controller_dir = $controller_dir;
        }
    }

    public static function getViewDir()
    {
        if (self::$view_dir) {
            return self::$view_dir;
        }
        return VIEW_DIR;
    }

    public function setViewDir($view_dir)
    {
        if ($this->isDebugMode()) {
            self::$view_dir = $view_dir;
        }
    }

    public function run()
    {
    }


    /**
     * 実際にアクションを実行する
     */
    public function runAction($controller_name, $action, $params = array())
    {
        $controller_class = ucfirst($controller_name) . 'Controller';

        $controller = $this->findController($controller_class);
        if (!$controller) {
            throw new HttpNotFoundException($controller_class . ' controller is not found.');
        }

        $content = $controller->run($action, $params);
        if (!$content) {
            $content = $controller->render();
        }

        $this->Response->write($content);
    }

    /**
     * コントローラークラスを生成
     */
    public function findController($controller_class)
    {
        if (!class_exists($controller_class)) {

            $controller_file = self::getControllerDir() . $controller_class . '.php';

            if (!is_readable($controller_file)) {
                return false;
            } else {
                require_once $controller_file;

                if (!class_exists($controller_class)) {
                    return false;
                }
            }
        }

        return new $controller_class($this);
    }

}
