<?php

//models are used to get and return things from the database

class PluginModel {

	private $db_handler;
	const PLUGIN_DIR = "plugins";

	function __construct() {
		$this->db_handler = Db_handler::GetInstance();
	}

	public function get_plugin($name) {
		$plugin = array();
		$name = $this->db_handler->db_escape_chars($name);
		$result = $this->db_handler->select_query("SELECT * FROM " . DB_PREFIX . "plugin WHERE plugin_name = '" . $name . "';");

		if ($obj = $result->fetch_array(MYSQLI_ASSOC)) {
			$plugin = $obj;
		}
		return $plugin;
	}

	public function get_plugin_names() {
		$plugins = array();
		$query = 'SELECT plugin_name FROM ' . DB_PREFIX . 'plugin;';
		$result = $this->db_handler->select_query($query);
		$count = 0;
		while ($obj = $result->fetch_object()) {
			$plugins[] = $obj->plugin_name;
			$count++;
		}
		return $plugins;
	}

	public function get_plugins() {
		$plugins = array();
		$query = 'SELECT plugin_id, plugin_name, plugin_version, plugin_description FROM ' . DB_PREFIX . 'plugin;';
		$result = $this->db_handler->select_query($query);
		$count = 0;
		while ($obj = $result->fetch_object()) {
			$plugins['plugins'][$count]['plugin_id'] = $obj->plugin_id;
			$plugins['plugins'][$count]['plugin_name'] = $obj->plugin_name;
			$plugins['plugins'][$count]['plugin_installed_version'] = $obj->plugin_version;
			$plugins['plugins'][$count]['plugin_description'] = $obj->plugin_description;
			$plugins['plugins'][$count]['plugin_installed'] = true;
			$count++;
		}

		if (is_dir(self::PLUGIN_DIR)) {
			if ($dh = opendir(self::PLUGIN_DIR)) {
				while (($file = readdir($dh)) !== false) {
					if ($file !== "." && $file !== "..") {
						$in_array = false;
						if (count($plugins) > 0) {
							for ($index = 0; $index < count($plugins['plugins']); $index++) {
								if ($plugins['plugins'][$index]['plugin_name'] == $file) {
									$plugin_ini = $this->read_plugin_config($file);
									$plugins['plugins'][$index]['plugin_version'] = $plugin_ini['version'];
									$in_array = true;
								}
							}
						}
						if (!$in_array && $this->verify_plugin($file, false)) {
							$plugin_ini = $this->read_plugin_config($file);
							$plugins['plugins'][$count]['plugin_name'] = $plugin_ini['name'];
							$plugins['plugins'][$count]['plugin_dir_name'] = $file;
							$plugins['plugins'][$count]['plugin_description'] = $plugin_ini['description'];
							$plugins['plugins'][$count]['plugin_installed'] = false;
							$plugins['plugins'][$count]['plugin_version'] = $plugin_ini['version'];
							$plugins['plugins'][$count]['plugin_installed_version'] = null;
							$count++;
						}
					}
				}
				closedir($dh);
			}
		}

		return $plugins;
	}

	public function verify_plugin($plugin_name, $silent = true) {
		$plugin_config = $this->read_plugin_config($plugin_name, $silent);
		if (empty($plugin_config)) {
			return false;
		} else {
			$exists = true;
			$exists = $exists && array_key_exists('description', $plugin_config) ? true : false;
			$exists = $exists && array_key_exists('admin_controller', $plugin_config) ? true : false;
			$exists = $exists && array_key_exists('admin_view', $plugin_config) ? true : false;
			$exists = $exists && array_key_exists('setup_file', $plugin_config) ? true : false;
			return $exists;
		}
	}

	private function read_plugin_config($plugin_name, $silent = false) {
		$path = self::PLUGIN_DIR . "/" . $plugin_name;
		$ini_file = $path . "/plugin.ini";
		$plugin_ini = array();
		if (is_dir($path)) {
			if (is_readable($ini_file)) {
				$plugin_ini = parse_ini_file($ini_file);
			} elseif (!$silent) {
				$_SESSION['errors'][] = "Could not read config: " . $ini_file;
			}
		}
		return $plugin_ini;
	}

	public function get_plugin_name_from_file($plugin_tmp_name) {
		$plugin_ini = $this->read_plugin_config($plugin_tmp_name, true);
		return $plugin_ini['name'];
	}

	public function install($plugin_name) {
		$plugin_ini = $this->read_plugin_config($plugin_name);
		$plugin_description = $plugin_ini['description'];
		$plugin_admin_controller = $plugin_ini['admin_controller'];
		$plugin_admin_view = $plugin_ini['admin_view'];
		$plugin_version = $plugin_ini['version'];
		$success = false;

		$name = $this->db_handler->db_escape_chars($plugin_name);
		$description = $this->db_handler->db_escape_chars($plugin_description);
		$admin_controller = $this->db_handler->db_escape_chars($plugin_admin_controller);
		$admin_view = $this->db_handler->db_escape_chars($plugin_admin_view);
		$version = $this->db_handler->db_escape_chars($plugin_version);
		$query = "INSERT INTO " . DB_PREFIX . "plugin(plugin_name, plugin_version, plugin_description, plugin_admin_controller, plugin_admin_view)
		VALUES('" . $name . "', '" . $version . "', '" . $description . "', '" . $admin_controller . "', '" . $admin_view . "');";
		$success = $this->db_handler->query($query);

		if (array_key_exists('setup_file', $plugin_ini)) {
			$plugin_setupfile = $plugin_ini['setup_file'];
			$this->load_install_file($plugin_name, $plugin_setupfile);
			$installer = $plugin_name . "installer";
			$plugin_installer = new $installer();
			$plugin_installer->install();
		}

		return $success;
	}

	public function update($plugin_name) {
		$plugin_ini = $this->read_plugin_config($plugin_name);
		$success = false;
		$name = $this->db_handler->db_escape_chars($plugin_name);
		$description = $this->db_handler->db_escape_chars($plugin_ini['description']);
		$admin_controller = $this->db_handler->db_escape_chars($plugin_ini['admin_controller']);
		$admin_view = $this->db_handler->db_escape_chars($plugin_ini['admin_view']);
		$version = $this->db_handler->db_escape_chars($plugin_ini['version']);

		$query = "UPDATE " . DB_PREFIX . "plugin
		SET plugin_version='" . $version . "', plugin_description='" . $description . "', plugin_admin_controller='" . $admin_controller . "', plugin_admin_view='" . $admin_view . "'
		WHERE plugin_name ='" . $plugin_name . "';";
		$success = $this->db_handler->query($query);

		if (array_key_exists('setup_file', $plugin_ini)) {
			$plugin_setupfile = $plugin_ini['setup_file'];
			$this->load_install_file($plugin_name, $plugin_setupfile);
			$installer = $plugin_name . "installer";
			$plugin_installer = new $installer();
			$plugin_installer->update();
		}

		return $success;
	}

	private function load_install_file($plugin, $file) {
		$path = self::PLUGIN_DIR . "/" . $plugin . '/' . $file . '.php';
		if (file_exists($path)) {
			require_once $path;
		} else {
			die("nothing at path: " . $path);
		}
	}
	public function uninstall($plugin_name) {
		$plugin_ini = $this->read_plugin_config($plugin_name);
		$success = false;
		if (array_key_exists('setup_file', $plugin_ini)) {
			$plugin_setupfile = $plugin_ini['setup_file'];
			$this->load_install_file($plugin_name, $plugin_setupfile);
			$installer = $plugin_name . "installer";
			$plugin_installer = new $installer();
			$plugin_installer->uninstall();
		}
		$plugin_name = $this->db_handler->db_escape_chars($plugin_name);
		$query = "DELETE FROM " . DB_PREFIX . "plugin WHERE plugin_name ='" . $plugin_name . "';";
		$success = $this->db_handler->query($query);

		return $success;
	}
}
?>