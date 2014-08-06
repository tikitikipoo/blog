<?php

// use \cypher\Controller;

class AdminAppController extends AppController
{
	public $auth = [
		'login_action' => [
			'controller' => 'AdminAuthController',
			'action' 	 => 'login'
		],
		'logout_action' => [
			'controller' => 'AdminAuthController',
			'action' 	 => 'logout'
		],
		'login_url' => '/admin/auth/login'
	];

	protected $auth_allow = [];

	protected $layout = 'layouts/layout';

	public function beforeFilter()
	{
		if (!$this->checkAuthentication()) {

			$this->redirect($this->auth['login_url']);
		}
	}

	public function checkAuthentication()
	{

		if (!$this->needAuthentication($this->auth_allow)) {
			return true;
		}

		// セッションチェック
		if ($this->isAuth()) {
			return true;
		}
		
		return false;
	}

	public function needAuthentication(Array $allow_action_names = [])
	{
		if (in_array($this->action_name, $allow_action_names)) {
			return false;
		}
		return true;
	}

	public function isAuth()
	{
		$result = $this->session->get('auth');
		if ($result === true) {
			return true;
		}
		return false;
	}
}
