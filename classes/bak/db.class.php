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
			$this->db->close();
		} catch (PDOException $e) {
			$success = 0;
			$this->error[] = $e->getMessage();
		}

		if ($success == 0) 
			$results = $this->appendErrors($this->error);
	}

	public function select($sql='',$values=null) {

		$this->last_query = $sql;

		$success = 1;
		if($sql != '') {
			try {
				$result = $this->db->prepare($sql);
				if($values) {
					foreach($values as $k=>$v) {
						$result->execute(array(":{$k}" => $v));
					}
				} else {
					$result->execute();
				}
			} catch(PDOException $e) {
				$this->error[] = $e->getMessage();
				$success = 0;
			}

			if($success == 1) {
				try {
					while($r = $result->fetch(PDO::FETCH_ASSOC)) {
						foreach($r as $row)
							$results[] = $row;
					}
				} catch (PDOException $e) {
						$success = 0;
						$this->error[] = $e->getMessage();
				}
			}
			
			if($success == 0)
				$results = $this->appendErrors($this->error);
			
		}
		echo $results;
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
