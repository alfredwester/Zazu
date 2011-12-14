<?php
class Zazu {
	private static $instance = null;
	public $load = null;
	private $db_handler = null;
	private $debug_info = null;
	public $config = null;
	
	private function __construct() {
		$this->load = Load::getInstance();
		$this->debug_info = array();
		try {
			$this->db_handler = Db_handler::getInstance();
		}
		catch(Exception $e) {
			$this->debug_info['Errors'][] = $e;
			die($e->getMessage());
		}
		$result = $this->db_handler->select_query('SELECT * FROM '.DB_PREFIX.'config');
		while($obj = $result->fetch_object()) {
			$this->config[$obj->setting] = $obj->value;
		}
		$this->debug_info['config'] = $this->config;	
	}

	public function frontController() {
		
		$controller_name = $this->config['default_controller'];
		$function_name = $this->config['default_function'];
		$function_args = null;

		$url = substr($_SERVER['REQUEST_URI'], strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')));
		$this->debug_info['request_url'] = $url;

		$tmp_array = explode('/', trim($url, '/'));
		$this->debug_info['splitted_url'] = $tmp_array;

		if(!empty($tmp_array[0])) {
			$controller_name = $tmp_array[0];
		}
		if(!empty($tmp_array[1])) {
			$function_name = $tmp_array[1];
		}
		$function_args = array_slice($tmp_array, 2);
		
		$this->debug_info['requested_controller'] = $controller_name;
		$this->debug_info['requested_function'] = $function_name;
		$this->debug_info['function_arguments'] = $function_args;
		
		try {
			$this->load->controller($controller_name);
			$controller = new $controller_name();
			
			if(method_exists($controller, $function_name)) {
				call_user_func_array(array($controller, $function_name), $function_args);
			}
			else {
				$this->not_found();
			}	
		}
		catch(Exception $e) {
			$this->debug_info['Errors'][] = $e;
			$this->not_found();
		}

		$this->print_debug();
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function print_debug() {
		echo "<pre>";
		print_r($this->debug_info);
		print_r($_SERVER);
		echo "</pre>";
	}
	public function not_found() {
		
		header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
		echo "404 Not Found";
		$this->print_debug();
		exit;
	}
}
?>
