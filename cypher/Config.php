<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 9:11
 * To change this template use File | Settings | File Templates.
 */

namespace cypher;


class Config {

    public static $_values;

    public static function write($config, $value = null)
    {
        if (!is_array($config)) {
            $config = array($config => $value);
        }

        foreach ($config as $name => $value) {
            self::$_values[$name] = $value;
        }
    }

    public static function read($name = null)
    {
        if (is_null($name)) {
            return self::$_values;
        }

        return self::$_values[$name];
    }
}