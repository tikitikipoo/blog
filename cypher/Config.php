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

    /**
     * 定義済みの値を返却
     *
     * @param sring
     * @return mixed 引数指定なしの場合すべての値を返却
     *               引数の定義がなかった場合false を返却
     */
    public static function read($name = null)
    {
        if (is_null($name)) {
            return self::$_values;
        }

        if (!isset(self::$_values[$name])) {
            return false;
        }

        return self::$_values[$name];
    }
}
