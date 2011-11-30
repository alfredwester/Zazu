<?php
class Application
{
	private $uri;
	private $model;

	function __construct($uri)
	{
		$this->uri = $uri;
		echo "base.php constructor <br />";
	}

	function loadController($class=null)
	{
		if(!isset($class) || empty($class)){
			$class=DEFAULT_CONTROLLER;
		}
		
		$file = "controllers/".$class.".php";
		
		echo "base.php loadController will load ".$file."<br />";

		if(!file_exists($file)) die("Controller not found");

		require_once($file);

		$controller = new $class();
		echo "base.php har laddat controller: $class<br />";

		if(method_exists($controller, $this->uri['method']))
		{
			$controller->{$this->uri['method']}($this->uri['var']);
		} else {
			$controller->index();
		}
	}

	function loadView($view,$vars="")
	{
		if(is_array($vars) && count($vars) > 0)
			extract($vars, EXTR_PREFIX_SAME, "wddx");
		require_once('views/'.$view.'.php');
	}

	function loadModel($model)
	{
		echo "base.php loadmodel <br />";
		require_once('models/'.$model.'.php');
		$this->$model = new $model;
		echo "base.php e loadmodel <br />";
	}
}


?>
