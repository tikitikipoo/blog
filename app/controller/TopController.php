<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 7:17
 * To change this template use File | Settings | File Templates.
 */

class TopController extends FrontAppController
{

    public function index()
    {
		$posts = PostModel::getAll();

		$this->set('posts', $posts);
    }
}
