<?php

namespace cypher;

class Model
{

    protected $_table_name;

    protected $_class_name;

    protected $_validation_class;

    protected static $_validation_messages = array(
        'required'      => 'Required.',
        'length'        => 'Length is out of range.',
        'length_range'  => 'Length is out of range.',
        'numeric'       => 'Must be numeric.',
        'number_string' => 'Must be only with the numeric character.',
        'alpha'         => 'Must be only with the alphabet character.',
        'alphanum'      => 'Must be only with the alphabet or numeric character.',
        'singlebyte'    => 'Must be only with the single byte character.',
        'regex'         => 'It is an illegal character.',
    );

    /**
     * エンティティに当たるデータを格納
     */
    protected $_data = array();


    /**
     * @var array $_validation_errors
     *
     * バリデーションエラー情報を格納
     */
    public $_validation_errors = array();

    /**
     * @var array $_validation
     *
     * バリデーションルールを記述
     */
    public $validation = array();


    public function __construct(Array $data = array(), $params = array())
    {
        $class_name = ltrim(get_class($this), '\\');
        $namespace = '';
        if ($last_ns_pos = strrpos($class_name, '\\')) {
            $namespace = substr($class_name, 0, $last_ns_pos);
            $class_name = substr($class_name, $last_ns_pos + 1);
        }
        $this->_class_name = $class_name;

        if (is_null($this->_table_name)) {
            $this->_table_name = Inflector::underscore(get_class($this));
        }

        $this->setData($data);

        if (isset($params['validation_class'])) {
            $this->_validation_class = $params['validation_class'];
        } else {
            $this->_validation_class = new Validation();
        }

        $error_message = Config::read('error_message');
        if ($error_message) {
            $this->setDefaultErrorMessage($error_message);
        }
    }

    public function __get($name)
    {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
    }

    public function setValidator(Validator $validator)
    {
        $this->_validator = $validator;
    }

    public function setDefaultErrorMessage($messages)
    {
        if (!is_array($messages) && !($messages instanceof ArrayObject)) {
            throw new \InvalidArgumentException(__METHOD__. 'array or ArrayObject');
        }

        foreach ($messages as $key => $message) {
            self::$_validation_messages[$key] = $message;
        }
    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function validate() {

        $errors = 0;
        foreach ($this->_data[$this->_class_name] as $field => $value) {
            if (!isset($this->validation[$field])) continue;

            foreach ($this->validation[$field] as $k => $v) {

                $args = $v['rule'];
                $validate_func = array_shift($args);

                if (method_exists($this->_validation_class, $validate_func)) {
                    $valid = call_user_func_array(
                        array($this->_validation_class, $validate_func),
                        array_merge(array($value), $args)
                    );
                } else if (method_exists($this, $validate_func)) {
                    $valid = call_user_func_array(
                        array($this, $validate_func),
                        array_merge(array($value), $args)
                    );
                } else if (function_exists($validate_func)) {
                    $valid = call_user_func_array(
                        $validate_func, array_merge(array($v), $args)
                    );
                } else {
                    throw new \Exception($validate_func . ' does not exist');
                }

                if (!$valid) {
                    $this->_validation_errors[$field][$k] = isset($v['message'])
                        ? $v['message']
                        : (isset(self::$_validation_messages[$field]) ? self::$_validation_messages[$key] : '');
                    $errors++;
                }
            }
        }

        return $errors === 0 ? true : false;
    }

    public function hasError()
    {
        if (empty($this->_validation_errors)) {
            return false;
        } else {
            return true;
        }
    }

}
