<?php
require_once "calendar_model.php";
class Calendar_admin_model extends Calendar_Model {
	private $db_handler;
	public function __construct() {
		parent::__construct();
		$this->db_handler = Db_handler::GetInstance();
	}

	public function insert_event($post_data) {
		$insert = $post_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO " . DB_PREFIX . "calendar_event( event_name, event_date, event_description, event_author) VALUES('"
			 . $event_name . "', '" . $event_date . " ". $event_time ."', '" . $event_description . "', " . $_SESSION['user_id'] . ");";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}

	public function get_event($id) {
		$id = $this->db_handler->db_escape_chars($id);
		$query = "SELECT event_id, event_name, event_date, event_description, event_author FROM " . DB_PREFIX . "calendar_event WHERE event_id=".$id;
		$result = $this->db_handler->select_query($query);
		$event = array();
		if ($obj = $result->fetch_object()) {
			$event['event_id'] = $obj->event_id;
			$event['event_name'] = $obj->event_name;
			$event['event_date'] = $obj->event_date;
			$event['event_description'] = $obj->event_description;
		}
		return $event;
	}

	public function update_event($id, $update_data) {
		$success = false;
		$id = $this->db_handler->db_escape_chars($id);
		$update_data = $this->db_handler->db_escape_chars($update_data);
		if(is_array($update_data)) {
			extract($update_data);
			$query = "UPDATE ".DB_PREFIX . "calendar_event SET event_name='".$event_name."', event_date='". $event_date . " ". $event_time ."', event_description='".$event_description."' WHERE event_id=".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}

	public function delete_event($id) {
		$id = $this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM " . DB_PREFIX . "calendar_event WHERE event_id;";
		return $this->db_handler->query($query);
	}
}
?>