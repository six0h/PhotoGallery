<?php

require_once('db.class.php');

class Session {

	private $logged_in=false;
	private $id;
	private $data = array();
	private $session_file;
	
	public function __construct() {
		$this->check_login();
		if($this->id) {
			$this->data = $this->get_session_data();
			$this->session_file = BASE_PATH . 'sessions/' . $this->id;
		}
	}
	
	private function get_data() {

		if(filesize($this->session_file) > 0) {
			$fh = fopen($this->session_file,'r');
			clearstatcache();
			$data = json_decode(fread($fh,filesize($this->session_file)));
			return $data;
		}
		
	}
	
	public function __destruct() {
	
		$this->write_session_data ();

	}

	private function write_session_data() {
		if(!empty($this->data)) {
			$fh = fopen($this->session_file,'w');
			clearstatcache();
			fwrite($fh,json_encode($this->data));
		}
	}

	
	public function check_login() {
		
		if(!isset($_SESSION['id'])) {
			$_SESSION['id'] = $this->generateUniqueId();
			$this->id = $_SESSION['id'];
		} else {
			$this->id = $_SESSION['id'];
		}
		
	}
	
	public function login($id = '') {

		if($id != '') {
			$this->logged_in = true;
			$this->data['user_id'] = $id;
		}

		
	}
	
	public function get_id() {
		return $this->id;
	}
	
	private function generateUniqueId($maxLength = 30) {
		$entropy = '';
	
		// try ssl first
		if (function_exists('openssl_random_pseudo_bytes')) {
			$entropy = openssl_random_pseudo_bytes(64, $strong);
			// skip ssl since it wasn't using the strong algo
			if($strong !== true) {
				$entropy = '';
			}
		}
	
		// add some basic mt_rand/uniqid combo
		$entropy .= uniqid(mt_rand(), true);
	
		// try to read from the windows RNG
		if (class_exists('COM')) {
			try {
				$com = new COM('CAPICOM.Utilities.1');
				$entropy .= base64_decode($com->GetRandom(64, 0));
			} catch (Exception $ex) {
			}
		}
	
		// try to read from the unix RNG
		if (is_readable('/dev/urandom')) {
			$h = fopen('/dev/urandom', 'rb');
			$entropy .= fread($h, 64);
			fclose($h);
		}
	
		$hash = hash('whirlpool', $entropy);
		if ($maxLength) {
			return substr($hash, 0, $maxLength);
		}
		return $hash;

	}

	public function logout() {
		unset($_SESSION['id']);
		unset($this->id);
		$this->logged_in = false;
		unlink($this->session_file);
		session_destroy();
	}

}

$session = new Session;

?>
