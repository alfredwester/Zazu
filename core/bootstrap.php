<?php
/* -----------------------------------
	Do some bootstrapping, such as
	including required files
--------------------------------------*/

function __autoload($class_name) {
	require_once(strtolower($class_name.'.php'));
}

interface IController {
	public function index();
}
?>
