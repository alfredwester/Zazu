<?php
class Admin extends Controller implements IController {
	private $cms_model;
	private $admin_model;
	private $plugin_model;
	private $config;
	private $menu;
	private $types;
	private $post_array;
	private $region_array;
	private $link_array;
	private $user_array;
	public $permission_handler;

	public function __construct($config) {
		if (!isset($_SESSION['user_id'])) {
			$this->redirect(401, '/login');
		}
		$this->load_model('cmsmodel');
		$this->load_model('adminmodel');
		$this->load_model('pluginmodel');
		$this->cms_model = new CmsModel();
		$this->plugin_model = new PluginModel();
		$this->admin_model = new Adminmodel($this->plugin_model);
		$this->post_array = $this->admin_model->get_post_array();
		$this->category_array = $this->admin_model->get_category_array();
		$this->region_array = $this->admin_model->get_region_array();
		$this->link_array = $this->admin_model->get_link_array();
		$this->user_array = $this->admin_model->get_user_array();
		$this->types = $this->admin_model->get_types();
		$this->config = $config;
		$this->menu = $this->admin_model->get_menu();
		$this->permission_handler = new Permission_handler();
		$this->add_plugins_to_menu();
	}
	private function add_plugins_to_menu() {
		$plugin_names = $this->plugin_model->get_plugin_names();
		$plugin_menu = array();
		// TODO: dheck permissions for each plugin
		foreach ($plugin_names as $plugin_name) {
			$plugin_menu[] = array('menu_title' => ucfirst($plugin_name), 'menu_text' => ucfirst($plugin_name), 'menu_url' => '/admin/plugin/' . $plugin_name);
		}

		$res = array_slice($this->menu, 0, count($this->menu) - 1, true);
		if ($this->admin_model->get_current_role() == 1) {
			$plugin_menu[] = array('type' => 'divider');
			$plugin_menu[] = array('menu_title' => 'Plugins management', 'menu_text' => 'Plugin management', 'menu_url' => '/admin/plugins');
			$res[] = array('menu_title' => 'Plugins', 'menu_text' => 'Plugins', 'menu_url' => '#', 'submenu' => $plugin_menu);
		} else {
			$res = array_merge($res, $plugin_menu);
		}
		$res = array_merge($res, array_slice($this->menu, count($this->menu) - 1, count($this->menu) - 1, true));
		$this->menu = $res;
	}
	private function get_header() {
		$data = $this->config;
		$data['admin_menu'] = $this->menu;
		$data['head'] = array();
		if (isset($_SESSION['success'])) {
			$data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		}
		if (isset($_SESSION['notice'])) {
			$data['notice'] = $_SESSION['notice'];
			unset($_SESSION['notice']);
		}
		if (isset($_SESSION['errors'])) {
			$data['errors'] = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}
		return $data;
	}
	public function logout() {
		unset($_SESSION['user_id']);
		$this->redirect(0, '/login');
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
		if (!$this->permission_handler->has_permission('view', 'category', null)) {
			$_SESSION['errors'][] = "You don't have permissions to view categories";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_categories());
		$this->load_theme($this->config['admin_theme'], $data, 'categories');
	}

	public function user_profile() {
		if (!$this->permission_handler->has_permission('view', 'user', null)) {
			$_SESSION['errors'][] = "You don't have permissions to view your profile";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->admin_model->get_user($_SESSION['user_id']));
		$this->load_theme($this->config['admin_theme'], $data, 'user_profile');

	}
	public function users() {
		if (!$this->permission_handler->has_permission('view', 'user', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage users";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->admin_model->get_users());
		$this->load_theme($this->config['admin_theme'], $data, 'users');
	}
	public function regions() {
		if (!$this->permission_handler->has_permission('view', 'region', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage regions";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_regions());
		$this->load_theme($this->config['admin_theme'], $data, 'regions');
	}
	public function links() {
		if (!$this->permission_handler->has_permission('view', 'link', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage links";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data = array_merge($data, $this->cms_model->get_menus());
		$this->load_theme($this->config['admin_theme'], $data, 'links');
	}
	public function settings() {
		if (!$this->permission_handler->has_permission('view', 'settings', null)) {
			$_SESSION['errors'][] = "You don't have permissions to view site settings";
			$this->redirect(0, '/admin/');
		}
		$data = $this->get_header();
		$data['config'] = $this->config;
		if (isset($_SESSION['settings'])) {
			$data['config'] = array_merge($data['config'], $_SESSION['settings']);
			unset($_SESSION['settings']);
		}
		$this->load_theme($this->config['admin_theme'], $data, 'settings_form');
	}
	public function plugins() {
		if (!$this->permission_handler->has_permission('view', 'plugins', null)) {
			$_SESSION['errors'][] = "You don't have permissions to manage plugins";
			$this->redirect(0, '/admin/');
		}
		$plugins_data = $this->plugin_model->get_plugins();
		$data = $this->get_header();
		$data['footer_js'][] = "theme/bootstrap/js/plugins.js";
		$data = array_merge($data, $plugins_data);
		$this->load_theme($this->config['admin_theme'], $data, 'plugins');
	}
	public function plugin($plugin_name) {
		$plugin_config = $this->plugin_model->get_plugin($plugin_name);
		if (empty($plugin_config)) {
			$this->redirect(404);
		}
		$admin_controller = $plugin_config["plugin_admin_controller"];
		$admin_view = $plugin_config["plugin_admin_view"];
		$this->load_plugin($plugin_name, $admin_controller);

		$plugin_admin_controller = new $admin_controller();
		$plugin_data = $plugin_admin_controller->get_data();
		$data = $this->get_header();
		// merga $data with plugin data
		$data = array_merge($data, $plugin_data);
		if (isset($_SESSION['additional_data']) && is_array($_SESSION['additional_data'])) {
			$data = array_merge($data, $_SESSION['additional_data']);
		}
		$data['head'] = $plugin_admin_controller->get_css_array();
		$data['footer_js'] = $plugin_admin_controller->get_js_array();
		$this->load_theme($this->config['admin_theme'], $data, 'plugin', $plugin_name, $admin_view);
	}

	public function call_plugin_func($plugin_name, $function_name, $get_data = null) {
		$plugin_config = $this->plugin_model->get_plugin($plugin_name);
		$admin_controller = $plugin_config["plugin_admin_controller"];
		$this->load_plugin($plugin_name, $admin_controller);
		$plugin_admin_controller = new $admin_controller();
		if (method_exists($plugin_admin_controller, $function_name)) {
			$get_data = array($get_data);
			call_user_func_array(array($plugin_admin_controller, $function_name), $get_data);
		} else {
			$this->redirect(404);
		}
	}

	//------------Actions-------------------
	public function delete($type = null, $id = null) {
		if (empty($type) || !in_array($type, $this->types)) {
			$this->redirect(404);
		}
		if ($type == 'post') {
			$redirect = '';
		} elseif ($type == 'category') {
			$redirect = 'categories';
		} else {
			$redirect = $type . 's';
		}
		if (is_numeric($id) && $id > 0) {
			if (!$this->permission_handler->has_permission('delete', $type, $id)) {
				$_SESSION['errors'][] = "You don't have permissions to delete this " . $type;
				$this->redirect(0, '/admin/' . $redirect);
			}
			$function = 'delete_' . $type;
			if ($this->admin_model->$function($id)) {
				$_SESSION['success'] = ucfirst($type) . " successfully deleted";
			} else {
				$_SESSION['errors'][] = ucfirst($type) . " could not be deleted";
			}
		} else {
			$_SESSION['errors'][] = ucfirst($type) . " id invalid";
		}
		$this->redirect(0, '/admin/' . $redirect);
	}
	public function add($type = null) {
		if (empty($type) || !in_array($type, $this->types)) {
			$this->redirect(404);
		}
		if ($type == 'post') {
			$redirect = '';
		} elseif ($type == 'category') {
			$redirect = 'categories';
		} else {
			$redirect = $type . 's';
		}
		if (!$this->permission_handler->has_permission('create', $type, null)) {
			$_SESSION['errors'][] = "You don't have permissions to create " . $type;
			$this->redirect(0, '/admin/' . $redirect);
		}
		$array_name = $type . '_array';
		$errors = $this->check_empty($this->$array_name, $_POST);
		if (empty($errors)) {
			$function = 'insert_' . $type;
			if ($this->admin_model->$function($_POST)) {
				$_SESSION['success'] = "New " . $type . " successlly created";
				$this->redirect(0, '/admin/' . $redirect);
			} else {
				$_SESSION['errors'][] = ucfirst($type) . " was not created, unknown database error";
			}
		} else {
			$_SESSION['errors'] = $errors;
			$_SESSION[$type] = $_POST;
		}
		$this->redirect(0, '/admin/new_edit/' . $type . '/');
	}
	public function edit($type = null, $id = null) {
		if (empty($type) || !in_array($type, $this->types)) {
			$this->redirect(404);
		}
		if (!$this->permission_handler->has_permission('update', $type, $id)) {
			$_SESSION['errors'][] = "You don't have permissions to update this " . $type;
			$this->redirect(0, '/admin/new_edit/' . $type . '/' . $id);
		}
		$array_name = $type . '_array';
		$errors = $this->check_empty($this->$array_name, $_POST);
		if (empty($errors)) {
			$function = 'update_' . $type;
			if ($this->admin_model->$function($_POST, $id)) {
				$_SESSION['success'] = ucfirst($type) . " successfully updated";
			} else {
				$_SESSION['notice'] = ucfirst($type) . " was not updated, maybe no change was made";
			}
		} else {
			$_SESSION['errors'] = $errors;
			$_SESSION[$type] = $_POST;
		}
		$this->redirect(0, '/admin/new_edit/' . $type . '/' . $id);
	}
	public function save_user_profile() {
		if (!$this->permission_handler->has_permission('update', 'user', $_SESSION['user_id'])) {
			$_SESSION['errors'][] = "You don't have permissions to update your profile";
			$this->redirect(0, '/admin/user_profile');
		}
		$array_name = 'user_array';
		$_POST['user_role'] = $this->admin_model->get_current_role();
		$errors = $this->check_empty($this->$array_name, $_POST);
		if (empty($errors)) {
			if ($this->admin_model->update_user($_POST, $_SESSION['user_id'])) {
				$_SESSION['success'] = "Your profile was successfully updated";
			} else {
				$_SESSION['notice'] = "Your profile was not updated, maybe no change was made";
			}
		} else {
			$_SESSION['errors'] = $errors;
			$_SESSION['user'] = $_POST;
		}
		$this->redirect(0, '/admin/user_profile');
	}
	public function save_settings() {
		if (!$this->permission_handler->has_permission('update', 'settings', null)) {
			$_SESSION['errors'][] = "You don't have permissions to update site settings ";
			$this->redirect(0, '/admin/settings/');
		}
		$errors = $this->check_empty(array_keys($this->config), $_POST);
		if (empty($errors)) {
			if ($this->admin_model->save_settings($_POST)) {
				$_SESSION['success'] = "Settings successfully saved";
			} else {
				$_SESSION['errors'][] = "Settings was not saved, unknown database error";
			}
		} else {
			$_SESSION['errors'] = $errors;
			$_SESSION['settings'] = $_POST;
		}
		$this->redirect(0, '/admin/settings/');
	}
	//-------------Forms----------------------
	public function new_edit($type = null, $id = null) {

		if (empty($type) || !in_array($type, $this->types)) {
			$this->redirect(404);
		}
		if ($type == 'post') {
			$redirect = '';
		} else {
			$redirect = $type . 's';
		}
		$data['action'] = 'add';
		$data[$type . '_id'] = '';
		$arry_name = $type . '_array';
		foreach ($this->$arry_name as $val) {
			$data[$val] = '';
		}
		$function = 'get_' . $type;
		if (is_numeric($id) && $id > 0) {
			if (!$this->permission_handler->has_permission('update', $type, $id)) {
				$_SESSION['errors'][] = "You don't have permissions to edit this " . $type;
				$this->redirect(0, '/admin/' . $redirect);
			}
			if ($type != 'user') {
				$existing_data = $this->cms_model->$function($id);
				$data = array_merge($data, $existing_data);
			} else {
				$existing_data = $this->admin_model->$function($id);
				$data = array_merge($data, $existing_data);
			}
			if (empty($existing_data)) {
				$this->redirect(0, '/admin/new_edit/' . $type);
			}
			$data[$type . '_id'] = $id;
			$data['action'] = 'edit';
		} else {
			if (!$this->permission_handler->has_permission('create', $type, null)) {
				$_SESSION['errors'][] = "You don't have permissions to create " . $type;
				$this->redirect(0, '/admin/' . $redirect);
			}
		}
		if ($type == 'user') {
			$data = array_merge($data, $this->admin_model->get_roles());
		} elseif ($type == 'post') {
			$data = array_merge($data, $this->cms_model->get_categories());
		}
		if (isset($_SESSION[$type])) {
			$data = array_merge($data, $_SESSION[$type]);
			unset($_SESSION[$type]);
		}
		$this->create_form($type, $data);
	}

	private function create_form($type, $input_data) {
		$data = $this->get_header();
		$data['head'] = array("include/summernote-0.6.4/summernote.css");
		$data['footer_js'] = array("include/summernote-0.6.4/summernote.min.js", "include/summernote-0.6.4/plugin/summernote-ext-fontstyle.js", "include/summernote-0.6.4/plugin/summernote-ext-video.js", "theme/bootstrap/js/textarea.js");
		if ($type == "post") {
			$data['footer_js'][] = "theme/bootstrap/js/post_form.js";
		}
		$data = array_merge($data, $input_data);
		$this->load_theme($this->config['admin_theme'], $data, $type . '_form');
	}

	public function upload_file() {
		if (isset($_FILES["file"])) {
			if (!$_FILES['file']['error']) {
				$allowed_types = array();
				$upload_dir = USER_UPLOAD_DIR;
				$upload_type = $_POST['upload_type'];
				switch ($upload_type) {
					case "editorimage":
						$allowed_types = $this->admin_model->get_allowed_image_file_types();
						break;
					case "plugin":
						$allowed_types = $this->admin_model->get_allowed_plugin_file_types();
						$upload_dir = "plugins";
						break;
				}
				if (in_array($_FILES['file']['type'], $allowed_types)) {
					$upload_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $upload_dir;
					if (!file_exists($upload_path) || !is_dir($upload_path)) {
						if (!mkdir($upload_path)) {
							$this->redirect(500, null, $upload_path . ' did not exist and could not be created');
						}
					} elseif (!is_writable($upload_path)) {
						$this->redirect(500, null, "Can not write to dir " . $upload_path);
					} else {
						$location = $_FILES["file"]["tmp_name"];
						if ($upload_type == "plugin") {
							$filename = $this->generate_filename(explode('.', $_FILES['file']["name"])[0]);
							$zip = new ZipArchive;
							$res = $zip->open($location);
							if ($res === TRUE) {
								$zip->extractTo($upload_path . '/' . $filename);
								$zip->close();
								if (!$this->plugin_model->verify_plugin($filename)) {
									$this->delete_dir($upload_path . '/' . $filename);
									$this->redirect(400, null, "Uploaded file [" . $_FILES['file']["name"] . "] is not a valid plugin");
								}
							} else {
								$this->redirect(500, null, "Could not extract zip file: " . $upload_path . "/" . $filename);
							}
						} else {
							$filename = $this->generate_filename($_FILES['file']["name"], true);
							move_uploaded_file($location, $upload_path . "/" . $filename);
						}
						echo "/" . $upload_dir . "/" . $filename;

					}
				} else {
					$allowed = "";
					foreach ($allowed_types as $key => $value) {
						$allowed .= $key . ", ";
					}
					$allowed = substr($allowed, 0, -2);
					$this->redirect(400, null, "File types allowed are: " . $allowed);
				}
			} else {
				$this->redirect(500, null, $this->get_file_upload_errormessage($_FILES['file']['error']));
			}
		} else {
			$this->redirect(400, null, "No file data");
		}
	}

	private function generate_filename($filename, $include_time = false) {
		$new_name = trim($filename);
		$new_name = strtolower($new_name);
		$ext = explode('.', $new_name);
		$search = array(' ', 'å', 'ä', 'ö', '=');
		$replace = array('_', 'a', 'a', 'o', '');
		$new_name = str_replace($search, $replace, $ext[0]);
		if ($include_time) {
			$new_name .= "_" . time();
		}
		if (count($ext) == 2) {
			$new_name .= "." . $ext[1];
		}
		return $new_name;
	}
}