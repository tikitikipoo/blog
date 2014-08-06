<?php

class AdminAuthController extends AdminAppController {


	protected $auth_allow = ['admin_login', 'admin_logout'];

	function admin_index()
	{
		return $this->redirect('/admin/auth/login');
	}

	function admin_login()
	{
		if ($this->isAuth()) {
			$this->redirect('/admin/top/index');
		}

		if ($this->request->isPost()) {

			$data = $this->request->getPost();
			if ($user = UserModel::login($data)) {

				$this->session->set('auth', true);
				$this->session->set('user', [
					'id' => $user->id,
					'name' => $user->name
				]);
			}
			$this->redirect('/admin/top/index');

		}
	}

	function admin_logout()
	{
		$this->session->remove('auth');
		return $this->redirect('/admin/auth/login');
	}

}