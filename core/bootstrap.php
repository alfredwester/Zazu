<?php
/* -----------------------------------
	Do some bootstrapping, such as
	including required files
--------------------------------------*/
if(!file_exists('config.php')) {
	die('No config.php file was found. Copy or rename the sample file and replace it with correct information');
}

require_once('config.php');

function __autoload($class_name) {
	require_once(strtolower($class_name.'.php'));
}

interface IController {
	public function index();
}
?>
