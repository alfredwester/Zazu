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

	private function load_file($file_name, $type, $data = null) {
		$path = '';
		switch($type){
			case 'view':
				$path = 'views/'.$file_name;
			break;
			case 'model':
				$path = 'models/'.$file_name;
			break;
			case 'controller':
				$path = 'controllers/'.$file_name;
			break;
			default:
				die('Unknown type \''.$type.'\' can´t be loaded');
			break;
		}

		$path .= '.php';
		
		if(is_array($data)) {
			extract($data);
		}
		if(file_exists($path)) {
			require_once $path;
		}
		else {
			die($file_name.' not found in '.$path);
		}
	}

	function view($view_name, $data = null) {
		$this->load_file($view_name, 'view', $data);
	}

	function model($model_name) {
		$this->load_file($model_name, 'model');
	}

	function controller($controller_name) {
		$this->load_file($controller_name, 'controller');
	}
}


?>
