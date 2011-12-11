<?php
/* -----------------------------------
	Do some bootstrapping, such as
	including rquired files
--------------------------------------*/

function __autoload($class_name) {
	require_once(strtolower($class_name.'.php'));
}

require_once('zazu.php');
require_once('load.php');


?>
