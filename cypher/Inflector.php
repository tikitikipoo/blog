<?php
namespace cypher;

class Inflector
{
    public static function camelize($str)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    }

    public static function underscore($str)
    {
        return strtolower(preg_replace('/([a-z]+(?=[A-Z])|[A-Z]+(?=[A-Z][a-z]))/', '\\1_', $str));
    }
}
