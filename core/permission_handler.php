<?php
class Permission_handler {
	private $author_permissions;
	private $editor_permissions;
	private $db_handler;
	
	public function __construct() {
		$this->db_handler = Db_handler::GetInstance();
		$this->author_permissions = array(	'me' => array(	'post' => array('view', 'delete', 'update', 'create'),
															'link' => array('view', 'delete', 'update', 'create'),
															'user' => array('view', 'update')),
											'other' =>array());
		$this->editor_permissions = array(	'me' => array(	'post' => array('view', 'delete', 'update', 'create'),
															'link' => array('view', 'delete', 'update', 'create'),
															'user' => array('view', 'update')),
											'other' =>array('post' => array('view', 'delete', 'update'),
															'link' => array('view', 'delete', 'update'), 
															'region' => array('view', 'update')));
	}
	public function has_permission($action, $type, $id) {
		$authorized = false;
		$role = $this->get_role($_SESSION['user_id']); //1- Admin, 2- Editor, 3- Author
		$permissions = array();
		switch($role) {
		case 1:
			return true;
			break;
		case 2:
			$permissions = $this->editor_permissions;
			break;
		case 3:
			$permissions = $this->author_permissions; 
			break;
		default:
			return false;
			break;
		}
		if(array_key_exists($type, $permissions['other'])) {
			if(in_array($action, $permissions['other'][$type])) {
				$authorized = true;
			}
		}
		if(array_key_exists($type, $permissions['me'])) {
			if($action == 'create' || $action == 'view') {
				if(in_array($action, $permissions['me'][$type])) {
					$authorized = true;
				}
			}
			else {
				if($type == 'user') {
					$query = "SELECT ".$type."_id FROM ".DB_PREFIX.$type." WHERE ".$type."_id = ".$id.";";
				}
				else {
					$query = "SELECT ".$type."_id FROM ".DB_PREFIX.$type." WHERE ".$type."_author = ".$_SESSION['user_id']." AND ".$type."_id = ".$id.";";
				}
				$result = $this->db_handler->select_query($query);
				$found = $result->num_rows;
				if($found > 0) {
					if(in_array($action, $permissions['me'][$type])) {
						$authorized = true;
					}
				}
			}
		}
		return $authorized;
	}
	public function get_role() {
		$query = "SELECT user_role FROM ".DB_PREFIX."user WHERE user_id = ".$_SESSION['user_id'].";";
		$result = $this->db_handler->select_query($query);
		$obj = $result->fetch_object();
		return $obj->user_role;
	}
	public function print_permissions() {
		echo "<b>author:</b> <br>";
		print_r($this->author_permissions);
		echo "<b>editor:</b> <br>";
		print_r($this->editor_permissions);
	} 
}