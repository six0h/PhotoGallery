<?php

require_once('db.class.php');

class User {

	protected $db;
	public 	$user_id = '',
		$info = '';
	private $last_query = '';
	
	private function __construct() {
		global $DB;
	}

	private static function instantiate($record) {
		$object = new self;
		foreach($record as $key=>$value) {
			$object->$key = $value;
		}

		return $object;
	}

	public static function find_all() {

		global $DB;
		$query = "SELECT * FROM `users`";
		$result = $DB->select($sql);
		foreach($results as $r) {
			$results[] = $r;
		}
		return $results;
	}

	public static function find_by_id($id = '') {

		global $DB;
		$query = "SELECT * FROM `users` WHERE `user_id` = ':id'";
		$values = array('id'=>$id);
		$results = $DB->select($query,$values);

		return $this->instantiate($results);

	}

	public static function find_by_email($email = '') {
	
		global $DB;
		$query = "SELECT * FROM `users` WHERE `user_email` = ':email'";
		$values = array('email'=>$email);
		$results = $DB->select($sql,$values);

		return $this->instantiate($results);

	}

	private function getUser($user) {

		global $DB;
		if(gettype($user) == 'integer') 
			$querystring = "SELECT * FROM users WHERE `user_id` = '$user'";
		else
			$querystring = "SELECT * FROM users WHERE `user_email` = '$user'";
		$results = $DB->select($querystring);
		return $results;
	}

	public function login($login_user,$login_pass) {

		global $DB;
		$success = 1;
	
		$qs = array(
			'user_email' => $login_user,
			'user_pass' => md5($login_pass)
		);
		$querystring = "SELECT * FROM `users` WHERE `user_email` = '".$qs['user_email']."' AND `user_pass` = '".$qs['user_pass']."'";
		$numresults = count($results = $DB->select($querystring));
		if($numresults == '1') {
			foreach($results as $result) {
				$_SESSION['userId'] = $result['user_id'];
			}
			$this->info = $result;
		} else {
			$success = 0;
			session_destroy();
			$this->userId = '0';
		}

	}

	public function logout() {

		session_destroy();

//		<script type="text/javascript">parent.window.location='index.php';</script>

	}

}

?>
