<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 11:15
 * To change this template use File | Settings | File Templates.
 */

namespace cypher;


class Request {

    protected $server;

    protected $get;

    protected $post;

    protected $request;

    protected $files;

    protected $cookie;

    protected $env;

    public function __construct($params = array())
    {
        $this->server  = isset($params['server'])  ? $params['server']  : $_SERVER;
        $this->get     = isset($params['get'])     ? $params['get']     : $_GET;
        $this->post    = isset($params['post'])    ? $params['post']    : $_POST;
        $this->request = isset($params['request']) ? $params['request'] : $_REQUEST;
        $this->files   = isset($params['files'])   ? $params['files']   : $_FILES;
        $this->cookie  = isset($params['cookie'])  ? $params['cookie']  : $_COOKIE;
        $this->env     = isset($params['env'])     ? $params['env']     : $_ENV;

    }

    public static function create($param) {
        return new Request($param);
    }

    public function getServer($index = null, $default = null)
    {
        if (is_null($index)) {
            return $this->server;
        }

        if (array_key_exists($index, $this->server)) {
            return $this->server[$index];
        }
        return $default;
    }

    public function isGet()
    {
        return ($this->getServer('REQUEST_METHOD') === 'GET');
    }

    public function isPost()
    {
        return ($this->gerServer('REQUEST_METHOD') === 'POST');
    }

    public function isXMLHTTPRequest()
    {
        return ($this->getHeader('X-REQUESTED-WITH') === 'XMLHttpRequest');
    }

    public function isHTTPS()
    {
        $https = $this->getServer('HTTPS');
        return (
            isset($https) &&
            !empty($https) &&
            strtolower($https) != 'off'
        );
    }

    public function getGet($index = null, $default = null)
    {
        if ($index = null) {
            return $this->get;
        }

        if (array_key_exists($index, $this->get)) {
            return $this->get[$index];
        }
        return $default;
    }

    public function getPost($index = null, $default = null)
    {
        if ($index = null) {
            return $this->post;
        }

        if (array_key_exists($index, $this->post)) {
            return $this->post[$index];
        }
        return $default;
    }

    public function get($name, $default = null)
    {
        return isset($this->request[$name]) ? $this->request[$name] : $default;
    }

    /**
     *
     * @return str blog.local.com
     */
    public function getHost()
    {
        $host = $this->getServer('HTTP_HOST');
        if (!empty($host)) {
            return $host;
        }
        return $this->getServer('SERVER_NAME');
    }

    public function getRequestUri()
    {
        return $this->getServer('REQUEST_URI');
    }

    public function getBaseUrl($https = false)
    {
        $url = $https ? 'https://' : 'http://';
        return $url . $this->getHost() . DS ;
    }

    public function getBasePath()
    {
        $scriptName = $this->getServer('SCRIPT_NAME');
        $requestUri = $this->getRequestUri();

        if (strpos($requestUri, $scriptName) === 0) {
            return $scriptName;

        } else if (strpos($requestUri, dirname($scriptName)) === 0) {
            return rtrim(dirname($scriptName), '/');
        }

        return '';
    }

    public function getRequestPath()
    {
        $basePath   = $this->getBasePath();
        $requestUri = $this->getRequestUri();

        if (($pos = strpos($requestUri, '?')) != false) {
            $requestUri = substr($requestUri, 0 , $pos);
        }

        return (String)substr($requestUri, strlen($basePath));
    }
}
