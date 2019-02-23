<?php
class Db_handler {
	
	private static $instance = null;
	public $mysqli = null;
	
	private function __construct() {
		@$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

		if($this->mysqli->connect_error) {
			Logger::log(ERROR, 'Connection Error: '.$this->mysqli->connect_error);
			throw new Exception('Connection Error: '.$this->mysqli->connect_error);
		}
		$this->mysqli->set_charset('utf8');
		Logger::log(DEBUG, 'Connection to database established');
	}
	public function __destruct() {
		$this->mysqli->close();
		Logger::log(DEBUG, 'Connection to database closed');
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function multi_query($query) {
		Logger::log(TRACE, $query);
		$result[] = $this->mysqli->multi_query($query);
		while ($this->mysqli->more_results()) {
			$result[] = $this->mysqli->next_result();
			if(!empty($this->mysqli->error)) {
				$_SESSION['errors'][] = $this->mysqli->error;
				Logger::log(ERROR, $this->mysqli->error);
			}
		}
		return $result;
	}
	public function get_latest_error() {
		return $this->mysqli->error;
	}
	public function get_affected_rows() {
		return $this->mysqli->affected_rows;
	}
	public function select_query($query) {
		Logger::log(TRACE, $query);
		$result = $this->mysqli->query($query) or die ($this->mysqli->error);
		return $result;
	}
	public function query($query) {
		Logger::log(TRACE, $query);
		$result = $this->mysqli->query($query);
		if(!empty($this->mysqli->error)) {
			$_SESSION['errors'][] = $this->mysqli->error;
			$result = false;
			Logger::log(ERROR, $this->mysqli->error);
		}
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
