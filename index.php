<?php
require_once('config.php');

//Take the initial PATH.
$url = $_SERVER['REQUEST_URI'];
$url = str_replace(BASE_DIR,"",$url);

//creates an array from the rest of the URL
$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);
print_r($array_tmp_uri);

//Here, we will define what is what in the URL
$array_uri['controller'] 	= $array_tmp_uri[0]; //a class
$array_uri['method']	= $array_tmp_uri[1]; //a function
$array_uri['var']		= $array_tmp_uri[2]; //a variable

//Load our base API
require_once("core/base.php");

//loads our controller
$application = new Application($array_uri);
$application->loadController($array_uri['controller']);
echo "index.php klar<br />";
?>
