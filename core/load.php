<?php
class Load {
	function view($file_name, $data = null) {
		if(is_array($data)) {
			extract($data);
		}
		if(file_exists('views/'.$file_name)) {
			include 'views/'.$file_name;
		}
		else {
			die('View '.$file_name.' not found');
		}
	}
}


?>
