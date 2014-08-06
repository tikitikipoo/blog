<?php

class AdminPostController extends AdminAppController {


	public function admin_index()
	{

		$posts = PostModel::getAll();

		$this->set('posts', $posts);

	}

	public function admin_add()
	{
		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			if ($status = PostModel::add($data)) {
				$this->redirect('/admin/post/index');
			}
		}
	}

	public function admin_edit($params)
	{

		$post = PostModel::get($params['id']);

		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			if ($status = PostModel::edit($data)) {
				$this->redirect('/admin/post/index');
			}
		}

		$this->set('post', $post);
	}

}