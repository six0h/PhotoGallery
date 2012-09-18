<?php

require_once('mongo.class.php');

class User {
	
	private	 	$user_id,
			$user_first_name,
			$user_email,
			$user_admin;

	private function __constructor() {
	
	}

	public static function find_by_email($id) {
		global $db;

		$record = $db->select('users', array('user_email' => $id));

		foreach($record as $item) {
			$objProp = array(
				'user_id' => $item['_id'],
				'user_first_name' => $item['user_first_name'],
				'user_email' => $item['user_email'],
				'user_admin' => $item['user_admin']);
		}
		$obj = self::instantiate($objProp);
		
		return $obj;
	}
	
	public static function check_login($email = '',$password = '') {
		global $db,$data;

		$success = 1;
		
		if($email != '' && $password != '') {
			$password = md5($password);
			$crit = array(
					'user_email' => $email,
					'user_password' => $password
				);
			$result = $db->count('users', $crit);	

			if($result == 1) {
				$record = $db->select('users', $crit);

				// CONVERT MONGO OBJECT TO ARRAY
				foreach($record as $item) { 
					$objProp = array(
						'user_id' => $item['_id'],
						'user_first_name' => $item['user_first_name'],
						'user_email' => $item['user_email'],
						'user_admin' => $item['user_admin']);
				}

				// INSTANTIATE USER OBJECT
				$obj = self::instantiate($objProp);

				return $obj;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}

	public function get_user_id() {
		return $this->user_id;
	}

	public function get_user_first_name() {
		return $this->user_first_name;
	}

	public function get_user_email() {
		return $this->user_email;
	}

	public function is_admin() {
		return $this->user_admin;
	}

	private function instantiate($record) {
		$object = new self;
		foreach($record as $key=>$value) {
			$object->$key = $value;
		}
		return $object;
	}
	
}

?>
