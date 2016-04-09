<?php
class Plugin extends Controller implements IController {
	private $plugin_model;
	private $config;
	private $permission_handler;

	public function __construct($config) {
		$this->load_model('pluginmodel');
		$this->plugin_model = new PluginModel();
		$this->config = $config;
		$this->permission_handler = new Permission_handler();
	}

	private function redirect_to_login() {
		$this->redirect(401, '/login');
	}

	public function index($url = null) {
		if ($this->permission_handler->get_role() !== 1) {
			$this->redirect_to_login();
		}
	}

	public function call_func($plugin_name, $function_name, $get_data = null) {
		$plugin_config = $this->plugin_model->get_plugin($plugin_name);
		$this->load_plugin($plugin_name);
		$plugin_controller = new $plugin_name();
		if (method_exists($plugin_controller, $function_name)) {
			$get_data = array($get_data);
			call_user_func_array(array($plugin_controller, $function_name), $get_data);
		} else {
			$this->redirect(404);
		}
	}

	public function install($plugin_name) {
		if ($this->permission_handler->get_role() !== 1) {
			$this->redirect_to_login();
		} else {
			if ($this->plugin_model->install(urldecode($plugin_name))) {
				$_SESSION['success'] = "Plugin '" . $plugin_name . "' sucessfully installed";
			} else {
				$_SESSION['errors'][] = "Plugin '" . $plugin_name . "' could not be installed";
			}
			$this->redirect(0, '/admin/plugins/');
		}
	}
	public function uninstall($id) {
		if ($this->permission_handler->get_role() !== 1) {
			$this->redirect_to_login();
		} else {
			if ($this->plugin_model->uninstall($id)) {
				$_SESSION['success'] = "Plugin uninstalled";
			} else {
				$_SESSION['errors'][] = "Plugin could not be uninstalled";
			}
			$this->redirect(0, '/admin/plugins/');
		}
	}

	public function delete($plugin_name) {
		if ($this->permission_handler->get_role() !== 1) {
			$this->redirect_to_login();
		} else {
			try {
				$this->delete_dir(PluginModel::PLUGIN_DIR . '/' . $plugin_name);
			} catch (Exception $e) {
				$_SESSION['errors'][] = "Could not delete plugin";
				$_SESSION['errors'][] = $e->getMessage();
			}
			$this->redirect(0, '/admin/plugins/');
		}
	}

	public function update($plugin_name) {
		if ($this->permission_handler->get_role() !== 1) {
			$this->redirect_to_login();
		} else {
			if ($this->plugin_model->update(urldecode($plugin_name))) {
				$_SESSION['success'] = "Plugin '" . $plugin_name . "' sucessfully updated";
			} else {
				$_SESSION['errors'][] = "Plugin '" . $plugin_name . "' could not be updated";
			}
			$this->redirect(0, '/admin/plugins/');
		}
	}
}