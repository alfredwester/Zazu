<?php
class Controller extends Site_controller {
	public $model;

	function __construct() {
		parent::__construct();	
		$this->load->model('model');
		$this->model = new Model();
		
		//do the right things depending on what page you're on
		$this->home();
	} 

	function home() {
		
		$data = $this->model->user_info();
		$this->load->view('someview', $data);
	}
}
?>
