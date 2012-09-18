<?php

require_once('db.class.php');

class Session {

	private $logged_in;
	private $db;
	public $user_id;
	

	function __constructor() {
		session_start();
		$this->check_login();
	}

	private function check_login() {

		if(isset($_SESSION['user_id'])) {
			$this->user_id = $_SESSION['user_id'];
			$this->logged_in = true;
		} else {
			$this->user_id = 0;
			$this->logged_in = false;
		}

	}

	public function is_logged_in() {
		return $this->logged_in;
	}

	public function login($user = '') {
		if($user) {
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->logged_in = true;
		}
	}

	public function logout() {
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->logged_in = false;
	}


}

$session = new Session($DB);
?>
