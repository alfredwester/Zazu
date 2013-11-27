<?php
class Admin extends Controller implements IController {
	private $cms_model;
	private $admin_model;
	private $config;
	private $menu;
	private $types;
	private $post_array;
	private $region_array;
	private $link_array;
	private $user_array;
	public $permission_handler;
	
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
		$this->types = $this->admin_model->get_types();
		$this->config = $config;
		$this->menu = $this->admin_model->get_menu();
		$this->permission_handler = new Permission_handler();
	}
	private function get_header() {
		$data = $this->config;
		$data['admin_menu'] = $this->menu;
		$data['head'] = "";
		if(isset($_SESSION['success'])) {
			$data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		}
		if(isset($_SESSION['notice'])) {
			$data['notice'] = $_SESSION['notice'];
			unset($_SESSION['notice']);
		}
		if(isset($_SESSION['errors'])) {
			$data['errors'] = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}
		return $data;
	}
	public function logout() {
		unset($_SESSION['user_id']);
		$this->redirect(0, '/login/');
	}
	
	//------------Lists-------------------
	public function index() {
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_posts());
		$this->load_theme($this->config['admin_theme'], $data);
		/* echo "<pre><b>Permissions: </b><br />";
		$this->permission_handler->print_permissions();
		echo "</pre>"; */
	}
	public function categories() {
		if(!$this->permission_handler->has_permission('view', 'category', null)) {
			$_SESSION['errors'][] = "You don't have permissions to view categories";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_categories());
		$this->load_theme($this->config['admin_theme'], $data, 'categories');
	}

	public function user_profile() {
		if(!$this->permission_handler->has_permission('view', 'user', null)) {
			$_SESSION['errors'][] = "You don't have permissions to view your profile";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->admin_model->get_user($_SESSION['user_id']));
		$this->load_theme($this->config['admin_theme'], $data, 'user_profile');
	
	}
	public function users() {
		if(!$this->permission_handler->has_permission('view', 'user', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage users";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->admin_model->get_users());
		$this->load_theme($this->config['admin_theme'], $data, 'users');
	}
	public function regions() {
		if(!$this->permission_handler->has_permission('view', 'region', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage regions";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_regions());
		$this->load_theme($this->config['admin_theme'], $data, 'regions');
	}
	public function links() {
		if(!$this->permission_handler->has_permission('view', 'link', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage links";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_menus());
		$this->load_theme($this->config['admin_theme'], $data, 'links');
	}
	public function settings() {
		if(!$this->permission_handler->has_permission('view', 'settings', null)) {
			$_SESSION['errors'][] = "You don't have permissions to view site settings";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data['config'] = $this->config;
		if(isset($_SESSION['settings'])) {
			$data['config'] = array_merge($data['config'], $_SESSION['settings']);
			unset($_SESSION['settings']);
		}
		$this->load_theme($this->config['admin_theme'], $data, 'settings_form');
	}
	
	//------------Actions-------------------
	public function delete($type = null, $id = null) {
		if(empty($type) || !in_array($type, $this->types)){
			$this->redirect(404);
		}
		if($type == 'post') {
			$redirect = '';
		}
		else {
			$redirect = $type.'s';
		}
		if(is_numeric($id) && $id >0){
			if(!$this->permission_handler->has_permission('delete', $type, $id)) {
				$_SESSION['errors'][] = "You don't have permissions to delete this ".$type;
				$this->redirect(0, '/admin/'.$redirect);
			}
			$function = 'delete_'.$type;
			if($this->admin_model->$function($id)) {
				$_SESSION['success'] = ucfirst($type)." successfully deleted";
			}
			else {
				$_SESSION['errors'][] = ucfirst($type)." was not deleted, probobly not found";
			}
		}
		else {
			$_SESSION['errors'][] = ucfirst($type)." id invalid";
		}
		$this->redirect(0, '/admin/'.$redirect);
	}
	public function add($type = null) {
		if(empty($type) || !in_array($type, $this->types)){
			$this->redirect(404);
		}
		if($type == 'post') {
			$redirect = '';
		}
		else {
			$redirect = $type.'s';
		}
		if(!$this->permission_handler->has_permission('create', $type, null)) {
			$_SESSION['errors'][] = "You don't have permissions to create ".$type;
			$this->redirect(0, '/admin/'.$redirect);
		}
		$array_name = $type.'_array';
		$errors = $this->check_empty($this->$array_name, $_POST);
		if(empty($errors)) {
			$function = 'insert_'.$type;
			if($this->admin_model->$function($_POST)) {
				$_SESSION['success'] = "New ".$type." successlly created";
				$this->redirect(0, '/admin/'.$redirect);
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
	public function edit($type = null, $id = null) {
		if(empty($type) || !in_array($type, $this->types)){
			$this->redirect(404);
		}
		if(!$this->permission_handler->has_permission('update', $type, $id)) {
			$_SESSION['errors'][] = "You don't have permissions to update this ".$type;
			$this->redirect(0, '/admin/new_edit/'.$type.'/'.$id);
		}
		$array_name = $type.'_array';
		$errors = $this->check_empty($this->$array_name, $_POST);
		if(empty($errors)) {
			$function = 'update_'.$type;
			if($this->admin_model->$function($_POST, $id)) {
				$_SESSION['success'] = ucfirst($type)." successfully updated";
			}
			else {
				$_SESSION['notice'] = ucfirst($type)." was not updated, maybe no change was made";
			}
		}
		else {
			$_SESSION['errors'] = $errors;
			$_SESSION[$type] = $_POST;
		}
		$this->redirect(0, '/admin/new_edit/'.$type.'/'.$id);
	}
	public function save_user_profile() {
		if(!$this->permission_handler->has_permission('update', 'user', $_SESSION['user_id'])) {
			$_SESSION['errors'][] = "You don't have permissions to update your profile";
			$this->redirect(0, '/admin/user_profile');
		}
		$array_name = 'user_array';
		$_POST['user_role'] = $this->admin_model->get_current_role();
		$errors = $this->check_empty($this->$array_name, $_POST);
		if(empty($errors)) {
			if($this->admin_model->update_user($_POST, $_SESSION['user_id'])) {
				$_SESSION['success'] = "Your profile was successfully updated";
			}
			else {
				$_SESSION['notice'] = "Your profile was not updated, maybe no change was made";
			}
		}
		else {
			$_SESSION['errors'] = $errors;
			$_SESSION['user'] = $_POST;
		}
		$this->redirect(0, '/admin/user_profile');
	}
	public function save_settings() {
		if(!$this->permission_handler->has_permission('update', 'settings', null)) {
			$_SESSION['errors'][] = "You don't have permissions to update site settings ";
			$this->redirect(0, '/admin/settings/');
		}
		$errors = $this->check_empty(array_keys($this->config), $_POST);
		if(empty($errors)) {
			if($this->admin_model->save_settings($_POST)) {
				$_SESSION['success'] = "Settings successfully saved";
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
	//-------------Forms----------------------
	public function new_edit($type = null, $id = null) {
		
		if(empty($type) || !in_array($type, $this->types)){
			$this->redirect(404);
		}
		if($type == 'post') {
			$redirect = '';
		}
		else {
			$redirect = $type.'s';
		}
		$data['action'] = 'add';
		$data[$type.'_id'] = '';
		$arry_name = $type.'_array';
		foreach($this->$arry_name as $val) {
			$data[$val] = '';
		}
		$function = 'get_'.$type;
		if(is_numeric($id) && $id >0) {
			if(!$this->permission_handler->has_permission('update', $type, $id)) {
				$_SESSION['errors'][] = "You don't have permissions to edit this ".$type;
				$this->redirect(0, '/admin/'.$redirect);
			}
			if($type != 'user') {
				$existing_data = $this->cms_model->$function($id);
				$data = array_merge($data,$existing_data);
			}
			else {
				$existing_data = $this->admin_model->$function($id);
				$data = array_merge($data, $existing_data);
			}
			if(empty($existing_data)) {
				$this->redirect(0, '/admin/new_edit/'.$type);
			}
			$data[$type.'_id'] = $id;
			$data['action'] = 'edit';
		}
		else {
			if(!$this->permission_handler->has_permission('create', $type, null)) {
				$_SESSION['errors'][] = "You don't have permissions to create ".$type;
				$this->redirect(0, '/admin/'.$redirect);
			}
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
	private function create_form($type, $input_data) {
		$data = $this->get_header();
		$data['head'] = $this->get_bootstrap_wysihtml5_head();
		$data['footer_js'] = $this->get_bootstrap_wysihtml5_footer();
		$data = array_merge($data, $input_data);
		$this->load_theme($this->config['admin_theme'], $data, $type);
	}
}
