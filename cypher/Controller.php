<?php

class Controller
{
    protected $controller_name;
    protected $action_name;
    protected $appliation;
    protected $request;
    protected $response;
    protected $session;
    protected $variables;

    public function __construct($dispatcher)
    {
        $this->controller_name = strtolower(substr(get_class($this), 0, -10));

        $this->application = $dispatcher;
        $this->request     = $dispatcher->getRequest();
        $this->response    = $dispatcher->getResponse();
        $this->session     = $dispatcher->getSession();

        $this->varibales = array();
    }

    public function run($action, $param)
    {
        $this->action_name = $action;
        if (!method_exists($this, $action)) {
            $this->forward404();
        }

        return $this->$action($param);
    }

    public function render($template = null, $layout = 'layouts/layout')
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

    public function forward404()
    {
    }

    public function redirect()
    {

    }

    public function set($index, $value)
    {
        $this->variables[$index] = $value;
    }
}
