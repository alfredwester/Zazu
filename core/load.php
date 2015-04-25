<?php
class Load {
	private static $instance = null;
	
	private function __construct() {
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	function controller($controller) {
		$path = 'controllers/'.$controller.'.php';
		if(file_exists($path)) {
			require_once($path);
		}
		else {
			Logger::log(ERROR, 'Controller '.$controller.' not found in '.dirname($path));
			throw new Exception('Controller '.$controller.' not found in '.dirname($path));
		}

	}
}


?>
