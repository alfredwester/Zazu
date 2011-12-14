<?php
class Start extends Controller implements IController{
	public $model;

	function __construct() {
		$this->load_model('model');
		$this->model = new Model();
		
		//do the right things depending on what page you're on

	} 

	function index() {
		$data = $this->model->user_info();
		$this->load_view('someview', $data);
	}
}
?>
