<?php
namespace cypher;

class View
{
    protected $view_dir;
    protected $defaults;
    protected $helpers;
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

    public function getVariables($name)
    {
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        }
        return null;
    }

    public function get($name)
    {
        return $this->getVariables($name);
    }

    public function setHelpers($helpers)
    {
        $thi->helpers = $helpers;
    }

    public function render($_view, $_layout = false, $variables = array())
    {
        $_file = $this->view_dir . $_view . '.php';

        $_variables = array_merge($this->defaults, $variables);
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

    public function partial($view, $variable = array())
    {
        $_file = $this->view_dir . $view . '.php';
        require $_file;
    }

    public function includeHelper()
    {
        $dir  = $this->view_dir . 'helper' . DS;

        if (empty($this->helpers)) {
            return;
        }

        foreach($this->helpers as $helper) {
            $file = $dir . ucfirst($helper) . 'Helper.php';

            if (is_file($file)) {
                require_once $file;
            }
        }
    }

    /**
     * 指定された値をHTMLエスケープする
     *
     * @param string $string
     * @return string
     */
    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
