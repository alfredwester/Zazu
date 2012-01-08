<?php
class Helper {
	public function redirect($status, $url = null) {
		switch($status) {
			case 404:
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                echo "404 Not Found";
                exit;
            case 301:
                header($_SERVER['SERVER_PROTOCOL'].' 301 Moved Permanently');
                header('location: '.$url);
                exit;
            break;
        }
	}
}
