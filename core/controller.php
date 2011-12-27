<?php
class Controller {

	function __construct($config) {
		echo "Controller:";
		var_dump($config);
	}


	public function load_view($view, $data = null) {
		$path = 'views/'.$view.'.php';
		if(is_array($data)) {
			extract($data);
		}
		if(file_exists($path)) {

			ob_start(); // start buffer
			include ($path);
			$view = ob_get_contents(); // assign buffer contents to variable
			ob_end_clean(); // end buffer and remove buffer contents
			echo $view;
		}
		else {
			throw new Exception('View \''.$view.'\' not found in '.dirname($path));
		}
	}
	public function load_theme($theme, $data) {
		$path = 'theme/'.$theme.'/';
		if(!is_dir($path)) {
			die("The directory ".$path." does not exist.");
		}
		if(is_array($data)) {
			extract($data);
		}
		ob_start();
		include($path.'header.php');
		$header = ob_get_contents();
		ob_end_clean();
		echo $header;
	}

	public function load_model($model) {
		
		$path = 'models/'.$model.'.php';
		if(file_exists($path)) {
			require_once($path);
		}
		else {
			throw new Exception('Model \''.$model.'\' not found in '.dirname($path));
		}
	
	}
}
?>
