<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 0:27
 * To change this template use File | Settings | File Templates.
 */

namespace cypher;


class Dispatcher {

    public function __construct()
    {

        $this->initialize();

    }

    public function dispatch()
    {

    }

    public function initialize()
    {
        $this->Request = new Request;
        // $this->Response = new 
    }
}
