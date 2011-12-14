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
			throw new Exception('View \''.$view.'\' not found in '.dirname($path));
		}
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
