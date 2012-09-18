<?php

class DataBase {

	private $user = DB_USER;
	private $pass = DB_PASS;
	private $host = DB_HOST;
	private $name = DB;
	private $last_query;
	protected $db = '';
	public $error = array();

	public function __construct() {
		$this->connect();
	}

	private function connect() {
		$success = 1;
		try {
			$this->db = new PDO('mysql:host='. $this->host .';dbname='. $this->name, $this->user, $this->pass);
		} catch (PDOException $e) {
			$success = 0;
			$this->error[] = $e->getMessage();
		}
		
		if($success == 0) 
			$this->appendErrors($this->error);
	}

	public function disconnect() {
		$success = 1;
		try {
			$this->db = null;
		} catch (PDOException $e) {
			$success = 0;
			$this->error[] = $e->getMessage();
		}

		if ($success == 0) 
			$results = $this->appendErrors($this->error);
	}

	public function select($sql='',$values=array()) {

		$this->last_query = $sql;

		$success = 1;
		if($sql != '') {
		
			$query = $this->db->prepare($sql);
			if(isMultiArray($values)) {
				foreach($values as $v) {
					$query->execute($v);
					$results[] = $query->fetch(PDO::FETCH_OBJ);
				}
			} else {
  				$query->execute($values);
				$results = $query->fetch(PDO::FETCH_OBJ);
			}
			// If there is only one record returned, return result, not array of results
// 			if(count($results) == 1) $results = $results[0];
			
			if($success == 0)
				$results = $this->appendErrors($this->error);
		}
		
		return $results;
	}
	
	public function insert($querystring) {
		try {
			$results = $this->db->prepare($querystring);
			$results->execute();
		} catch (PDOException $e) {
			$success = 0;
			$this->error[] = $e->getMessage();
		}
		
		if($success == 0) 
			$result = $this->appendErrors($this->error);
		
		return $result;
	}
	
	private function appendErrors($error) {
	
		if(count($error) > 0) {
			foreach($error as $err) {
				$result[] = "Error: ".$err."<br />Last Query: ".$this->last_query;				
			}
			return $result;
		}
		
	}


}

$DB = new DataBase();
?>
