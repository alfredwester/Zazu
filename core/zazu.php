<?php
class Zazu {
	private static $instance = null;
	public $load = null;

	private function __construct() {
		$this->load = Load::getInstance();
	}

	public function frontController($controller = 'start') {
		$this->load->controller($controller);
		new $controller();
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
?>
