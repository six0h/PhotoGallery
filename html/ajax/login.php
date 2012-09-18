<?php

require_once('../config.php');

$success = 1;
$error = array();
$response = array();

if(isset($_POST['user_login'])) {
	if(!empty($_POST['user_email']) && !empty($_POST['user_password']) && !empty($_POST['session_id'])) {
		$session_id = $_POST['session_id'];
		if(!isset($data['user_email'])) {
			$user = User::check_login($_POST['user_email'],$_POST['user_password']);
			if(isset($user)) :
				$data = $session->read($session_id);
				$data['user_email'] = $user->get_user_email();
				$data['user_first_name'] = $user->get_user_first_name();
				$session->write($session_id,$data);
			else :
				$data['user_email'] = '';
				$success = 0;
				$error[] = 'Username and Password Incorrect';
			endif;
		}
	} else {
		$success = 0;
		$error[] = 'Missing username or password, please try again.';
	}

	if($success == 1) {
		$response = array(
			'status' => 'success',
			'user_email' => $data['user_email'],
			'user_first_name' => $data['user_first_name']);
		echo json_encode($response);
	} else {
		$response = array(
			'status' => 'fail',
			'errors' => $error,
			'user_email' => '',
			'user_first_name' => '');
		echo json_encode($response);
	}
}

