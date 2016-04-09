<?php
/* -----------------------------------
Do some bootstrapping, such as
including required files
--------------------------------------*/
if (!file_exists('config.php')) {
	die('No config.php file was found. Copy or rename the sample file and replace it with correct information, then you may need to run setup.php');
}

define("OFF", 0);
define("ERROR", 1);
define("INFO", 2);
define("DEBUG", 3);
define("TRACE", 4);

require_once 'config.php';

define("LOG_FILE", __DIR__."/../logs/zazu.log");

if (!defined("LOG_LEVEL")) {
	define("LOG_LEVEL", INFO);
}

function __autoload($class_name) {
	require_once strtolower($class_name . '.php');
}

interface IController {
	public function index();
}

interface IPluginInstaller {
	public function install();
	public function uninstall();
	public function update();
}

interface IPluginController {
	public function index($session);
	public function get_css_array();
	public function get_js_array();
}

interface IPluginAdminController {
	public function get_css_array();
	public function get_data();
	public function get_js_array();
}
?>
