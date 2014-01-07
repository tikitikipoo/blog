<?php
/**
 * User: tikitikipoo
 * Date: 13/06/21
 * Time: 22:37
 * To change this template use File | Settings | File Templates.
 */

namespace cypher;


class Router {

    private $routes;

    public function __construct($definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }

    public function compileRoutes($definitions)
    {
        $routes = array();

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $i => $token) {
                if (strpos($token, ':') === 0) {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name . '>[^/]+)';
                }
                $tokens[$i] = $token;
            }

            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }

        return $routes;

    }

    public function getRoues()
    {
        return $this->routes;
    }

    public function resolve($pathInfo)
    {
        if (substr($pathInfo, 0, 1) != '/') {
            $pathInfo = '/' . $pathInfo;
        }

        foreach ($this->routes as $pattern => $params) {

            if (preg_match('#^' . $pattern . '$#', $pathInfo, $matches)) {
                $params = array_merge($params, $matches);
                unset($params[0]);
                $params = array_merge($params);
                return $params;
            }
        }

        // 指定したルーティング以外の処理
        $urlInfo = explode('/', ltrim($pathInfo, '/'));

        if (isset($urlInfo[0]) && isset($urlInfo[1])) {
            $params = $urlInfo;
            $params['controller'] = $urlInfo[0];
            $params['action']     = $urlInfo[1];
            unset($params[0]);
            unset($params[1]);
            $params = array_merge($params);
            return $params;
        }

        if (isset($urlInfo[0])) {
            $params = $urlInfo;
            $params['controller'] = $urlInfo[0];
            $params['action'] = 'index';
            unset($params[0]);
            $params = array_merge($params);
            return $params;
        }

        return false;
    }
}
