<?php
class Admin extends Controller implements IController {
	private $cms_model;
	private $admin_model;
	private $config;
	private $menu;
	private $post_array;
	private $region_array;
	private $link_array;
	private $user_array;
	
	public function __construct($config) {
		if(!isset($_SESSION['user_id'])) {
			$this->redirect(0, '/login/');
		}
		$this->load_model('cmsmodel');
		$this->load_model('adminmodel');
		$this->cms_model = new Cmsmodel();
		$this->admin_model = new Adminmodel();
		$this->post_array = $this->admin_model->get_post_array();
		$this->region_array = $this->admin_model->get_region_array();
		$this->link_array = $this->admin_model->get_link_array();
		$this->user_array = $this->admin_model->get_user_array();
		$this->config = $config;
		$this->menu = $this->admin_model->get_menu();
	}
	private function get_header() {
		$data = $this->config;
		$data['admin_menu'] = $this->menu;
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
	public function logout() {
		unset($_SESSION['user_id']);
		$this->redirect(0, '/login/');
	}
	public function index() {
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_posts());
		$this->load_theme($this->config['admin_theme'], $data);
	}
	public function users() {
		$data = $this->get_header();
		$data = array_merge($data, $this->admin_model->get_users());
		$this->load_theme($this->config['admin_theme'], $data, 'users');
	}
	public function regions() {
		$data = $this->get_header();
		if($_SESSION['user_role'] != 3) {
			$data = array_merge($data, $this->cms_model->get_regions());
			$this->load_theme($this->config['admin_theme'], $data, 'regions');
		}
		else {
			$_SESSION['errors'][] = "You don't have permissions to manage regions";
			$this->redirect(0, '/admin/');
		}
	}
	public function links() {
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_menus());
		$this->load_theme($this->config['admin_theme'], $data, 'links');
	}
	public function settings() {
		$data = $this->get_header();
		if($_SESSION['user_role'] != 1) {
			$_SESSION['errors'][] = "You don't have permissions to manage Site Settings";
			$this->redirect(0, '/admin/');
		}
		else {
			$data['config'] = $this->config;
			if(isset($_SESSION['settings'])) {
				$data['config'] = array_merge($data['config'], $_SESSION['settings']);
				unset($_SESSION['settings']);
			}
			$this->load_theme($this->config['admin_theme'], $data, 'settings_form');
		}
	}
	public function delete($type, $id)
	{
		if(is_numeric($id) && $id >0){
			$function = 'delete_'.$type;
			if($type == 'post') {
				$found_post = $this->cms_model->get_post($id);
				if($found_post['post_author_id'] == $_SESSION['user_id'] ||  $_SESSION['user_role'] !=3) {
					if($this->admin_model->$function($id)) {
						$_SESSION['success'] = ucfirst($type)." successfully deleted";
					}
					else {
						$_SESSION['errors'][] = ucfirst($type)." was not deleted, unknown database error";
					}
				}
				else {
					$_SESSION['errors'][] = "You dont have permissions to delete the selected post";
					$this->redirect(0, '/admin/');
				}
			}
			elseif($type == 'region') {
				if($_SESSION['user_role'] !=1) {
					$_SESSION['errors'][] = "You dont have permissions to delete the selected region";
					$this->redirect(0, '/admin/regions/');
				}
				elseif($this->admin_model->$function($id)) {
					$_SESSION['success'] = ucfirst($type)." successfully deleted";
				}
				else {
					$_SESSION['errors'][] = ucfirst($type)." was not deleted, unknown database error";
				}
			}
			elseif($type == 'link') {
				if($_SESSION['user_role'] !=3) {
					if($this->admin_model->$function($id)) {
						$_SESSION['success'] = ucfirst($type)." successfully deleted";
					}
					else {
						$_SESSION['errors'][] = ucfirst($type)." was not deleted, unknown database error";
					}
				}
				else {
					$_SESSION['errors'][] = "You dont have permissions to delete the selected link";
					$this->redirect(0, '/admin/');
				}
			}
			else {
				$_SESSION['errors'][] = ucfirst($type)." was not deleted, unknown database error";
			}
		}
		else {
			$_SESSION['errors'][] = ucfirst($type)." id invalid";
		}
		if($type == 'post') {
			$type = '';
		}
		else {
			$type = $type.'s';
		}
		$this->redirect(0, '/admin/'.$type);
	}
	public function new_edit($type, $id = null) {
		$data['action'] = 'add';
		$data[$type.'_id'] = '';
		$arry_name = $type.'_array';
		foreach($this->$arry_name as $val) {
			$data[$val] = '';
		}
		$function = 'get_'.$type;
		if(is_numeric($id) && $id >0) {
			$found_post = $this->cms_model->$function($id);
			if($type == 'post') {
				if($found_post['post_author_id'] == $_SESSION['user_id'] ||  $_SESSION['user_role'] !=3) {
					$data = array_merge($data, $found_post);
				}
				else {
					$_SESSION['errors'][] = "You dont have permissions to edit the selected post";
					$this->redirect(0, '/admin/');
				}
			}
			elseif($type != 'user') {
				$data = array_merge($data, $this->cms_model->$function($id));
			}
			else {
				$data = array_merge($data, $this->admin_model->$function($id));
			}
			$data[$type.'_id'] = $id;
			$data['action'] = 'edit';
		}
		if($type == 'user') {
				$data = array_merge($data, $this->admin_model->get_roles());
		}
		if(isset($_SESSION[$type])) {
			$data = array_merge($data, $_SESSION[$type]);
			unset($_SESSION[$type]);
		}
		$this->create_form($type.'_form', $data);
	}
	private function check_empty($key_array, $data) {
		$data_empty = array();
		foreach($key_array as $val) {
			if(!isset($data[$val]) || !is_numeric($data[$val]) && (empty($data[$val]) || $data[$val] == "")) {
				$data_empty[] = str_replace('_', ' ', ucfirst($val)).' was empty';
			}
		}
		return $data_empty;
	}
	public function add($type) {
		$array_name = $type.'_array';
		$errors = $this->check_empty($this->$array_name, $_POST);
		if(empty($errors)) {
			$function = 'insert_'.$type;
			if($this->admin_model->$function($_POST)) {
				$_SESSION['success'] = "New ".$type." sucessfully created";
				if($type == 'post') {
					$type = '';
				}
				else {
					$type = $type.'s';
				}
				$this->redirect(0, '/admin/'.$type);
			}
			else {
				$_SESSION['errors'][] = ucfirst($type)." was not created, unknown database error";
			}
		}
		else {
			$_SESSION['errors'] = $errors;
			$_SESSION[$type] = $_POST;
		}
		$this->redirect(0, '/admin/new_edit/'.$type.'/');
	}
	public function edit($type, $id) {
		$array_name = $type.'_array';
		$errors = $this->check_empty($this->$array_name, $_POST);
		if(empty($errors)) {
			$function = 'update_'.$type;
			if($this->admin_model->$function($_POST, $id)) {
				$_SESSION['success'] = ucfirst($type)." sucessfully updated";
			}
			else {
				$_SESSION['errors'][] = ucfirst($type)." was not updated, unknown database error";
			}
		}
		else {
			$_SESSION['errors'] = $errors;
			$_SESSION[$type] = $_POST;
		}
		$this->redirect(0, '/admin/new_edit/'.$type.'/'.$id);
	}
	public function save_settings() {
		$errors = $this->check_empty(array_keys($this->config), $_POST);
		if(empty($errors)) {
			if($this->admin_model->save_settings($_POST)) {
				$_SESSION['success'] = "Settings sucessfully saved";
			}
			else {
				$_SESSION['errors'][] = "Settings was not saved, unknown database error";
			}
		}
		else {
			$_SESSION['errors'] = $errors;
			$_SESSION['settings'] = $_POST;
		}
		$this->redirect(0, '/admin/settings/');
	}
	private function create_form($type, $input_data) {
		$data = $this->get_header();
		$data['head'] = $this->get_standard_tinymce_head();
		$data = array_merge($data, $input_data);
		$this->load_theme($this->config['admin_theme'], $data, $type);
	}
}