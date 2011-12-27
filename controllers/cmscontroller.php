<?php
class CmsController extends Controller implements IController{
	public $model;
	private $config;
	
	function __construct($config) {
		$this->load_model('cmsmodel');
		$this->model = new CmsModel();
		$this->config = $config;
	}

	function index() {
		$this->model->get_menu();
		$data = $this->model->get_header();
		$data = array_merge($data, $this->config);
		$data = array_merge($data, $this->model->get_menu());
		$this->load_theme($this->config['theme'], $data);
	}
}
?>
