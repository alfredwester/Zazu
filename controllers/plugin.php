<?php
class Plugin extends Controller implements IController {
	private $plugin_model;
	private $config;

	public function __construct($config) {
		$this->load_model('pluginmodel');
		$this->plugin_model = new PluginModel();
		$this->config = $config;
	}

	public function index() {
		if (!isset($_SESSION['user_id'])) {
			$this->redirect(401, '/login');
		}
	}
	public function install($plugin_name) {
		if ($this->plugin_model->install(urldecode($plugin_name))) {
			$_SESSION['success'] = "Plugin '" . $plugin_name . "' sucessfully installed";
		} else {
			$_SESSION['errors'][] = "Plugin '" . $plugin_name . "' could not be installed";
		}
		$this->redirect(0, '/admin/plugins/');
	}
	public function uninstall($id) {
		if ($this->plugin_model->uninstall($id)) {
			$_SESSION['success'] = "Plugin uninstalled";
		} else {
			$_SESSION['errors'][] = "Plugin could not be uninstalled";
		}
		$this->redirect(0, '/admin/plugins/');
	}
}