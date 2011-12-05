<?php
class Site_controller {
	
	private static $instance = null;
	public $load = null;

	protected function __construct() {
		$this->load = Load::getInstance();
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	

}
?>
