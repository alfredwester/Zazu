<?php
class Zazu extends Helper {
	private static $instance = null;
	public $load = null;
	private $db_handler = null;
	private $debug_info = null;
	public $config = null;
	
	private function __construct() {
		session_start();
		$this->load = Load::getInstance();
		$this->debug_info = array();
		try {
			$this->db_handler = Db_handler::getInstance();
		}
		catch(Exception $e) {
			$this->debug_info['Errors'][] = $e;
			$this->redirect(500, null, $e->getMessage());
		}
		$result = $this->db_handler->query('SELECT * FROM '.DB_PREFIX.'config');
		while($obj = $result->fetch_object()) {
			$this->config[$obj->setting] = $obj->value;
		}
		$this->debug_info['config'] = $this->config;
	}
	public function frontController() {
		
		$controller_name = $this->config['default_controller'];
		$function_name = $this->config['default_function'];
		$function_args = array();
		$controller_path = 'controllers/';

		$url = substr($_SERVER['REQUEST_URI'], strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')));
		$this->debug_info['request_url'] = $url;

		$tmp_array = explode('/', trim($url, '/'));
		$this->debug_info['splitted_url'] = $tmp_array;
		$redirect = false;

		if(!empty($tmp_array[1])) {
			$function_name = $tmp_array[1];
			$function_args = array_slice($tmp_array, 2);
			if($function_name == $this->config['default_function']) {
				$redirect = true;
				$args = '/';
				foreach($function_args as $arg) {
					$args = $args.$arg.'/';
				}
				$redirect_url = $args;
			}
		}
		if(!empty($tmp_array[0]) && file_exists($controller_path.$tmp_array[0].'.php')) {
			$controller_name = $tmp_array[0];
			$this->load->controller($controller_name);
			if($controller_name == $this->config['default_controller']) {
				$redirect = true;
				$args = '/';
				foreach($function_args as $arg) {
					$args = $args.$arg.'/';
				}
				if($function_name == $this->config['default_function']) {
					$redirect_url = $args;
				}
				else {
					$redirect_url = $function_name.$args;
				}
			}
		}
		elseif (!empty($tmp_array[0])) {
			$this->load->controller($controller_name);
			if(method_exists($controller_name, $tmp_array[0])) {
				$function_name = $tmp_array[0];
				$function_args = array_slice($tmp_array, 1);
				 if($function_name == $this->config['default_function']) {
					$redirect = true;
					$args = '/';
					foreach($function_args as $arg) {
						$args = $args.$arg.'/';
					}
					$redirect_url = $args;
				}
			}
			else {
				$function_args = $tmp_array;
			}
		}
		
		if($redirect)
		{
			$this->redirect(301, $redirect_url);
		}
				
		try {
			$this->load->controller($controller_name);
			$controller = new $controller_name($this->config);
			
			if(method_exists($controller, $function_name)) {
				call_user_func_array(array($controller, $function_name), $function_args);
			}
			else {
				$this->redirect(404);
			}	
		}
		catch(Exception $e) {
			$this->debug_info['Errors'][] = $e;
			$this->redirect(500, null, $e->getmessage());
		}
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
		echo "</pre>";
	}
}
?>
