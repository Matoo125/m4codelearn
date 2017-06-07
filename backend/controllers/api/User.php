<?php 
namespace codelearn\controllers\api;

use m4\m4mvc\helper\user\UserController;
use m4\m4mvc\helper\Session;

class User extends UserController
{
	public function __construct()
	{
		// $this->create_user_table();
		$this->model = $this->getModel('User');
	}

	public function register()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		// echo json_encode($_POST);die;
		if (!$_POST) return $this->data = [
			'status' => 'ERROR',
			'message'	=>	'bad response type. '
		];

		if (!$_POST['username'] || !$_POST['email'] ||
			!$_POST['password'] || !$_POST['passwordCheck']) {
			return $this->data = [
				'status'	=>	'ERROR',
				'message'	=>	'Missing information'
			];
		}

		$data['username'] 		=	$_POST['username'];
		$data['email'] 			=	$_POST['email'];
		$data['password'] 		= 	$_POST['password'];
		$data['passwordCheck']	=	$_POST['passwordCheck'];

		if ($data['password'] != $data['passwordCheck']) {
			return $this->data = [
				'status'	=>	'ERROR',
				'message'	=>	'Passwords does not match'
			];
		}

		if ($this->model->checkByEmail($data['email'])) {
			return $this->data = [
				'status'	=>	'ERROR',
				'message'	=>	'This email is already registered'
			];
		}

		$data['password']	=	password_hash($data['password'], PASSWORD_DEFAULT);

		if ($this->model->register($data)) {
			return $this->data = [
				'status'	=>	'SUCCESS',
				'message'	=>	'You have been registered. '
			];
		}

	}

	public function login()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);

		if (!$_POST) return $this->data = [
			'status' => 'ERROR',
			'message'	=>	'bad response type. '
		];

		if (!$_POST['email'] || !$_POST['password']) {
			return $this->data = [
				'status'	=>	'ERROR',
				'message'	=>	'Missing information'
			];
		}

		if (!$user = $this->model->getByEmail($_POST['email'])) {
		    return $this->data = [
		    		'status'		=> 	'ERROR',
		    		'message'		=>	'User does not exists' // user does not exists
		    	];
		}

		if (password_verify($_POST['password'], $user['password'])) {
		    Session::set('user_id', $user['id']);
		    return $this->data = [
		    		'status'		=> 	'SUCCESS',
		    		'message'		=>	'You are logged in', // success
		    		'user_id'		=>	$user['id'],
		    		'user_name'		=>	$user['username'],
		    		'user_email'	=>	$user['email']
		    	];
		} 

		else {
		    return $this->data = [
		    		'status'		=> 	'ERROR',
		    		'message'		=>	'Credentials does not match' // Credentials does not match
		    	];
		}
	}

	public function logout () 
	{
		Session::destroy();
		return $this->data = [
			'status'	=>	'SUCCESS',
			'message'	=>	'You have been logged out'
		];
	}

	public function is_logged_in () {
      return $this->data = Session::get('user_id') ? [
      	'status'	=>	'TRUE'
      ] : [
      	'status'	=>	'FALSE'
      ];
	}

	public function ss () {
		Session::set('user_id', 1);
	}
}