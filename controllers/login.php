<?php
class Login extends Controller implements IController {
	private $config;
	private $admin_model;
	private $model;
	
	public function __construct($config) {
		$this->config = $config;
		$this->load_model('adminmodel');
		$this->load_model('cmsmodel');
		$this->admin_model = new Adminmodel();
		$this->model = new CmsModel();
	}
	private function get_header() {
		$data['head'] = '';
		$data += $this->model->get_menu();
		$data['admin_menu'] = array();
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
	public function index(){
		$data = $this->config;
		$data += $this->get_header();
		$data += $this->model->get_regions();
		$this->load_theme($this->config['theme'], $data, 'login_form');
	}
	public function login() {
		$user = $this->admin_model->check_login($_POST['username'], $_POST['password']);
		if(count($user) > 0) {
			$_SESSION['user_id'] = $user['user_id'];
			$this->redirect(0, '/admin/');
		}
		else {
			$_SESSION['errors'][] = 'You have entered wrong username or password';
			$this->redirect(0, '/login/');
		}
	}
	public function lost_password() {
		$data = $this->config;
		$data += $this->get_header();
		$this->load_theme($this->config['admin_theme'], $data, 'lost_password_form');
	}
	private function is_email($value) {
		$valid = false;
		if (!empty($value) && preg_match("/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i",$value ))
		{
			$valid = true;
		}
		return $valid;
	}
	private function generate_send_confirm_link($email) {
		$url = $this->admin_model->get_md5_link($email);
		$hostname = str_replace('www.', '', $_SERVER['HTTP_HOST']);
		
		$subject = 'Forgotten password instructions';

		$message = file_get_contents("messages/forgot_password");
		$message = str_replace(array('##host-url##', '##reset-url##', '##site-title##', '##webmaster-email##'), array($_SERVER['SERVER_NAME'], $email.'/'.$url, $this->config['site_title'], $this->config['webmaster_email']), $message);

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= "From: ".ucfirst($this->config['site_title'])." <no-reply@".$hostname.">\r\n";

		if(mail($email, $subject, $message, $headers)) {
			$_SESSION['success'] = "An email with further instructions was sent to your email";
		} 
		else {
			$_SESSION['errors'][] = "An email was not sent, please contact administrator";
		}
		$this->redirect(0, '/login/');
	}
	public function input_new_password($email = null, $magic_link = null) {
		if($email == null || $magic_link == null ) {
			$this->redirect(404);
		}
		if($this->admin_model->get_md5_link($email) == $magic_link) {
			$data = $this->config;
			$data += $this->get_header();
			$data['email'] = $email;
			$data['magic_link'] = $magic_link;
			$this->load_theme($this->config['admin_theme'], $data, 'new_password_form');
		}
		else {
			$_SESSION['errors'][] = 'The link has expired, klick \'Forgot password\' to generate a new one';
			$this->redirect(0, '/login/');
		}
	}
	public function new_password() {
		$errors = $this->check_empty(array('pass1', 'pass2', 'email', 'magic_link'), $_POST);
		if($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = "The passwords don't match";
		}
		if(empty($errors)) {
			if($this->admin_model->change_password($_POST['email'], $_POST['pass1'])) {
				$_SESSION['success'] = "Password successfully changed";
			}
			else {
				$_SESSION['errors'][] = 'Password was not changed, unknown database error';
			}
			$this->redirect(0, "/login/");
		}
		else {
			$_SESSION['errors'] = $errors;
			$this->redirect(0, "/login/input_new_password/".$_POST['email']."/".$_POST['magic_link']);
		}
	}
	public function send_new_pass_request() {
		if($this->is_email($_POST['email'])) {
			if($this->admin_model->user_exists($_POST['email'])) {
				$this->generate_send_confirm_link($_POST['email']);
			}
			else {
				$_SESSION['errors'][] = "User with email ".$_POST['email']." does not exist";
				$this->redirect(0, '/login/lost_password');
			}
		}
		else {
			$_SESSION['errors'][] = $_POST['email']." is not a valid email";
			$this->redirect(0, '/login/lost_password');
		}
	}
}
