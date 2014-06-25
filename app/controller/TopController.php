<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 7:17
 * To change this template use File | Settings | File Templates.
 */

class TopController extends AppController
{

    public function index()
    {
        $res = StatusModel::getAll();
        var_dump($res);
    }
}
