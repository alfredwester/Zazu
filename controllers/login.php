<?php
class Login extends Controller implements IController {
	private $config;
	private $admin_model;
	
	public function __construct($config) {
		$this->config = $config;
		$this->load_model('adminmodel');
		$this->admin_model = new Adminmodel();
	}
	private function get_header() {
		$data['head'] = '';
		$data['admin_menu'] = array();
		return $data;
	}
	public function index(){
		$data = $this->config;
		$data += $this->get_header();
		if(isset($_SESSION['errors'])) {
			$data['errors'] = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}
		$this->load_theme($this->config['admin_theme'], $data, 'login_form');
	}
	public function login() {
		$user = $this->admin_model->check_login($_POST['username'], $_POST['password']);
		if($user > 0) {
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['user_role'] = $user['user_role'];
			$this->redirect(0, '/admin/');
		}
		else {
			$_SESSION['errors'][] = 'You have entered wrong username or password';
			$this->redirect(0, '/login/');
		}
		
	}
}