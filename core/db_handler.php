<?php
class Db_handler {
	
	private static $instance = null;
	public $mysqli = null;
	
	private function __construct() {
		@$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		if($this->mysqli->connect_error) {
			throw new Exception('Connection Error: '.$this->mysqli->connect_error);
		}
		$this->mysqli->set_charset('utf-8');
	}
	public function __destruct() {
		$this->mysqli->close();
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function query($query) {
		$result = $this->mysqli->query($query) or die ($this->mysqli->error);
		return $result;
	}
	public function db_escape_chars($data) {
		$temp = $data;
		
		if(is_array($temp)) {
			foreach($temp as $key => $val) {
				$temp[$key] = $this->mysqli->real_escape_string($val);
			}
		}
		else {
			$temp = $this->mysqli->real_escape_string($temp);
		}
		return $temp;
	}
}
