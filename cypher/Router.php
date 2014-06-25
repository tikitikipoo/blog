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
    private $prefix;

    public function __construct($definitions, $prefix = null)
    {
        $this->routes = $this->compileRoutes($definitions);
        $this->prefix = $prefix;
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

            $params['token_count'] = count($tokens);
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
                if (isset($params['token_count'])) {
                    for ($i = 0; $i < $params['token_count']; $i++) {
                        unset($params[$i]);
                    }
                    unset($params['token_count']);
                }
                $params = array_merge($params);

                if (isset($params['prefix'])) {
                    $params['action'] = $params['prefix'] . '_' . $params['action'];
                }
                return $params;
            }
        }

        // 指定したルーティング以外の処理
        $urlInfo = explode('/', ltrim($pathInfo, '/'));

        if (isset($urlInfo[0]) && isset($urlInfo[1])) {

            if ($urlInfo[0] == $this->prefix) {
                $urlInfo[0] = $urlInfo[1];
                if (isset($urlInfo[2])) {
                    $urlInfo[1] = $this->prefix . '_' . $urlInfo[2];
                    unset($urlInfo[2]);
                } else {
                    $urlInfo[1] = $this->prefix . '_' . 'index';
                }
            }

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
