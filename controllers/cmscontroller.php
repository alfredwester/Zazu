<?php
class CmsController extends Controller implements IController {
	public $model;
	private $config;

	function __construct($config) {
		$this->load_model('cmsmodel');
		$this->model = new CmsModel();
		$this->config = $config;
	}
	private function get_header() {
		$data = $this->config;
		$data += $this->model->get_menu();
		$data['head'] = "";
		if(isset($_SESSION['success'])) {
			$data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		}
		elseif(isset($_SESSION['errors'])) {
			$data['errors'] = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}
		return $data;
	}
	function index($post_url = null) {
		$post_id = 0;
		$type = 'start';
		$data = $this->get_header();
		
		if($post_url != null) {
			$post_id = $this->model->get_post_id($post_url);
			if($post_id == 0) {
				$this->redirect(404);
			}
		}	
		if($post_id > 0 && $post_id == $this->config['start_content']) {
			$this->redirect(301, '/');
		}
		elseif($post_id > 0) {
			$data = array_merge($data, $this->model->get_post($post_id));
			$type = 'post';
		}
		elseif(is_numeric($this->config['start_content']) && $this->config['start_content'] > 0) {
			$data = array_merge($data, $this->model->get_post($this->config['start_content']));
		}
		elseif(strncasecmp($this->config['start_content'], 'latest', 6) == 0) {
			$data = array_merge($data, $this->model->get_latest_posts(substr($this->config['start_content'], 6)));
		}
		else {
			$data = array_merge($data, $this->model->get_posts()); 
		}
		$data += $this->model->get_regions();
		$this->load_theme($this->config['theme'], $data, $type);
	}
}
?>