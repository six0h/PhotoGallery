<?php

class Photo {
	
	private function __construct() {
	
	}
	
	public static function find_by_sql($sql,$values) {
		global $DB;
	
		$query = $DB->prepare($sql);
		foreach($values as $k=>$v)
			$query->execute(array($k=>$v));
	
		$object = self::instantiate($query->fetch(PDO::FETCH_ASSOC));
	
		return $object;
	
	}
	
	public static function find_by_id($id) {
		global $DB;
		
		$sql = "SELECT * FROM `photos` WHERE `photo_id` = ?";
		$values = $id;

		$object = self::find_by_sql($sql, $values);
		
		return $object;
		
	}
	
	private function instantiate($record) {
		$object = new self;
		if($record) {
			foreach($record as $key=>$value) {
				$object->$key = $value;
			}
			return $object;
		}
	
	}
	
	function __destruct() {
	
	}
	
}

?>