<?php
class Core {
	private static $instance = null;
	public $load = null;

	private function __construct() {
		$this->load = Load::getInstance();
		$this->load->controller('controller');
		new controller();
	
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
?>
