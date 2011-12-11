<?php
class Start extends Controller {
	public $model;

	function __construct() {
		$this->load_model('model');
		$this->model = new Model();
		
		//do the right things depending on what page you're on
		$this->home();
	} 

	function home() {
		$data = $this->model->user_info();
		$this->load_view('someview', $data);
	}
}
?>
