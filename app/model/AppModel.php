<?php

use \cypher\Model;

class AppModel extends Model
{

    public static function getDB($destination = 'default')
    {
        return DB::conn($destination);
    }
}
