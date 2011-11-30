<?php
class Start extends Application
{
	function __construct(){
		echo "start.php constructor <br />";
		$this->loadModel('Start_model');
		echo "start.php e constructor <br />";
	}

	function index(){
		$articles = $this->Start_model->select();
		$data['articles'] = $articles;
		$data['title'] = "site title";
		$this->loadView('start',$data);
		echo "startcontroller index function<br>";
	}

	function add($title=""){
		$data['title'] = $title;
		echo "Jupp detta add-funktionen";
	}
}

?>
