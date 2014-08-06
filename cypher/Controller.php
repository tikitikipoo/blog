<?php
namespace cypher;

class Controller
{
    protected $controller_name;
    protected $action_name;
    protected $appliation;
    protected $request;
    protected $response;
    protected $session;
    protected $variables;
    protected $layouts;

    public function __construct($dispatcher)
    {
        $this->controller_name = strtolower(substr(get_class($this), 0, -10));

        $this->application = $dispatcher;
        $this->request     = $dispatcher->getRequest();
        $this->response    = $dispatcher->getResponse();
        $this->session     = $dispatcher->getSession();

        $this->varibales = [];
    }

    public function run($action, $param)
    {
        if (!method_exists($this, $action)) {
            $this->forward404();
        }

        return $this->$action($param);
    }

    public function render($template = null, $layout = null)
    {
        $defaults = array(
            'request'  => $this->request,
            'base_url' => $this->request->getBaseUrl(),
            'session'  => $this->session,
        );

        $view = new View($this->application->getViewDir(), $defaults);

        if (is_null($template)) {
            $template = $this->action_name;
        }

        $path = $this->controller_name . DS . $template;

        $view->setVariables($this->variables);

        if (is_null($layout)) {
            $layout = $this->layout;
        }

        return $view->render($path, $layout);

    }

    public function beforeFilter()
    {
    }

    public function afterFilter()
    {
    }

    public function beforeRender()
    {
    }

    public function afterRender()
    {
    }

    public function forward404()
    {
        throw new \Cypher\HttpNotFoundException('Forward 404 page');
    }

    /**
     * Redirects the current url to another url
     */
    public function redirect($url, $code = 303)
    {
        if (!preg_match('#https?://#', $url)) {
            if (strpos($url, '/') != 0) {
                $url = '/' . $url;
            }
            $url = $this->request->getBaseUrl() . $url;
        }

        $this->response
            ->status($code)
            ->header('Location', $url)
            ->write($url)
            ->send();
        exit;
    }

    public function set($index, $value)
    {
        $this->variables[$index] = $value;
    }

    public function setActionName($name)
    {
        $this->action_name = $name;
    }
}
