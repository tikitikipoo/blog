<?php

class View
{
    protected $view_dir;
    protected $defaults;
    protected $variables = array();

    public function __construct($view_dir, $defaults)
    {
        $this->view_dir = $view_dir;
        $this->defaults = $defaults;
    }

    public function setVariables($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $i => $v) {
                $this->variables[$i] = $v;
            }
        } else {
            $this->variables[$name] = $value;
        }
    }

    public function render($_view, $_layout = false, $variables = array())
    {
        $_file = $this->view_dir . DS . $_view . '.php';

        $_variables = array_merge($this->defaults, $this->variables);
        $_variables = array_merge($_variables, $variables);
        extract($_variables);

        ob_start();
        ob_implicit_flush(0);

        require $_file;

        $content = ob_get_clean();

        if ($_layout) {
            $content = $this->render($_layout, false, array('_content' => $content));

        }
        return $content;
    }
}
