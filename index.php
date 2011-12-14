<?php

//Display errors in develop mode
error_reporting(E_ALL);

//bootstrap
require_once('core/bootstrap.php');

$z = Zazu::getInstance();

$z->frontController();
?>
