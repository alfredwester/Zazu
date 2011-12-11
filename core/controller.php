<?php
class Controller {

	public function load_view($view, $data = null) {
		$path = 'views/'.$view.'.php';
		if(is_array($data)) {
			extract($data);
		}
		if(file_exists($path)) {
			require_once($path);
		}
		else {
			die('View '.$view.' not found in '.$path);
		}
	}

	public function load_model($model) {
		
		$path = 'models/'.$model.'.php';
		if(file_exists($path)) {
			require_once($path);
		}
		else {
			die('Model '.$model.' not found in '.$path);
		}
	
	}
}
?>
