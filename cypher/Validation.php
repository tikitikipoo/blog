<?php
namespace cypher;

class Validation
{

    /**
     * Execute validation of value required for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function required($value, $options)
    {
        if (trim($value) == '') {
            return false;
        }
        return true;
    }

    /**
     * Execute validation of value max length for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function length($value, $options)
    {
        $len = 0;
        if (array_key_exists('encoding', $options)) {
            $len = mb_strlen($value, $options['encoding']);
        } else {
            $len = mb_strlen($value);
        }
        if (array_key_exists('max', $options) && $len > $options['max']) {
            return false;
        }
        if (array_key_exists('min', $options) && $len < $options['min']) {
            return false;
        }

        return true;
    }

    /**
     * Execute validation of range of value length for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function lengthRange($value, $options)
    {
        return $this->length($value, $options);
    }

    /**
     * Execute validation of numeric for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function numeric($value, $options)
    {
        if ($value == '') {
            return true;
        }
        if (!is_numeric($value)) {
            return false;
        }
        return true;
    }

    /**
     * Execute validation of number string for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function numberString($value, $options)
    {
        if ($value == '') {
            return true;
        }
        if (!preg_match('/^[0-9]+$/', $value)) {
            return false;
        }
        return true;
    }

    /**
     * Execute validation of alphabet for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function alpha($value, $options)
    {
        if ($value == '') {
            return true;
        }
        if (!preg_match('/^[a-zA-Z]+$/', $value)) {
            return false;
        }
        return true;
    }

    /**
     * Execute validation of alphabet or number string for a request value
     *
     * @param mixed $value
     * @param array $options
     * @return boolean
     */
    public function alphaNum($value, $options)
    {
        if ($value == '') {
            return true;
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            return false;
        }
        return true;
    }

    //メールアドレス
    public function email($input)
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    //URL
    public function url($input)
    {
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }
}
