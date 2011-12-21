<?php
class Start extends Controller implements IController{
	public $model;

	function __construct() {
		$this->load_model('model');
		$this->model = new Model();
	} 

	function index() {
		$data = $this->model->content();
		$this->load_view('someview', $data);
	}
}
?>
